<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\HandleRoleRedirects;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExeatController;
use App\Http\Controllers\Accountant\InvoiceController;
use App\Http\Controllers\WebhookController; 


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        // This is the central entry point after login.
        // The middleware will redirect users based on their role.
        // This view acts as a fallback for users without a specific dashboard.
        return view('dashboard');
    })->middleware(HandleRoleRedirects::class)->name('dashboard');

    // ADMIN ROUTE GROUP
    Route::middleware(['role:Admin'])->prefix('admin')->name('admin.')->group(function () {
        // This is the new route that fixes the 404 error
        Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
        
        Route::get('/settings', fn() => view('admin.settings.index'))->name('settings.index');
        Route::get('/backups', fn() => view('admin.backups.index'))->name('backups.index');
        Route::get('/activity-logs', fn() => view('admin.activity-logs.index'))->name('activity-logs.index');
        Route::get('/students', fn() => view('admin.students.index'))->name('students.index');
        Route::get('/staff', fn() => view('admin.staff.index'))->name('staff.index');
        Route::get('/parents', fn() => view('admin.parents.index'))->name('parents.index');
        Route::get('/academic-sessions', fn() => view('admin.sessions.index'))->name('sessions.index');
        Route::get('/classes', fn() => view('admin.classes.index'))->name('classes.index');
        Route::get('/subjects', fn() => view('admin.subjects.index'))->name('subjects.index');
        Route::get('/exams', fn() => view('admin.exams.index'))->name('exams.index');
        Route::get('/results/process', fn() => view('admin.results.process'))->name('results.process');
        Route::get('/notices', fn() => view('admin.notices.index'))->name('notices.index');
        Route::get('/events', fn() => view('admin.events.index'))->name('events.index');
        Route::get('/result-pins', fn() => view('admin.pins.index'))->name('pins.index');
        Route::get('/classes/{class}/arm/{arm}/roster', \App\Livewire\Admin\ManageClassRoster::class)->name('classes.roster');
        Route::get('/exeat-requests', fn() => view('admin.exeats.index'))->name('exeats.index');
        Route::get('/transport', fn() => view('admin.transport.index'))->name('transport.index');
        Route::get('/transport/bus/{bus}/roster', fn($bus) => view('admin.transport.roster', ['busId' => $bus]))->name('transport.roster');
        Route::get('/students/promote', fn() => view('admin.promote.index'))->name('students.promote');
        Route::get('/analytics', fn() => view('admin.analytics.index'))->name('analytics.index');
    });

    // ACCOUNTANT ROUTE GROUP
    Route::middleware(['role:Accountant|Admin'])->prefix('accountant')->name('accountant.')->group(function () {
        Route::get('/dashboard', fn() => view('accountant.dashboard'))->name('dashboard');
        Route::get('/fees', fn() => view('accountant.fees.index'))->name('fees.index');
        Route::get('/invoices', fn() => view('accountant.invoices.index'))->name('invoices.index');
          Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
    });

    // LIBRARIAN ROUTE GROUP
    Route::middleware(['role:Librarian|Admin'])->prefix('librarian')->name('librarian.')->group(function () {
        Route::get('/dashboard', fn() => view('librarian.dashboard'))->name('dashboard');
        Route::get('/books', fn() => view('librarian.books.index'))->name('books.index');
        Route::get('/issue-return', fn() => view('librarian.issue-return.index'))->name('issue-return.index');
    });

    // TEACHER ROUTE GROUP
    Route::middleware(['role:Teacher|Admin'])->prefix('teacher')->name('teacher.')->group(function () {
        Route::get('/dashboard', fn() => view('teacher.dashboard'))->name('dashboard');
        Route::get('/attendance', fn() => view('teacher.attendance.index'))->name('attendance.index');
        Route::get('/scores', fn() => view('teacher.scores.index'))->name('scores.index');
        Route::get('/cbt-exams', fn() => view('teacher.cbt.index'))->name('cbt.index');
        Route::get('/cbt-exams/results', fn() => view('teacher.cbt.results'))->name('cbt.results');
    });

    // STUDENT ROUTE GROUP
    Route::middleware(['role:Student'])->prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', fn() => view('student.dashboard'))->name('dashboard');
        Route::get('/invoices', fn() => view('student.invoices.index'))->name('invoices.index');
        Route::get('/results', fn() => view('student.results.index'))->name('results.index');
        Route::get('/timetable', fn() => view('student.timetable'))->name('timetable');
        Route::get('/cbt-exams', fn() => view('student.cbt.index'))->name('cbt.index');
        Route::get('/cbt/exam/{exam}', \App\Livewire\Student\TakeCbtExam::class)->name('cbt.take');
        Route::get('/cbt-exams/my-attempts', fn() => view('student.cbt.attempts'))->name('cbt.attempts');
    });

    // PARENT ROUTE GROUP
    Route::middleware(['role:Parent'])->prefix('parent')->name('parent.')->group(function () {
        Route::get('/dashboard', fn() => view('parent.dashboard'))->name('dashboard');
        Route::get('/results', fn() => view('parent.results'))->name('results');
        Route::get('/payments', fn() => view('parent.payments'))->name('payments');
        Route::get('/exeat-requests', fn() => view('parent.exeats.index'))->name('exeats.index');
        Route::get('/bus-tracking', fn() => view('parent.bus-tracking.index'))->name('bus-tracking.index');
    });

    // SHARED ROUTES
    Route::get('/noticeboard', fn() => view('shared.notices.index'))->name('notices.view');
    Route::get('/calendar', fn() => view('shared.calendar.index'))->name('calendar.view');
    Route::get('/library', fn() => view('shared.library.index'))->name('library.catalog');

});

// PUBLIC & WEBHOOK ROUTES
Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('payment.pay')->middleware('auth');
Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback'])->name('payment.callback');
Route::get('/exeat/verify/{token}', [ExeatController::class, 'verify'])->name('exeat.verify');
Route::post('/paystack/webhook', [WebhookController::class, 'handlePaystackWebhook'])->name('paystack.webhook');


Route::get('/reports/report-card/{studentId}/{termId}', [ReportController::class, 'generateReportCard'])
    ->name('reports.report-card')
    ->middleware('auth');