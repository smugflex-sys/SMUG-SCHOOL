<!DOCTYPE html>
<html>
<head>
    <title>Report Card</title>
    <style>
        @page { margin: 20px; }
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #16a34a; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; color: #047857; }
        .header p { margin: 2px 0; font-size: 12px; }
        .student-info table { width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 11px; }
        .student-info td { padding: 4px; }
        .results-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        .results-table th, .results-table td { border: 1px solid #ccc; padding: 6px; text-align: center; }
        .results-table th { background-color: #e8f5e9; font-weight: bold; }
        .results-table .subject-col { text-align: left; }
        .domain-section { margin-top: 20px; }
        .domain-table { width: 100%; border-collapse: collapse; }
        .domain-table th, .domain-table td { border: 1px solid #ccc; padding: 5px; text-align: center; }
        .domain-table th { background-color: #f3f4f6; }
        .summary-section { margin-top: 20px; page-break-inside: avoid; }
        .summary-box { border: 1px solid #ccc; padding: 10px; width: 45%; float: right; }
        .summary-box h4 { margin: 0 0 10px 0; text-align: center; background-color: #f3f4f6; padding: 5px; }
        .summary-box table { width: 100%; }
        .summary-box td { padding: 3px 5px; }
        .clearfix { clear: both; }
        .footer-remarks { margin-top: 20px; border-top: 1px solid #ccc; padding-top: 10px; page-break-inside: avoid; }
    </style>
</head>
<body>

    <div class="header">
        <h1>GreenField High School</h1>
        <p>123 Education Way, Ikeja, Lagos</p>
        <p><strong>STUDENT'S TERMINAL REPORT CARD</strong></p>
        <p>{{ $term->name }} - {{ $term->academicSession->name }} Academic Session</p>
    </div>

    <div class="student-info">
        <table>
            <tr>
                <td><strong>STUDENT NAME:</strong> {{ $student->user->name }}</td>
                <td><strong>ADMISSION NO:</strong> {{ $student->admission_no }}</td>
                <td><strong>CLASS:</strong> {{ $student->schoolClass->name }} {{ $student->classArm->name }}</td>
            </tr>
        </table>
    </div>

    <h4>ACADEMIC PERFORMANCE</h4>
    <table class="results-table">
        <thead>
            <tr>
                <th class="subject-col">SUBJECT</th>
                <th>1ST C.A. (20)</th>
                <th>2ND C.A. (20)</th>
                <th>TOTAL C.A. (40)</th>
                <th>EXAM (60)</th>
                <th>TOTAL (100)</th>
                <th>GRADE</th>
                <th>REMARK</th>
            </tr>
        </thead>
        <tbody>
            @foreach($scoresBySubject as $subjectScores)
                @php
                    $ca1 = $subjectScores->firstWhere('score_type', 'ca1')->score ?? 0;
                    $ca2 = $subjectScores->firstWhere('score_type', 'ca2')->score ?? 0;
                    // In a real scenario, you'd add CA3 and logic for best 2.
                    $exam = $subjectScores->firstWhere('score_type', 'exam')->score ?? 0;
                    $total_ca = $ca1 + $ca2;
                    $total_score = $total_ca + $exam;
                    $gradeInfo = $grades->first(function ($grade) use ($total_score) {
                        return $total_score >= $grade->mark_from && $total_score <= $grade->mark_to;
                    });
                @endphp
                <tr>
                    <td class="subject-col">{{ $subjectScores->first()->subject->name }}</td>
                    <td>{{ $ca1 }}</td>
                    <td>{{ $ca2 }}</td>
                    <td>{{ $total_ca }}</td>
                    <td>{{ $exam }}</td>
                    <td><strong>{{ $total_score }}</strong></td>
                    <td>{{ $gradeInfo->grade_name ?? 'N/A' }}</td>
                    <td>{{ $gradeInfo->remark ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary-section">
        <div class="summary-box">
            <h4>PERFORMANCE SUMMARY</h4>
            <table>
                <tr>
                    <td><strong>Total Score:</strong></td>
                    <td>{{ $result->total_score }}</td>
                </tr>
                <tr>
                    <td><strong>Average:</strong></td>
                    <td>{{ number_format($result->average, 2) }}%</td>
                </tr>
                <tr>
                    <td><strong>Class Position:</strong></td>
                    <td>{{ $result->position }}</td>
                </tr>
            </table>
        </div>

        <div class="domain-section">
            <div style="width: 45%; float: left;">
                <h4>AFFECTIVE DOMAIN</h4>
                <table class="domain-table">
                    <thead><tr><th>Trait</th><th>Rating (1-5)</th></tr></thead>
                    <tbody>
                        @foreach($affectiveDomains as $rating)
                            <tr><td>{{ $rating->domain->name }}</td><td>{{ $rating->rating }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="footer-remarks">
        <p><strong>Class Teacher's Remark:</strong> {{ $result->remarks ?? 'Good progress, keep it up.' }}</p>
        <p><strong>Principal's Remark:</strong> An excellent performance. Well done.</p>
    </div>

</body>
</html>