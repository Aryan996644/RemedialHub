<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\CourseVideo;
use App\Models\CourseArticle;
use App\Models\Assessment;
use App\Models\Question;
use App\Models\Result;
use App\Models\CourseRecommendation;
use App\Models\CourseEnrollment;
use App\Models\RemedialClass;
use App\Models\ClassAttendance;
use App\Models\Assignment;
use App\Models\Submission;
use App\Models\ProgressReport;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin ──────────────────────────────────────────────────
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // ─── Teachers ───────────────────────────────────────────────
        $teacherUser1 = User::create([
            'name' => 'Prof. Ahmed Khan',
            'email' => 'teacher@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);
        $teacher1 = Teacher::create([
            'user_id' => $teacherUser1->id,
            'employee_id' => 'EMP001',
            'department' => 'Computer Science',
            'subject' => 'Programming',
        ]);

        $teacherUser2 = User::create([
            'name' => 'Dr. Fatima Ali',
            'email' => 'teacher2@example.com',
            'password' => Hash::make('password'),
            'role' => 'teacher',
            'status' => 'active',
        ]);
        $teacher2 = Teacher::create([
            'user_id' => $teacherUser2->id,
            'employee_id' => 'EMP002',
            'department' => 'Mathematics',
            'subject' => 'Mathematics',
        ]);

        // ─── Students ───────────────────────────────────────────────
        $samirUser = User::create([
            'name' => 'Samir',
            'email' => 'samir@example.com',
            'password' => Hash::make('password'),
            'role' => 'student',
            'status' => 'active',
        ]);
        $samir = Student::create([
            'user_id' => $samirUser->id,
            'roll_no' => 'STU001',
            'department' => 'Computer Science',
            'semester' => '3rd',
            'section' => 'A',
        ]);

        $studentUsers = [];
        $students = [];
        $names = ['Aisha Patel', 'Rahul Sharma', 'Priya Singh', 'Omar Hassan'];
        foreach ($names as $i => $name) {
            $u = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'student',
                'status' => 'active',
            ]);
            $s = Student::create([
                'user_id' => $u->id,
                'roll_no' => 'STU00' . ($i + 2),
                'department' => $i < 2 ? 'Computer Science' : 'Mathematics',
                'semester' => ($i + 2) . 'nd',
                'section' => $i % 2 == 0 ? 'A' : 'B',
            ]);
            $studentUsers[] = $u;
            $students[] = $s;
        }

        // ─── Courses ────────────────────────────────────────────────
        $course1 = Course::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Basic Programming',
            'description' => 'A beginner course covering fundamentals of programming including variables, loops, and basic syntax.',
            'category' => 'Programming',
            'level' => 'beginner',
            'duration' => '4 weeks',
            'status' => 'approved',
        ]);

        $course2 = Course::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Intermediate Programming',
            'description' => 'Build on your basics with functions, OOP concepts, and data structures.',
            'category' => 'Programming',
            'level' => 'intermediate',
            'duration' => '6 weeks',
            'status' => 'approved',
        ]);

        $course3 = Course::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Advanced Programming',
            'description' => 'Master advanced concepts including design patterns, algorithms, and system design.',
            'category' => 'Programming',
            'level' => 'advanced',
            'duration' => '8 weeks',
            'status' => 'approved',
        ]);

        $course4 = Course::create([
            'teacher_id' => $teacher2->id,
            'title' => 'Basic Mathematics',
            'description' => 'Fundamental math concepts including algebra, geometry, and basic calculus.',
            'category' => 'Mathematics',
            'level' => 'beginner',
            'duration' => '4 weeks',
            'status' => 'approved',
        ]);

        $course5 = Course::create([
            'teacher_id' => $teacher2->id,
            'title' => 'Intermediate Mathematics',
            'description' => 'Intermediate topics including trigonometry, matrices, and statistics.',
            'category' => 'Mathematics',
            'level' => 'intermediate',
            'duration' => '6 weeks',
            'status' => 'approved',
        ]);

        $course6 = Course::create([
            'teacher_id' => $teacher2->id,
            'title' => 'Advanced Mathematics',
            'description' => 'Advanced topics including differential equations, linear algebra, and probability.',
            'category' => 'Mathematics',
            'level' => 'advanced',
            'duration' => '8 weeks',
            'status' => 'pending',
        ]);

        // ─── Course Videos ──────────────────────────────────────────
        $videoData = [
            [$course1->id, 'What is Programming?', 'https://www.youtube.com/watch?v=example1', '15 min', 1],
            [$course1->id, 'Variables and Data Types', 'https://www.youtube.com/watch?v=example2', '20 min', 2],
            [$course1->id, 'Loops and Conditions', 'https://www.youtube.com/watch?v=example3', '25 min', 3],
            [$course2->id, 'Functions and Scope', 'https://www.youtube.com/watch?v=example4', '22 min', 1],
            [$course2->id, 'Object-Oriented Programming', 'https://www.youtube.com/watch?v=example5', '30 min', 2],
            [$course2->id, 'Data Structures Basics', 'https://www.youtube.com/watch?v=example6', '28 min', 3],
            [$course4->id, 'Introduction to Algebra', 'https://www.youtube.com/watch?v=example7', '18 min', 1],
            [$course4->id, 'Solving Equations', 'https://www.youtube.com/watch?v=example8', '20 min', 2],
        ];

        foreach ($videoData as $v) {
            CourseVideo::create([
                'course_id' => $v[0], 'title' => $v[1], 'video_url' => $v[2],
                'duration' => $v[3], 'order_no' => $v[4],
            ]);
        }

        // ─── Course Articles ────────────────────────────────────────
        $articleData = [
            [$course1->id, 'Programming Basics Notes', 'Learn the fundamental concepts of programming. This guide covers what programming is, why it matters, and how to get started with your first program.', 1],
            [$course1->id, 'Practice Examples', 'A collection of practice problems covering variables, loops, and conditional statements to solidify your understanding.', 2],
            [$course1->id, 'Basic Syntax Guide', 'Quick reference guide for basic programming syntax including variable declaration, control flow, and function definitions.', 3],
            [$course2->id, 'Functions Deep Dive', 'Comprehensive guide to functions including parameters, return values, scope, closures, and best practices.', 1],
            [$course2->id, 'OOP Concepts Summary', 'Summary of object-oriented programming covering classes, objects, inheritance, polymorphism, and encapsulation.', 2],
            [$course4->id, 'Algebra Fundamentals', 'Core algebra concepts including expressions, equations, inequalities, and graphing.', 1],
        ];

        foreach ($articleData as $a) {
            CourseArticle::create([
                'course_id' => $a[0], 'title' => $a[1], 'content' => $a[2], 'order_no' => $a[3],
            ]);
        }

        // ─── Assessments ────────────────────────────────────────────
        $assessment1 = Assessment::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Programming Skill Assessment',
            'category' => 'Programming',
            'total_marks' => 20,
            'duration' => 30,
            'status' => 'active',
        ]);

        $assessment2 = Assessment::create([
            'teacher_id' => $teacher2->id,
            'title' => 'Mathematics Skill Assessment',
            'category' => 'Mathematics',
            'total_marks' => 20,
            'duration' => 30,
            'status' => 'active',
        ]);

        $assessment3 = Assessment::create([
            'teacher_id' => $teacher1->id,
            'title' => 'Data Structures Quiz',
            'category' => 'Programming',
            'total_marks' => 10,
            'duration' => 20,
            'status' => 'active',
        ]);

        // ─── Questions for Assessment 1 (Programming - 20 MCQs) ─────
        $questions1 = [
            ['What does HTML stand for?', 'Hyper Text Markup Language', 'High Tech Modern Language', 'Hyper Transfer Markup Language', 'Home Tool Markup Language', 'a', 1],
            ['Which symbol is used for comments in Python?', '//', '#', '/* */', '--', 'b', 1],
            ['What is a variable?', 'A fixed value', 'A container for storing data', 'A type of loop', 'A function', 'b', 1],
            ['Which of these is a loop structure?', 'if-else', 'switch', 'for', 'try-catch', 'c', 1],
            ['What does CSS stand for?', 'Computer Style Sheets', 'Creative Style System', 'Cascading Style Sheets', 'Colorful Style Sheets', 'c', 1],
            ['What is an array?', 'A single variable', 'A collection of items', 'A function', 'A loop', 'b', 1],
            ['Which operator is used for assignment?', '==', '=', '===', ':=', 'b', 1],
            ['What is a function?', 'A variable type', 'A reusable block of code', 'A data type', 'A loop structure', 'b', 1],
            ['Which keyword is used to define a class?', 'function', 'var', 'class', 'define', 'c', 1],
            ['What does API stand for?', 'Application Programming Interface', 'Applied Programming Integration', 'Application Process Interface', 'Automated Programming Interface', 'a', 1],
            ['Which data type stores true/false?', 'String', 'Integer', 'Boolean', 'Float', 'c', 1],
            ['What is debugging?', 'Writing code', 'Finding and fixing errors', 'Compiling code', 'Testing code', 'b', 1],
            ['What is a string?', 'A number', 'A sequence of characters', 'A boolean', 'An array', 'b', 1],
            ['Which tag is used for links in HTML?', '<link>', '<a>', '<href>', '<url>', 'b', 1],
            ['What does SQL stand for?', 'Structured Query Language', 'Simple Question Language', 'System Query Logic', 'Standard Query Language', 'a', 1],
            ['What is inheritance in OOP?', 'Creating new variables', 'A class inheriting from another class', 'Deleting objects', 'A loop structure', 'b', 1],
            ['What is an IDE?', 'Internet Data Exchange', 'Integrated Development Environment', 'Internal Data Engine', 'Integrated Design Editor', 'b', 1],
            ['Which of these is not a programming language?', 'Python', 'HTML', 'Java', 'C++', 'b', 1],
            ['What is a conditional statement?', 'A loop', 'A decision-making statement', 'A variable', 'A function call', 'b', 1],
            ['What does OOP stand for?', 'Object Oriented Programming', 'Open Office Protocol', 'Online Operating Platform', 'Object Order Processing', 'a', 1],
        ];

        foreach ($questions1 as $q) {
            Question::create([
                'assessment_id' => $assessment1->id,
                'question' => $q[0], 'option_a' => $q[1], 'option_b' => $q[2],
                'option_c' => $q[3], 'option_d' => $q[4],
                'correct_option' => $q[5], 'marks' => $q[6],
            ]);
        }

        // ─── Questions for Assessment 2 (Mathematics - 10 MCQs) ─────
        $questions2 = [
            ['What is 15 × 8?', '100', '120', '130', '110', 'b', 2],
            ['Solve: 2x + 6 = 14', 'x = 3', 'x = 4', 'x = 5', 'x = 6', 'b', 2],
            ['What is the square root of 144?', '10', '11', '12', '14', 'c', 2],
            ['What is the value of π (approx)?', '2.14', '3.14', '4.14', '1.14', 'b', 2],
            ['What is 25% of 200?', '25', '50', '75', '100', 'b', 2],
            ['What is the area of a circle formula?', '2πr', 'πr²', 'πd', '2πr²', 'b', 2],
            ['What is the next prime number after 7?', '9', '10', '11', '13', 'c', 2],
            ['What is 3³?', '9', '18', '27', '81', 'c', 2],
            ['What type of angle is 90°?', 'Acute', 'Right', 'Obtuse', 'Straight', 'b', 2],
            ['What is the sum of angles in a triangle?', '90°', '180°', '270°', '360°', 'b', 2],
        ];

        foreach ($questions2 as $q) {
            Question::create([
                'assessment_id' => $assessment2->id,
                'question' => $q[0], 'option_a' => $q[1], 'option_b' => $q[2],
                'option_c' => $q[3], 'option_d' => $q[4],
                'correct_option' => $q[5], 'marks' => $q[6],
            ]);
        }

        // ─── Samir's Result (Slow Learner - 35%) ───────────────────
        $samirResult = Result::create([
            'assessment_id' => $assessment1->id,
            'student_id' => $samir->id,
            'score' => 7,
            'total_marks' => 20,
            'percentage' => 35.00,
            'skill_level' => 'beginner',
            'status' => 'slow_learner',
        ]);

        // ─── Samir's Course Recommendation ──────────────────────────
        CourseRecommendation::create([
            'student_id' => $samir->id,
            'course_id' => $course1->id,
            'result_id' => $samirResult->id,
            'reason' => 'Based on your beginner skill level in Programming. Score: 35%',
        ]);

        // ─── Samir's Enrollment ─────────────────────────────────────
        CourseEnrollment::create([
            'student_id' => $samir->id,
            'course_id' => $course1->id,
            'status' => 'enrolled',
            'enrolled_at' => now(),
        ]);

        // ─── Remedial Class for Samir ───────────────────────────────
        $remedialClass = RemedialClass::create([
            'course_id' => $course1->id,
            'teacher_id' => $teacher1->id,
            'student_id' => $samir->id,
            'title' => 'Programming Basics - Remedial Session',
            'platform' => 'Google Meet',
            'meeting_link' => 'https://meet.google.com/abc-defg-hij',
            'scheduled_at' => now()->addDays(2)->setTime(16, 0),
            'duration' => 60,
            'status' => 'upcoming',
        ]);

        // ─── Assignment for Samir ───────────────────────────────────
        $assignment = Assignment::create([
            'course_id' => $course1->id,
            'teacher_id' => $teacher1->id,
            'student_id' => $samir->id,
            'title' => 'Basic Programming Practice',
            'description' => 'Write a program that prints numbers 1 to 10 using a loop. Explain each line of your code.',
            'due_date' => now()->addDays(7),
            'marks' => 50,
            'status' => 'pending',
        ]);

        // ─── Progress Report for Samir ──────────────────────────────
        ProgressReport::create([
            'student_id' => $samir->id,
            'teacher_id' => $teacher1->id,
            'course_id' => $course1->id,
            'initial_score' => 35,
            'current_score' => 60,
            'progress_percentage' => 71.43,
            'status' => 'Improved',
            'remarks' => 'Samir has shown significant improvement after completing video lessons and attending remedial classes.',
        ]);

        // ─── Other student results ──────────────────────────────────
        // Aisha - Intermediate
        Result::create([
            'assessment_id' => $assessment1->id,
            'student_id' => $students[0]->id,
            'score' => 12, 'total_marks' => 20, 'percentage' => 60.00,
            'skill_level' => 'intermediate', 'status' => 'intermediate',
        ]);

        CourseRecommendation::create([
            'student_id' => $students[0]->id, 'course_id' => $course2->id,
            'result_id' => 2, 'reason' => 'Intermediate level in Programming. Score: 60%',
        ]);

        // Rahul - Advanced
        Result::create([
            'assessment_id' => $assessment1->id,
            'student_id' => $students[1]->id,
            'score' => 17, 'total_marks' => 20, 'percentage' => 85.00,
            'skill_level' => 'advanced', 'status' => 'advanced',
        ]);

        // Priya - Slow Learner (Math)
        $priyaResult = Result::create([
            'assessment_id' => $assessment2->id,
            'student_id' => $students[2]->id,
            'score' => 6, 'total_marks' => 20, 'percentage' => 30.00,
            'skill_level' => 'beginner', 'status' => 'slow_learner',
        ]);

        CourseRecommendation::create([
            'student_id' => $students[2]->id, 'course_id' => $course4->id,
            'result_id' => $priyaResult->id, 'reason' => 'Beginner level in Mathematics. Score: 30%',
        ]);

        // ─── Additional Remedial Classes ────────────────────────────
        RemedialClass::create([
            'course_id' => $course4->id,
            'teacher_id' => $teacher2->id,
            'student_id' => $students[2]->id,
            'title' => 'Math Fundamentals Review',
            'platform' => 'Zoom',
            'meeting_link' => 'https://zoom.us/j/1234567890',
            'scheduled_at' => now()->addDays(3)->setTime(14, 0),
            'duration' => 45,
            'status' => 'upcoming',
        ]);

        // ─── Additional Assignments ─────────────────────────────────
        Assignment::create([
            'course_id' => $course4->id,
            'teacher_id' => $teacher2->id,
            'student_id' => $students[2]->id,
            'title' => 'Basic Algebra Practice',
            'description' => 'Solve the following algebraic equations and show your working.',
            'due_date' => now()->addDays(5),
            'marks' => 40,
            'status' => 'pending',
        ]);

        // ─── Submission Example ─────────────────────────────────────
        $sub = Submission::create([
            'assignment_id' => $assignment->id,
            'student_id' => $samir->id,
            'answer_text' => 'Here is my solution using a for loop to print numbers 1 to 10...',
            'status' => 'submitted',
            'submitted_at' => now()->subDays(1),
        ]);

        // ─── More Progress Reports ──────────────────────────────────
        ProgressReport::create([
            'student_id' => $students[0]->id,
            'teacher_id' => $teacher1->id,
            'course_id' => $course2->id,
            'initial_score' => 60, 'current_score' => 72,
            'progress_percentage' => 20.00, 'status' => 'Improved',
            'remarks' => 'Good progress with practice exercises.',
        ]);

        ProgressReport::create([
            'student_id' => $students[2]->id,
            'teacher_id' => $teacher2->id,
            'course_id' => $course4->id,
            'initial_score' => 30, 'current_score' => 30,
            'progress_percentage' => 0, 'status' => 'Stagnant',
            'remarks' => 'Needs more attention and remedial support.',
        ]);
    }
}
