<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseVideoController;
use App\Http\Controllers\CourseArticleController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\RemedialClassController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\ProgressReportController;

// ─── Public Routes ──────────────────────────────────────────────────
Route::get('/', [AuthController::class, 'welcome'])->name('welcome');
Route::get('/admin/login', [AuthController::class, 'adminLoginForm'])->name('admin.login');
Route::get('/teacher/login', [AuthController::class, 'teacherLoginForm'])->name('teacher.login');
Route::get('/student/login', [AuthController::class, 'studentLoginForm'])->name('student.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ─── Admin Routes ───────────────────────────────────────────────────
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Teachers
    Route::get('/teachers', [AdminController::class, 'teachers'])->name('admin.teachers');
    Route::get('/teachers/create', [AdminController::class, 'createTeacher'])->name('admin.teachers.create');
    Route::post('/teachers', [AdminController::class, 'storeTeacher'])->name('admin.teachers.store');
    Route::get('/teachers/{id}/edit', [AdminController::class, 'editTeacher'])->name('admin.teachers.edit');
    Route::put('/teachers/{id}', [AdminController::class, 'updateTeacher'])->name('admin.teachers.update');
    Route::delete('/teachers/{id}', [AdminController::class, 'deleteTeacher'])->name('admin.teachers.delete');
    Route::patch('/teachers/{id}/toggle', [AdminController::class, 'toggleTeacher'])->name('admin.teachers.toggle');

    // Students
    Route::get('/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/students/create', [AdminController::class, 'createStudent'])->name('admin.students.create');
    Route::post('/students', [AdminController::class, 'storeStudent'])->name('admin.students.store');
    Route::get('/students/{id}/edit', [AdminController::class, 'editStudent'])->name('admin.students.edit');
    Route::put('/students/{id}', [AdminController::class, 'updateStudent'])->name('admin.students.update');
    Route::delete('/students/{id}', [AdminController::class, 'deleteStudent'])->name('admin.students.delete');
    Route::patch('/students/{id}/toggle', [AdminController::class, 'toggleStudent'])->name('admin.students.toggle');

    // Courses
    Route::get('/courses', [AdminController::class, 'courses'])->name('admin.courses');
    Route::patch('/courses/{id}/approve', [AdminController::class, 'approveCourse'])->name('admin.courses.approve');
    Route::patch('/courses/{id}/reject', [AdminController::class, 'rejectCourse'])->name('admin.courses.reject');

    // Assessments
    Route::get('/assessments', [AdminController::class, 'assessments'])->name('admin.assessments');

    // Slow Learners
    Route::get('/slow-learners', [AdminController::class, 'slowLearners'])->name('admin.slow-learners');

    // Remedial Classes
    Route::get('/remedial-classes', [AdminController::class, 'remedialClasses'])->name('admin.remedial-classes');

    // Assignments
    Route::get('/assignments', [AdminController::class, 'assignments'])->name('admin.assignments');

    // Reports
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
});

