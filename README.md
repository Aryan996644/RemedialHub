<h1 align="center">
  <br>
  🎓 RemedialHub
  <br>
</h1>

<h4 align="center">A comprehensive <strong>Remedial Teaching Management System</strong> built with Laravel — designed to identify slow learners, recommend personalized courses, and track student academic progress.</h4>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/License-MIT-green?style=for-the-badge" alt="License">
</p>

<p align="center">
  <a href="#-features">Features</a> •
  <a href="#-tech-stack">Tech Stack</a> •
  <a href="#-installation">Installation</a> •
  <a href="#-roles--access">Roles</a> •
  <a href="#-modules">Modules</a> •
  <a href="#-database-schema">Database</a> •
  <a href="#-screenshots">Screenshots</a> •
  <a href="#-license">License</a>
</p>

---

## 📖 About

**RemedialHub** is an academic SaaS platform that helps educational institutions manage remedial teaching workflows. The system automatically identifies **slow learners** through skill assessments, recommends tailored courses, schedules remedial classes, and tracks student improvement — all within a clean, role-based dashboard.

> Built as a final-year academic project demonstrating a full-stack Laravel MVC architecture with intelligent student performance analysis.

---

## ✨ Features

### 🔐 Authentication & Role-Based Access Control
- Separate login portals for **Admin**, **Teacher**, and **Student**
- Middleware-enforced role guards (`role:admin`, `role:teacher`, `role:student`)
- Secure session-based authentication via Laravel Auth

### 🧠 Slow Learner Identification
- Students take **skill assessments** (MCQ-based, auto-graded)
- Scores are classified automatically:
  - `< 40%` → **Beginner / Slow Learner** 🔴
  - `40–70%` → **Intermediate** 🟡
  - `> 70%` → **Advanced** 🟢
- Slow learners are flagged and visible to both Teachers and Admins

### 📚 Course Catalog & Enrollment
- Students can **browse all approved courses** with search, level, and category filters
- **One-click enrollment** directly from the catalog or dashboard
- Enrolled / Recommended / Available badges shown in real time
- Course detail page with embedded videos and reading articles

### ⭐ Personalized Course Recommendations
- On assessment completion, courses are **auto-recommended** by skill level and category
- Students see a dedicated "Recommended for You" page
- Reason card shown on each recommendation ("Based on your beginner level in Math, Score: 35%")

### 🎥 Remedial Classes
- Teachers schedule live remedial sessions per student
- Supports Zoom / Google Meet / custom platform links
- Students join from their dashboard with a single click
- Attendance marking by both teacher and student

### 📝 Assignments & Submissions
- Teachers create assignments linked to courses and students
- Students submit text answers + optional file upload
- Teachers grade submissions and add feedback
- Status tracking: Pending → Submitted → Graded

### 📊 Progress Reports
- Teachers generate progress reports (initial score → current score)
- Automatic improvement calculation and status (Improved / Declined)
- Students view full progress history with visual score bar

### 👨‍💼 Admin Panel
- Full CRUD for Teachers and Students
- Course approval / rejection workflow
- Overview of all assessments, slow learners, remedial classes, and assignments
- System-wide reporting dashboard

---

## 🛠️ Tech Stack

| Layer        | Technology                              |
|-------------|------------------------------------------|
| Framework   | Laravel 11                               |
| Language    | PHP 8.2+                                 |
| Database    | MySQL 8.0+                               |
| Frontend    | Blade Templates + Vanilla CSS            |
| Icons       | Font Awesome 6                           |
| Typography  | Google Fonts — Inter                     |
| Auth        | Laravel Session Auth (custom guards)     |
| File Storage| Laravel Storage (local disk)             |

---

## 🚀 Installation

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Node.js & npm (optional, for asset compilation)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-username/RemedialHub.git
cd RemedialHub

# 2. Install PHP dependencies
composer install

# 3. Copy environment file and set your config
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Configure your database in .env
# DB_DATABASE=remedialhub
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 6. Run migrations and seed the database
php artisan migrate --seed

# 7. Create storage symlink (for file uploads)
php artisan storage:link

