<?php

namespace App\Http\Controllers;

use App\Models\ClassAttendance;
use App\Models\RemedialClass;
use App\Models\Student;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function markAttendance(Request $request, $classId)
    {
        $student = Student::where('user_id', auth()->id())->firstOrFail();
        $class = RemedialClass::findOrFail($classId);

        $existing = ClassAttendance::where('remedial_class_id', $classId)
            ->where('student_id', $student->id)->first();

        if ($existing) {
            return back()->with('info', 'Attendance already recorded.');
        }

        ClassAttendance::create([
            'remedial_class_id' => $classId,
            'student_id' => $student->id,
            'status' => 'joined',
            'joined_at' => now(),
        ]);

        return redirect($class->meeting_link);
    }

    public function teacherMarkAttendance(Request $request, $classId)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'status' => 'required|in:present,absent,late,joined',
        ]);

        ClassAttendance::updateOrCreate(
            ['remedial_class_id' => $classId, 'student_id' => $request->student_id],
            ['status' => $request->status, 'joined_at' => $request->status !== 'absent' ? now() : null]
        );

        return back()->with('success', 'Attendance updated.');
    }
}