// ─── Teacher Routes ─────────────────────────────────────────────────
Route::prefix('teacher')->middleware(['auth', 'role:teacher'])->group(function () {
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::get('/my-students', [TeacherController::class, 'myStudents'])->name('teacher.students');

    // Courses
    Route::get('/courses', [CourseController::class, 'index'])->name('teacher.courses');
    Route::get('/courses/create', [CourseController::class, 'create'])->name('teacher.courses.create');
    Route::post('/courses', [CourseController::class, 'store'])->name('teacher.courses.store');
    Route::get('/courses/{id}', [CourseController::class, 'show'])->name('teacher.courses.show');
    Route::get('/courses/{id}/edit', [CourseController::class, 'edit'])->name('teacher.courses.edit');
    Route::put('/courses/{id}', [CourseController::class, 'update'])->name('teacher.courses.update');
    Route::delete('/courses/{id}', [CourseController::class, 'destroy'])->name('teacher.courses.destroy');

    // Videos
    Route::get('/videos', [CourseVideoController::class, 'index'])->name('teacher.videos');
    Route::post('/videos', [CourseVideoController::class, 'store'])->name('teacher.videos.store');
    Route::get('/videos/{id}/edit', [CourseVideoController::class, 'edit'])->name('teacher.videos.edit');
    Route::put('/videos/{id}', [CourseVideoController::class, 'update'])->name('teacher.videos.update');
    Route::delete('/videos/{id}', [CourseVideoController::class, 'destroy'])->name('teacher.videos.destroy');

    // Articles
    Route::get('/articles', [CourseArticleController::class, 'index'])->name('teacher.articles');
    Route::post('/articles', [CourseArticleController::class, 'store'])->name('teacher.articles.store');
    Route::get('/articles/{id}/edit', [CourseArticleController::class, 'edit'])->name('teacher.articles.edit');
    Route::put('/articles/{id}', [CourseArticleController::class, 'update'])->name('teacher.articles.update');
    Route::delete('/articles/{id}', [CourseArticleController::class, 'destroy'])->name('teacher.articles.destroy');

    // Assessments
    Route::get('/assessments', [AssessmentController::class, 'index'])->name('teacher.assessments');
    Route::get('/assessments/create', [AssessmentController::class, 'create'])->name('teacher.assessments.create');
    Route::post('/assessments', [AssessmentController::class, 'store'])->name('teacher.assessments.store');
    Route::get('/assessments/{id}/edit', [AssessmentController::class, 'edit'])->name('teacher.assessments.edit');
    Route::put('/assessments/{id}', [AssessmentController::class, 'update'])->name('teacher.assessments.update');
    Route::delete('/assessments/{id}', [AssessmentController::class, 'destroy'])->name('teacher.assessments.destroy');

    // Questions
    Route::get('/questions', [QuestionController::class, 'index'])->name('teacher.questions');
    Route::post('/questions', [QuestionController::class, 'store'])->name('teacher.questions.store');
    Route::get('/questions/{id}/edit', [QuestionController::class, 'edit'])->name('teacher.questions.edit');
    Route::put('/questions/{id}', [QuestionController::class, 'update'])->name('teacher.questions.update');
    Route::delete('/questions/{id}', [QuestionController::class, 'destroy'])->name('teacher.questions.destroy');

    // Results
    Route::get('/results', [ResultController::class, 'teacherResults'])->name('teacher.results');

    // Slow Learners
    Route::get('/slow-learners', [ResultController::class, 'slowLearners'])->name('teacher.slow-learners');

    // Remedial Classes
    Route::get('/remedial-classes', [RemedialClassController::class, 'index'])->name('teacher.remedial-classes');
    Route::post('/remedial-classes', [RemedialClassController::class, 'store'])->name('teacher.remedial-classes.store');
    Route::patch('/remedial-classes/{id}/status', [RemedialClassController::class, 'updateStatus'])->name('teacher.remedial-classes.status');
    Route::delete('/remedial-classes/{id}', [RemedialClassController::class, 'destroy'])->name('teacher.remedial-classes.destroy');
    Route::post('/remedial-classes/{id}/attendance', [AttendanceController::class, 'teacherMarkAttendance'])->name('teacher.attendance.mark');

    // Assignments
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('teacher.assignments');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('teacher.assignments.store');
    Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy'])->name('teacher.assignments.destroy');

    // Submissions
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('teacher.submissions');
    Route::post('/submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('teacher.submissions.grade');

    // Progress
    Route::get('/progress', [ProgressReportController::class, 'index'])->name('teacher.progress');
    Route::post('/progress', [ProgressReportController::class, 'store'])->name('teacher.progress.store');
    Route::put('/progress/{id}', [ProgressReportController::class, 'update'])->name('teacher.progress.update');
});

// ─── Student Routes ─────────────────────────────────────────────────
Route::prefix('student')->middleware(['auth', 'role:student'])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');

    // Assessment
    Route::get('/assessment/start', [StudentController::class, 'assessmentStart'])->name('student.assessment.start');
    Route::get('/assessment/test/{id}', [StudentController::class, 'assessmentTest'])->name('student.assessment.test');
    Route::post('/assessment/submit/{id}', [StudentController::class, 'submitTest'])->name('student.assessment.submit');

    // Result
    Route::get('/result', [StudentController::class, 'result'])->name('student.result');

    // Courses
    Route::get('/courses', [StudentController::class, 'allCourses'])->name('student.courses.all');
    Route::get('/recommended-courses', [StudentController::class, 'recommendedCourses'])->name('student.recommended-courses');
    Route::get('/courses/{id}', [StudentController::class, 'courseDetail'])->name('student.courses.show');
    Route::post('/enroll', [EnrollmentController::class, 'enroll'])->name('student.enroll');

    // Videos
    Route::get('/videos', [StudentController::class, 'videos'])->name('student.videos');

    // Articles
    Route::get('/articles', [StudentController::class, 'articles'])->name('student.articles');

    // Remedial Classes
    Route::get('/remedial-classes', [StudentController::class, 'remedialClasses'])->name('student.remedial-classes');
    Route::post('/remedial-classes/{id}/join', [AttendanceController::class, 'markAttendance'])->name('student.class.join');

    // Assignments
    Route::get('/assignments', [StudentController::class, 'assignments'])->name('student.assignments');
    Route::post('/assignments/{id}/submit', [StudentController::class, 'submitAssignment'])->name('student.assignments.submit');

    // Progress
    Route::get('/progress', [StudentController::class, 'progress'])->name('student.progress');
});
