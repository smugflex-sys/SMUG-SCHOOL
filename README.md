World-Class School Management System (SMS) A full-featured, multi-portal School Management System built on the TALL stack (Tailwind, Alpine.js, Laravel, Livewire). This project is architected to be a modern, secure, and scalable solution tailored for the unique operational needs of primary and secondary schools or high schools.

The system provides dedicated portals for every key stakeholder—Admin, Student, Teacher, Parent, Accountant, and Librarian—ensuring a seamless digital experience for the entire school community.

✨ Core Features This is not just an administrative tool; it's a complete ecosystem for learning, management, and community engagement.

🏛️ Core System & Authentication Role-Based Access Control: Secure portals for 6 distinct user roles (Admin, Student, Teacher, Parent, Accountant, Librarian) powered by spatie/laravel-permission.

Secure Authentication: Built on Laravel Jetstream, providing a robust and secure login system.

Admin-Controlled Registration: Public registration is disabled; all user accounts are securely created and managed by the school administrator.

Role-Based Redirects: Users are automatically redirected to their specific dashboard upon login.

🎓 Academic Management Full Student & Staff CRUD: Comprehensive modules for managing student admissions and staff records.

Academic Year Management: Define and manage academic sessions and their corresponding terms (First, Second, Third).

Class & Subject Management: Easily create class levels (JSS 1), class arms (A, B, Science), and subjects.

Advanced Result Processing: Automated calculation of termly averages and class positions, compliant with Nigerian grading standards.

C.A. & Domain Tracking: A dedicated interface for teachers to input Continuous Assessment scores and affective/psychomotor domain ratings.

Automated Promotion Engine: A "smart" feature for administrators to automatically promote students to the next class based on predefined academic criteria.

💰 Financial Management Fee Structuring: Define different fee types (e.g., Tuition, PTA Levy) and set specific amounts for each class.

Automated Invoicing: Generate termly invoices for all students in a class with a single click.

Payment Integration: Securely process online payments via Paystack, with a robust system using both Callbacks and Webhooks.

Professional PDF Generation: View and download beautifully formatted, professional invoices and receipts.

🧑‍💻 The Digital Classroom & Portals Dedicated Portals: Unique, feature-rich dashboards for Students, Parents, Teachers, Accountants, and Librarians.

Integrated CBT Platform: A world-class Computer-Based Testing module that allows teachers to create question banks and set timed, auto-graded exams that simulate the JAMB/WAEC experience.

Student CBT Portal: A distraction-free interface for students to take exams, with a live countdown timer and question palette.

Parent & Ward Management: Parents can manage all of their children from a single dashboard, switching between wards to view their specific academic and financial information.

🚀 Revolutionary "Peace of Mind" Modules Digital Exeat Pass System: A secure system for parents to request, and admins to approve, student exeats. Approved passes generate a public verification page with a scannable QR code.

Real-Time Bus Tracking: A complete module for defining bus routes, assigning students to buses, and a placeholder for parents to track the bus in real-time.

WhatsApp API Ready: Includes a WhatsAppService class, architected to be ready for integration with a WhatsApp Business API provider for sending critical alerts.

🛠️ Advanced Administrative Tools Insightful Analytics Dashboard: Provides school owners with high-level insights into subject performance and financial health.

Secure Backup System: A dedicated interface for creating and managing secure database backups, powered by spatie/laravel-backup.

Complete Audit Trail: Tracks all significant activities (creation, updates, deletion) on key records like students, staff, and invoices, powered by spatie/laravel-activitylog.

Public Result Checker: A premium feature allowing results to be checked from the landing page using a scratch card PIN.

🛠️ Technical Stack This project is built with a modern, robust, and scalable technology stack.

Backend: Laravel 11+, PHP 8.3+

Frontend: Livewire 3, Tailwind CSS, Alpine.js

Database: MySQL

Core Packages:

laravel/jetstream: Authentication scaffolding.

spatie/laravel-permission: Role and permission management.

spatie/laravel-backup: For database backups.

spatie/laravel-activitylog: For user activity auditing.

maatwebsite/excel: For bulk importing of students.

barryvdh/laravel-dompdf: For generating PDF invoices and reports.

endroid/qr-code-bundle: For generating secure QR codes.

Development Environment: Laragon

🚀 Getting Started Follow these steps to set up the project on your local development environment.

Prerequisites Laragon or a similar local server environment (WAMP, XAMPP).

Composer

Node.js & NPM

Installation Steps Clone the repository:

git clone https://github.com/smugflex-sys/SMUG-SCHOOL.git cd SMUG-SCHOOL

Install PHP dependencies:

composer install

Install NPM dependencies and compile assets:

npm install npm run build

Set up your environment file:

Copy .env.example to a new file named .env.

Update the DB_* variables to match your local database credentials.

Update the PAYSTACK_* variables with your sandbox keys.

DB_CONNECTION=mysql DB_HOST=127.0.0.1 DB_PORT=3306 DB_DATABASE=school_management_system DB_USERNAME=root DB_PASSWORD=

PAYSTACK_PUBLIC_KEY=pk_test_... PAYSTACK_SECRET_KEY=sk_test_... MERCHANT_EMAIL=your-email@paystack.com

Generate your application key:

php artisan key:generate

Run the database migrations and seeders: This will create all the necessary tables and populate the database with default roles and an admin user.

php artisan migrate:fresh --seed

Create the storage link:

php artisan storage:link
