<?php

namespace App\Http\Controllers;

use App\Models\CourseEnrollment;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function enroll(Request $request)
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();

        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        $existing = CourseEnrollment::where('student_id', $student->id)
            ->where('course_id', $request->course_id)->first();

        if ($existing) {
            return back()->with('info', 'You are already enrolled in this course.');
        }

        CourseEnrollment::create([
            'student_id' => $student->id,
            'course_id' => $request->course_id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        return back()->with('success', 'Enrolled successfully!');
    }
}
