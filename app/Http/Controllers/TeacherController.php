<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\CourseArticle;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Result;
use App\Models\RemedialClass;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\ProgressReport;
use App\Models\CourseRecommendation;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    private function teacher()
    {
        return Teacher::where('user_id', auth()->id())->firstOrFail();
    }

    public function dashboard()
    {
        $teacher = $this->teacher();
        $myStudents = Student::whereHas('assignments', fn($q) => $q->where('teacher_id', $teacher->id))
            ->orWhereHas('remedialClasses', fn($q) => $q->where('teacher_id', $teacher->id))
            ->distinct()->count();
        $coursesCreated = $teacher->courses()->count();
        $testsCreated = $teacher->assessments()->count();

        $slowLearners = Result::whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->where('status', 'slow_learner')->distinct('student_id')->count('student_id');
        $upcomingClasses = RemedialClass::where('teacher_id', $teacher->id)
            ->where('status', 'upcoming')->count();
        $pendingSubmissions = Submission::whereHas('assignment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->where('status', 'submitted')->count();

        $results = Result::whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id));
        $avgScore = $results->count() > 0 ? round($results->avg('percentage'), 1) : 0;

        $improvedStudents = ProgressReport::where('teacher_id', $teacher->id)
            ->where('status', 'Improved')->distinct('student_id')->count('student_id');

        $studentPerformance = Result::with(['student.user', 'assessment'])
            ->whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->latest()->take(10)->get();

        $upcomingClassList = RemedialClass::with(['student.user', 'course'])
            ->where('teacher_id', $teacher->id)
            ->where('status', 'upcoming')
            ->orderBy('scheduled_at')->take(5)->get();

        $pendingSubmissionsList = Submission::with(['assignment.course', 'student.user'])
            ->whereHas('assignment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->where('status', 'submitted')->latest()->take(5)->get();

        $slowLearnerList = Result::with(['student.user', 'assessment'])
            ->whereHas('assessment', fn($q) => $q->where('teacher_id', $teacher->id))
            ->where('status', 'slow_learner')->latest()->take(5)->get();

        return view('teacher.dashboard', compact(
            'myStudents', 'coursesCreated', 'testsCreated', 'slowLearners',
            'upcomingClasses', 'pendingSubmissions', 'avgScore', 'improvedStudents',
            'studentPerformance', 'upcomingClassList', 'pendingSubmissionsList', 'slowLearnerList'
        ));
    }

    public function myStudents()
    {
        $teacher = $this->teacher();
        $students = Student::with(['user', 'latestResult'])
            ->whereHas('assignments', fn($q) => $q->where('teacher_id', $teacher->id))
            ->orWhereHas('remedialClasses', fn($q) => $q->where('teacher_id', $teacher->id))
            ->orWhereHas('results', function($q) use ($teacher) {
                $q->whereHas('assessment', fn($q2) => $q2->where('teacher_id', $teacher->id));
            })
            ->distinct()->get();
        return view('teacher.students.index', compact('students'));
    }
}
