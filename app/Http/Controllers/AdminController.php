<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Assessment;
use App\Models\Result;
use App\Models\RemedialClass;
use App\Models\Assignment;
use App\Models\ProgressReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalStudents = Student::count();
        $totalTeachers = Teacher::count();
        $totalCourses = Course::count();
        $totalTests = Assessment::count();
        $slowLearners = Result::where('status', 'slow_learner')->distinct('student_id')->count('student_id');
        $upcomingClasses = RemedialClass::where('status', 'upcoming')->count();
        $pendingAssignments = Assignment::where('status', 'pending')->count();
        $avgProgress = ProgressReport::avg('progress_percentage') ?? 0;

        $recentStudents = Student::with('user')->latest()->take(5)->get();
        $recentResults = Result::with(['student.user', 'assessment'])->latest()->take(5)->get();
        $slowLearnerAlerts = Result::with(['student.user', 'assessment'])
            ->where('status', 'slow_learner')->latest()->take(5)->get();
        $upcomingRemedialClasses = RemedialClass::with(['teacher.user', 'student.user', 'course'])
            ->where('status', 'upcoming')->orderBy('scheduled_at')->take(5)->get();
        $pendingCourses = Course::with('teacher.user')->where('status', 'pending')->get();

        return view('admin.dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalCourses', 'totalTests',
            'slowLearners', 'upcomingClasses', 'pendingAssignments', 'avgProgress',
            'recentStudents', 'recentResults', 'slowLearnerAlerts',
            'upcomingRemedialClasses', 'pendingCourses'
        ));
    }

    // ─── Teachers CRUD ─────────────────────────────────────────────
    public function teachers()
    {
        $teachers = Teacher::with('user')->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function createTeacher()
    {
        return view('admin.teachers.create');
    }

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'employee_id' => 'required|unique:teachers,employee_id',
            'department' => 'required|string',
            'subject' => 'required|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'status' => 'active',
        ]);

        Teacher::create([
            'user_id' => $user->id,
            'employee_id' => $request->employee_id,
            'department' => $request->department,
            'subject' => $request->subject,
        ]);

        return redirect()->route('admin.teachers')->with('success', 'Teacher added successfully.');
    }

    public function editTeacher($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $teacher->user_id,
            'employee_id' => 'required|unique:teachers,employee_id,' . $id,
            'department' => 'required|string',
            'subject' => 'required|string',
        ]);

        $teacher->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $teacher->user->update(['password' => Hash::make($request->password)]);
        }

        $teacher->update([
            'employee_id' => $request->employee_id,
            'department' => $request->department,
            'subject' => $request->subject,
        ]);

        return redirect()->route('admin.teachers')->with('success', 'Teacher updated successfully.');
    }

    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->user->delete();
        return redirect()->route('admin.teachers')->with('success', 'Teacher deleted successfully.');
    }

    public function toggleTeacher($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        $teacher->user->update([
            'status' => $teacher->user->status === 'active' ? 'inactive' : 'active',
        ]);
        return redirect()->route('admin.teachers')->with('success', 'Teacher status updated.');
    }

    // ─── Students CRUD ─────────────────────────────────────────────
    public function students()
    {
        $students = Student::with(['user', 'latestResult'])->get();
        return view('admin.students.index', compact('students'));
    }

    public function createStudent()
    {
        return view('admin.students.create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'roll_no' => 'required|unique:students,roll_no',
            'department' => 'required|string',
            'semester' => 'required|string',
            'section' => 'nullable|string',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
            'status' => 'active',
        ]);

        Student::create([
            'user_id' => $user->id,
            'roll_no' => $request->roll_no,
            'department' => $request->department,
            'semester' => $request->semester,
            'section' => $request->section,
        ]);

        return redirect()->route('admin.students')->with('success', 'Student added successfully.');
    }

    public function editStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'roll_no' => 'required|unique:students,roll_no,' . $id,
            'department' => 'required|string',
            'semester' => 'required|string',
        ]);

        $student->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $student->user->update(['password' => Hash::make($request->password)]);
        }

        $student->update([
            'roll_no' => $request->roll_no,
            'department' => $request->department,
            'semester' => $request->semester,
            'section' => $request->section,
        ]);

        return redirect()->route('admin.students')->with('success', 'Student updated successfully.');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->user->delete();
        return redirect()->route('admin.students')->with('success', 'Student deleted successfully.');
    }

    public function toggleStudent($id)
    {
        $student = Student::with('user')->findOrFail($id);
        $student->user->update([
            'status' => $student->user->status === 'active' ? 'inactive' : 'active',
        ]);
        return redirect()->route('admin.students')->with('success', 'Student status updated.');
    }

    // ─── Courses ────────────────────────────────────────────────────
    public function courses()
    {
        $courses = Course::with(['teacher.user'])->withCount(['videos', 'articles'])->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function approveCourse($id)
    {
        Course::findOrFail($id)->update(['status' => 'approved']);
        return back()->with('success', 'Course approved.');
    }

    public function rejectCourse($id)
    {
        Course::findOrFail($id)->update(['status' => 'rejected']);
        return back()->with('success', 'Course rejected.');
    }

    // ─── Assessments ────────────────────────────────────────────────
    public function assessments()
    {
        $assessments = Assessment::with('teacher.user')
            ->withCount(['questions', 'results'])
            ->get()
            ->map(function ($a) {
                $a->avg_score = $a->results->count() > 0
                    ? round($a->results->avg('percentage'), 1) : 0;
                return $a;
            });
        return view('admin.assessments.index', compact('assessments'));
    }

    // ─── Slow Learners ─────────────────────────────────────────────
    public function slowLearners(Request $request)
    {
        $query = Result::with(['student.user', 'assessment'])
            ->where('status', 'slow_learner');

        if ($request->filled('department')) {
            $query->whereHas('student', fn($q) => $q->where('department', $request->department));
        }
        if ($request->filled('category')) {
            $query->whereHas('assessment', fn($q) => $q->where('category', $request->category));
        }

        $slowLearners = $query->latest()->get();
        $departments = Student::distinct()->pluck('department');
        $categories = Assessment::distinct()->pluck('category');

        return view('admin.slow-learners.index', compact('slowLearners', 'departments', 'categories'));
    }

    // ─── Remedial Classes ───────────────────────────────────────────
    public function remedialClasses()
    {
        $classes = RemedialClass::with(['teacher.user', 'student.user', 'course'])
            ->orderBy('scheduled_at', 'desc')->get();
        return view('admin.remedial-classes.index', compact('classes'));
    }

    // ─── Assignments ────────────────────────────────────────────────
    public function assignments()
    {
        $assignments = Assignment::with(['course', 'teacher.user', 'student.user'])->latest()->get();
        return view('admin.assignments.index', compact('assignments'));
    }

    // ─── Progress Reports ───────────────────────────────────────────
    public function reports()
    {
        $reports = ProgressReport::with(['student.user', 'teacher.user', 'course'])->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }
}
