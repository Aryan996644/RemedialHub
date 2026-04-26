<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Result;
use App\Models\Course;
use App\Models\CourseRecommendation;
use App\Models\CourseEnrollment;
use App\Models\CourseVideo;
use App\Models\CourseArticle;
use App\Models\RemedialClass;
use App\Models\ClassAttendance;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\ProgressReport;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    private function student()
    {
        return Student::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard()
    {
        $student = $this->student();
        $latestResult = $student->latestResult;
        $hasAssessment = $latestResult !== null;

        $recommendedCourses = CourseRecommendation::where('student_id', $student->id)->count();
        $upcomingClass = RemedialClass::where('student_id', $student->id)
            ->where('status', 'upcoming')->orderBy('scheduled_at')->first();
        $assignmentsDue = Assignment::where('student_id', $student->id)
            ->where('status', 'pending')->count();
        $attendanceCount = ClassAttendance::where('student_id', $student->id)
            ->where('status', 'joined')->count();
        $totalClasses = RemedialClass::where('student_id', $student->id)->count();
        $attendancePercent = $totalClasses > 0 ? round(($attendanceCount / $totalClasses) * 100) : 0;

        $progressReport = ProgressReport::where('student_id', $student->id)->latest()->first();
        $progressPercent = $progressReport ? $progressReport->progress_percentage : 0;

        $assessments = Assessment::where('status', 'active')
            ->withCount('questions')->get();

        return view('student.dashboard', compact(
            'student', 'latestResult', 'hasAssessment', 'recommendedCourses',
            'upcomingClass', 'assignmentsDue', 'attendancePercent',
            'progressPercent', 'progressReport', 'assessments'
        ));
    }

    // ─── Assessment Flow ────────────────────────────────────────────
    public function assessmentStart()
    {
        $student = $this->student();
        $assessments = Assessment::where('status', 'active')
            ->withCount('questions')
            ->get();

        $completedAssessmentIds = Result::where('student_id', $student->id)->pluck('assessment_id');

        return view('student.assessment.start', compact('assessments', 'completedAssessmentIds'));
    }

    public function assessmentTest($id)
    {
        $student = $this->student();
        $assessment = Assessment::with('questions')->findOrFail($id);

        // Check if already taken
        $existingResult = Result::where('assessment_id', $id)
            ->where('student_id', $student->id)->first();

        if ($existingResult) {
            return redirect()->route('student.result')->with('info', 'You have already completed this assessment.');
        }

        $questions = $assessment->questions;

        return view('student.assessment.test', compact('assessment', 'questions'));
    }

    public function submitTest(Request $request, $id)
    {
        $student = $this->student();
        $assessment = Assessment::with('questions')->findOrFail($id);

        // Prevent duplicate
        $existingResult = Result::where('assessment_id', $id)
            ->where('student_id', $student->id)->first();

        if ($existingResult) {
            return redirect()->route('student.result')->with('info', 'Already submitted.');
        }

        // Calculate score
        $score = 0;
        $totalMarks = 0;
        foreach ($assessment->questions as $question) {
            $totalMarks += $question->marks;
            $answerKey = 'question_' . $question->id;
            if ($request->has($answerKey) && $request->input($answerKey) === $question->correct_option) {
                $score += $question->marks;
            }
        }

        $percentage = $totalMarks > 0 ? round(($score / $totalMarks) * 100, 2) : 0;

        // Determine skill level
        if ($percentage < 40) {
            $skillLevel = 'beginner';
            $status = 'slow_learner';
        } elseif ($percentage <= 70) {
            $skillLevel = 'intermediate';
            $status = 'intermediate';
        } else {
            $skillLevel = 'advanced';
            $status = 'advanced';
        }

        $result = Result::create([
            'assessment_id' => $assessment->id,
            'student_id' => $student->id,
            'score' => $score,
            'total_marks' => $totalMarks,
            'percentage' => $percentage,
            'skill_level' => $skillLevel,
            'status' => $status,
        ]);

        // Auto-recommend courses based on category and skill level
        $recommendedCourses = Course::where('category', $assessment->category)
            ->where('level', $skillLevel)
            ->where('status', 'approved')
            ->get();

        if ($recommendedCourses->isEmpty()) {
            $recommendedCourses = Course::where('level', $skillLevel)
                ->where('status', 'approved')->get();
        }

        foreach ($recommendedCourses as $course) {
            CourseRecommendation::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'result_id' => $result->id,
                'reason' => "Based on your {$skillLevel} skill level in {$assessment->category}. Score: {$percentage}%",
            ]);
        }

        return redirect()->route('student.result')->with('success', 'Test submitted successfully!');
    }

    // ─── Results ────────────────────────────────────────────────────
    public function result()
    {
        $student = $this->student();
        $results = Result::with('assessment')
            ->where('student_id', $student->id)
            ->latest()->get();
        $latestResult = $results->first();

        return view('student.result.index', compact('results', 'latestResult'));
    }

    // ─── Recommended Courses ────────────────────────────────────────
    public function recommendedCourses()
    {
        $student = $this->student();
        $recommendations = CourseRecommendation::with(['course.teacher.user', 'course' => function($q) {
            $q->withCount(['videos', 'articles']);
        }, 'result'])->where('student_id', $student->id)->latest()->get();

        return view('student.courses.recommended', compact('recommendations'));
    }

    // ─── All Courses Catalog ─────────────────────────────────────────
    public function allCourses(Request $request)
    {
        $student = $this->student();

        $query = Course::with(['teacher.user'])
            ->withCount(['videos', 'articles', 'enrollments'])
            ->where('status', 'approved');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('category', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
            });
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $courses = $query->latest()->get();

        // Get enrolled course IDs for this student
        $enrolledCourseIds = CourseEnrollment::where('student_id', $student->id)->pluck('course_id')->toArray();

        // Get recommended course IDs
        $recommendedCourseIds = CourseRecommendation::where('student_id', $student->id)->pluck('course_id')->toArray();

        // All distinct categories
        $categories = Course::where('status', 'approved')->distinct()->pluck('category');

        return view('student.courses.index', compact(
            'courses', 'enrolledCourseIds', 'recommendedCourseIds', 'categories'
        ));
    }

    // ─── Course Detail ──────────────────────────────────────────────
    public function courseDetail($id)
    {
        $student = $this->student();
        $course = Course::with(['teacher.user', 'videos', 'articles',
            'remedialClasses' => fn($q) => $q->where('student_id', $student->id),
            'assignments' => fn($q) => $q->where('student_id', $student->id),
        ])->withCount(['videos', 'articles'])->findOrFail($id);

        $enrolled = CourseEnrollment::where('student_id', $student->id)
            ->where('course_id', $id)->exists();
        $progress = ProgressReport::where('student_id', $student->id)
            ->where('course_id', $id)->latest()->first();

        return view('student.courses.show', compact('course', 'enrolled', 'progress', 'student'));
    }

    // ─── Video Lessons ──────────────────────────────────────────────
    public function videos()
    {
        $student = $this->student();
        $enrolledCourseIds = CourseEnrollment::where('student_id', $student->id)->pluck('course_id');
        $videos = CourseVideo::whereIn('course_id', $enrolledCourseIds)
            ->with('course')->orderBy('order_no')->get();
        return view('student.videos.index', compact('videos'));
    }

    // ─── Articles ───────────────────────────────────────────────────
    public function articles()
    {
        $student = $this->student();
        $enrolledCourseIds = CourseEnrollment::where('student_id', $student->id)->pluck('course_id');
        $articles = CourseArticle::whereIn('course_id', $enrolledCourseIds)
            ->with('course')->orderBy('order_no')->get();
        return view('student.articles.index', compact('articles'));
    }

    // ─── Remedial Classes ───────────────────────────────────────────
    public function remedialClasses()
    {
        $student = $this->student();
        $upcomingClasses = RemedialClass::where('student_id', $student->id)
            ->whereIn('status', ['upcoming', 'live'])
            ->with(['teacher.user', 'course'])
            ->orderBy('scheduled_at')->get();

        $completedClasses = RemedialClass::where('student_id', $student->id)
            ->where('status', 'completed')
            ->with(['teacher.user', 'course'])->get();

        $attendances = ClassAttendance::where('student_id', $student->id)
            ->pluck('status', 'remedial_class_id');

        return view('student.remedial-classes.index', compact('upcomingClasses', 'completedClasses', 'attendances'));
    }

    // ─── Assignments ────────────────────────────────────────────────
    public function assignments()
    {
        $student = $this->student();
        $assignments = Assignment::where('student_id', $student->id)
            ->with(['course', 'latestSubmission'])->latest()->get();
        return view('student.assignments.index', compact('assignments'));
    }

    public function submitAssignment(Request $request, $id)
    {
        $student = $this->student();
        $assignment = Assignment::where('student_id', $student->id)->findOrFail($id);

        $request->validate([
            'answer_text' => 'required|string',
            'file' => 'nullable|file|max:10240',
        ]);

        $data = [
            'assignment_id' => $assignment->id,
            'student_id' => $student->id,
            'answer_text' => $request->answer_text,
            'status' => 'submitted',
            'submitted_at' => now(),
        ];

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('submissions', 'public');
        }

        Submission::create($data);
        $assignment->update(['status' => 'submitted']);

        return redirect()->route('student.assignments')->with('success', 'Assignment submitted!');
    }

    // ─── Progress ───────────────────────────────────────────────────
    public function progress()
    {
        $student = $this->student();
        $reports = ProgressReport::where('student_id', $student->id)
            ->with(['course', 'teacher.user'])->latest()->get();

        $results = Result::where('student_id', $student->id)->latest()->get();
        $enrollments = CourseEnrollment::where('student_id', $student->id)->count();
        $classesJoined = ClassAttendance::where('student_id', $student->id)
            ->where('status', 'joined')->count();
        $assignmentsSubmitted = Submission::where('student_id', $student->id)->count();

        return view('student.progress.index', compact(
            'reports', 'results', 'enrollments', 'classesJoined', 'assignmentsSubmitted'
        ));
    }
}
