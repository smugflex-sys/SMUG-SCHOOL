<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Term;
use App\Models\Result;
use App\Models\ExamScore;
use App\Models\GradingSystem;
use App\Models\DomainRating;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function generateReportCard($studentId, $termId)
    {
        $student = Student::with('user', 'schoolClass', 'classArm')->findOrFail($studentId);
        $term = Term::with('academicSession')->findOrFail($termId);
        $result = Result::where('student_id', $studentId)->where('term_id', $termId)->first();
        
        if (!$result) {
            // Provide a graceful message if results aren't processed
            return response("Result for this student and term has not been processed. Please contact the administrator.", 404);
        }

        // Fetch all scores for the term, grouped by subject for easy processing
        $scoresBySubject = ExamScore::with('subject')
            ->where('student_id', $studentId)
            ->where('term_id', $termId)
            ->get()
            ->groupBy('subject_id');
            
        // Fetch all domain ratings for the term, separated by type
        $domainRatings = DomainRating::where('student_id', $studentId)
            ->where('term_id', $termId)
            ->with('domain')
            ->get();
            
        $affectiveDomains = $domainRatings->where('domain.type', 'affective');
        $psychomotorDomains = $domainRatings->where('domain.type', 'psychomotor');
            
        $grades = GradingSystem::all();

        $data = [
            'student' => $student,
            'term' => $term,
            'result' => $result,
            'scoresBySubject' => $scoresBySubject,
            'affectiveDomains' => $affectiveDomains,
            'psychomotorDomains' => $psychomotorDomains,
            'grades' => $grades,
        ];

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('reports.report-card', $data);
        return $pdf->stream('report-card-' . $student->admission_no . '.pdf');
    }
}