# 8. Start the development server
php artisan serve
```

Then open [http://localhost:8000](http://localhost:8000) in your browser.

---

## 🔑 Default Login Credentials

> ⚠️ Change these immediately in a production environment.

| Role    | Email                   | Password   |
|---------|-------------------------|------------|
| Admin   | admin@remedialhub.com   | password   |
| Teacher | teacher@remedialhub.com | password   |
| Student | student@remedialhub.com | password   |

---

## 👥 Roles & Access

### 🛡️ Admin (`/admin/dashboard`)
| Capability | Details |
|---|---|
| Manage Teachers | Create, edit, delete, activate/deactivate |
| Manage Students | Full CRUD + toggle active status |
| Course Approval | Approve or reject teacher-submitted courses |
| View Assessments | See all assessments system-wide |
| Slow Learner Report | View all flagged slow learner students |
| Remedial Classes | Monitor all scheduled remedial classes |
| Assignments | View all assignments across teachers |
| Reports | System-wide progress and performance reports |

### 👩‍🏫 Teacher (`/teacher/dashboard`)
| Capability | Details |
|---|---|
| My Students | View students assigned to their courses |
| Courses | Create/edit/delete courses (pending admin approval) |
| Videos & Articles | Upload course content (videos + reading materials) |
| Assessments | Create assessments with MCQ questions |
| View Results | See all student results and identify slow learners |
| Remedial Classes | Schedule and manage live remedial sessions |
| Assignments | Create and delete assignments per student/course |
| Submissions | Grade student submissions with feedback |
| Progress Reports | Generate and update student progress records |

### 🎓 Student (`/student/dashboard`)
| Capability | Details |
|---|---|
| Skill Assessment | Take auto-graded MCQ assessments |
| My Result | View all past assessment results with skill level |
| Browse All Courses | Explore full catalog with search & filters, enroll freely |
| Recommended Courses | Personalized recommendations based on assessment results |
| Video Lessons | Access video content from enrolled courses |
| Articles / Notes | Read articles from enrolled courses |
| Remedial Classes | View upcoming/completed classes, join via meeting link |
| Assignments | View and submit assignments (text + file upload) |
| My Progress | View score improvement reports with visual progress bar |

---

## 📦 Modules

```
RemedialHub/
├── 🔐 Authentication        — Login/logout with role-based redirects
├── 👨‍💼 Admin Module          — Full system management
│   ├── Teacher Management
│   ├── Student Management
│   ├── Course Approval
│   ├── Slow Learner Report
│   └── System Reports
│
├── 👩‍🏫 Teacher Module         — Content & class management
│   ├── Course CRUD
│   ├── Video Uploads
│   ├── Article Uploads
│   ├── Assessment Builder (MCQ)
│   ├── Remedial Class Scheduling
│   ├── Assignment Creator
│   ├── Submission Grader
│   └── Progress Report Generator
│
└── 🎓 Student Module         — Learning & self-improvement
    ├── Skill Assessment Flow
    ├── Result Viewer
    ├── All Courses Catalog (search + filter + enroll)
    ├── Recommended Courses
    ├── Video Lessons
    ├── Articles / Notes
    ├── Remedial Classes (join + attendance)
    ├── Assignment Submission
    └── Progress Dashboard
```

---

## 🗄️ Database Schema

### Key Tables

| Table | Description |
|---|---|
| `users` | All users (admin, teacher, student) with `role` column |
| `teachers` | Teacher profiles linked to `users` |
| `students` | Student profiles linked to `users` |
| `courses` | Courses with level, category, status (pending/approved/rejected) |
| `course_videos` | Video lessons ordered by `order_no` |
| `course_articles` | Reading articles ordered by `order_no` |
| `course_enrollments` | Student → Course enrollment records |
| `course_recommendations` | Auto-generated recommendations tied to results |
| `assessments` | MCQ-based skill assessments |
| `questions` | MCQ questions with 4 options + correct answer |
| `results` | Assessment results with score, percentage, skill level, status |
| `remedial_classes` | Scheduled remedial sessions with meeting links |
| `class_attendances` | Attendance records per class per student |
| `assignments` | Assignments per student per course |
| `submissions` | Student submissions (text + optional file) |
| `progress_reports` | Initial vs current score reports |

### Entity Relationships

```
User ──< Teacher ──< Course ──< CourseVideo
                    │         └< CourseArticle
                    │
                    └──< Assessment ──< Question
                                    └──< Result ──< CourseRecommendation
                                                 └── (skill_level, status)
