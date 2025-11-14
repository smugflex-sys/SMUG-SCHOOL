<?php

namespace App\Livewire\Teacher;

use App\Models\CbtExam;
use App\Models\CbtQuestion;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ManageCbtExams extends Component
{
    use WithPagination;

    // --- General Properties ---
    public $teacherSubjects = [];
    public $schoolClasses = [];
    public $selectedSubjectIdForBank; // Filter for the question bank

    // --- Question Bank Properties ---
    public $question_text;
    public $options = ['A' => '', 'B' => '', 'C' => '', 'D' => ''];
    public $correct_answer = 'A';
    public $questionId;
    public $showQuestionModal = false;
    public $isQuestionEditMode = false;

    // --- Exam Properties ---
    public $exam_title, $exam_subject_id, $exam_school_class_id, $exam_duration_minutes, $exam_instructions;
    public $examId;
    public $showExamModal = false;
    public $isExamEditMode = false;

    // --- Linking Properties ---
    public $linkingExam;
    public $questionIdsToLink = [];
    public $questionsForLinking = [];
    public $showLinkModal = false;


    public function mount()
    {
        // For simplicity, we get all subjects. In a real app, you'd fetch only subjects taught by this teacher.
        $this->teacherSubjects = Subject::all();
        $this->schoolClasses = SchoolClass::all();

        // Set a default subject filter if available
        if ($this->teacherSubjects->isNotEmpty()) {
            $this->selectedSubjectIdForBank = $this->teacherSubjects->first()->id;
        }
    }

    // --- Validation Rules ---
    protected function questionRules() {
        return [
            'question_text' => 'required|string|min:10',
            'options.A' => 'required|string',
            'options.B' => 'required|string',
            'options.C' => 'required|string',
            'options.D' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'selectedSubjectIdForBank' => 'required|exists:subjects,id',
        ];
    }
    protected function examRules() {
        return [
            'exam_title' => 'required|string|max:255',
            'exam_subject_id' => 'required|exists:subjects,id',
            'exam_school_class_id' => 'required|exists:school_classes,id',
            'exam_duration_minutes' => 'required|integer|min:1',
            'exam_instructions' => 'nullable|string',
        ];
    }

    // --- Question Bank Methods ---
    public function openQuestionModal()
    {
        $this->resetValidation();
        $this->reset(['question_text', 'options', 'correct_answer', 'questionId', 'isQuestionEditMode']);
        $this->options = ['A' => '', 'B' => '', 'C' => '', 'D' => '']; // Ensure options are reset
        $this->showQuestionModal = true;
    }

    public function storeQuestion()
    {
        $this->validate($this->questionRules());
        CbtQuestion::create([
            'subject_id' => $this->selectedSubjectIdForBank,
            'user_id' => Auth::id(),
            'question_text' => $this->question_text,
            'options' => $this->options,
            'correct_answer' => $this->correct_answer,
        ]);
        session()->flash('message', 'Question added to your bank successfully.');
        $this->showQuestionModal = false;
    }
    // ... Add edit/update/delete for questions later

    // --- Exam Methods ---
    public function openExamModal()
    {
        $this->resetValidation();
        $this->reset(['exam_title', 'exam_subject_id', 'exam_school_class_id', 'exam_duration_minutes', 'exam_instructions', 'examId', 'isExamEditMode']);
        $this->showExamModal = true;
    }
    
    public function storeExam()
    {
        $this->validate($this->examRules());
        CbtExam::create([
            'title' => $this->exam_title,
            'subject_id' => $this->exam_subject_id,
            'school_class_id' => $this->exam_school_class_id,
            'duration_minutes' => $this->exam_duration_minutes,
            'instructions' => $this->exam_instructions,
        ]);
        session()->flash('exam_message', 'Exam created successfully. Now, manage its questions.');
        $this->showExamModal = false;
    }
    // ... Add edit/update/delete for exams later

    // --- Question Linking Methods ---
     public function openLinkModal($examId)
    {
        $this->linkingExam = CbtExam::with('questions')->findOrFail($examId);
        $this->questionIdsToLink = $this->linkingExam->questions->pluck('id')->toArray();

        // --- THIS IS THE NEW LOGIC THAT FIXES THE ERROR ---
        // Fetch all available questions from the bank for the exam's subject
        $this->questionsForLinking = CbtQuestion::where('subject_id', $this->linkingExam->subject_id)
            ->where('user_id', Auth::id())
            ->get();
        
        $this->showLinkModal = true;
    }

       public function saveLinkedQuestions()
    {
        $this->linkingExam->questions()->sync($this->questionIdsToLink);
        session()->flash('exam_message', 'Questions for the exam have been updated.');
        $this->showLinkModal = false;
    }


    public function render()
    {
        // Get all questions for the selected subject's bank
        $questionBank = CbtQuestion::where('subject_id', $this->selectedSubjectIdForBank)
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
            
        // Get all exams created by this teacher
        // Note: In a full app, you might scope this to a subject or class
        $exams = CbtExam::with('subject', 'schoolClass')
            // ->where('user_id', Auth::id()) // You would add a user_id to cbt_exams table
            ->latest()
            ->paginate(10);

        return view('livewire.teacher.manage-cbt-exams', compact('questionBank', 'exams'));
    }
}