User ──< Student ──< CourseEnrollment
                  ├──< Result
                  ├──< RemedialClass ──< ClassAttendance
                  ├──< Assignment ──< Submission
                  └──< ProgressReport
```

---

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AdminController.php
│   │   ├── TeacherController.php
│   │   ├── StudentController.php       ← Core student logic
│   │   ├── CourseController.php
│   │   ├── EnrollmentController.php
│   │   ├── AssessmentController.php
│   │   ├── QuestionController.php
│   │   ├── ResultController.php
│   │   ├── RemedialClassController.php
│   │   ├── AssignmentController.php
│   │   ├── SubmissionController.php
│   │   ├── ProgressReportController.php
│   │   ├── CourseVideoController.php
│   │   └── CourseArticleController.php
│   └── Middleware/
│       └── RoleMiddleware.php
│
├── Models/
│   ├── User.php
│   ├── Teacher.php
│   ├── Student.php
│   ├── Course.php
│   ├── Assessment.php
│   ├── Question.php
│   ├── Result.php
│   ├── CourseRecommendation.php
│   ├── CourseEnrollment.php
│   ├── RemedialClass.php
│   ├── ClassAttendance.php
│   ├── Assignment.php
│   ├── Submission.php
│   └── ProgressReport.php
│
resources/views/
├── layouts/
│   ├── admin.blade.php
│   ├── teacher.blade.php
│   └── student.blade.php
├── admin/
├── teacher/
└── student/
    ├── dashboard.blade.php
    ├── courses/
    │   ├── index.blade.php        ← All Courses Catalog
    │   ├── recommended.blade.php
    │   └── show.blade.php
    ├── assessment/
    ├── result/
    ├── remedial-classes/
    ├── assignments/
    ├── videos/
    ├── articles/
    └── progress/
```

---

## 🔄 Application Flow

```
Student Registers / Logs In
        │
        ▼
  Takes Skill Assessment (MCQ)
        │
        ▼
  Auto-Graded → Skill Level Set
  (Beginner / Intermediate / Advanced)
        │
        ├──► Slow Learner Flagged → Teacher Notified
        │
        ▼
  Courses Auto-Recommended by Level & Category
        │
        ▼
  Student Browses All Courses (or Recommendations)
  → Enrolls in Course
        │
        ▼
  Accesses Videos & Articles
        │
        ▼
  Teacher Schedules Remedial Class → Student Joins
        │
        ▼
  Teacher Assigns Work → Student Submits → Teacher Grades
        │
        ▼
  Teacher Generates Progress Report → Student Views Improvement
```

---

## ⚙️ Environment Variables

Key variables in your `.env` file:

```env
APP_NAME=RemedialHub
APP_ENV=local
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=remedialhub
DB_USERNAME=root
DB_PASSWORD=

FILESYSTEM_DISK=local
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -m 'Add: your feature description'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request

Please make sure your code follows PSR-12 coding standards and includes appropriate comments.

---

## 🐛 Known Issues / Roadmap

- [ ] Email notifications for class schedules
- [ ] Real-time chat between teacher and student
- [ ] Export progress reports as PDF
- [ ] Mobile-responsive sidebar toggle
- [ ] API endpoints for mobile app integration
- [ ] Multi-language support

---

## 📄 License

This project is open-sourced under the [MIT License](LICENSE).

---

## 👤 Author

**Your Name**
- GitHub: [Aryan99664](https://github.com/Aryan99664)
- Email: qamarrza1@gmail.com

---

<p align="center">
  Made with ❤️ using <a href="https://laravel.com">Laravel</a>
  <br>
  ⭐ Star this repo if you found it helpful!
</p>
