<?php

namespace App\Livewire\Librarian;

use App\Models\Book;
use App\Models\User;
use App\Models\BookIssue;
use Carbon\Carbon;
use Livewire\Component;

class IssueReturnBooks extends Component
{
    public $userSearch = '';
    public $bookSearch = '';
    public $selectedUserId, $selectedBookId;
    public $users = [];
    public $books = [];
    public $issuedBooks = [];

    const FINE_PER_DAY = 50; // Fine in NGN

    public function updatedUserSearch()
    {
        if (strlen($this->userSearch) >= 2) {
            $this->users = User::where('name', 'like', '%' . $this->userSearch . '%')
                ->orWhere('email', 'like', '%' . $this->userSearch . '%')
                ->limit(5)->get();
        } else {
            $this->users = [];
        }
    }

    public function updatedBookSearch()
    {
        if (strlen($this->bookSearch) >= 2) {
            $this->books = Book::where('title', 'like', '%' . $this->bookSearch . '%')
                ->where('available_quantity', '>', 0)
                ->limit(5)->get();
        } else {
            $this->books = [];
        }
    }

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->userSearch = User::find($userId)->name;
        $this->users = [];
        $this->loadIssuedBooks();
    }

    public function selectBook($bookId)
    {
        $this->selectedBookId = $bookId;
        $this->bookSearch = Book::find($bookId)->title;
        $this->books = [];
    }

    public function loadIssuedBooks()
    {
        if ($this->selectedUserId) {
            $this->issuedBooks = BookIssue::with('book')
                ->where('user_id', $this->selectedUserId)
                ->where('status', '!=', 'returned')
                ->get();
        }
    }

    public function issueBook()
    {
        $this->validate([
            'selectedUserId' => 'required|exists:users,id',
            'selectedBookId' => 'required|exists:books,id',
        ]);

        $book = Book::find($this->selectedBookId);
        if ($book->available_quantity < 1) {
            session()->flash('error', 'This book is currently not available.');
            return;
        }

        BookIssue::create([
            'book_id' => $this->selectedBookId,
            'user_id' => $this->selectedUserId,
            'issue_date' => now(),
            'due_date' => now()->addWeeks(2), // Due in 2 weeks
        ]);

        $book->decrement('available_quantity');

        session()->flash('message', 'Book issued successfully.');
        $this->reset(['bookSearch', 'selectedBookId']);
        $this->loadIssuedBooks();
    }

    public function returnBook($issueId)
    {
        $issue = BookIssue::find($issueId);
        $fine = 0;

        if (now()->gt($issue->due_date)) {
            $overdueDays = now()->diffInDays($issue->due_date);
            $fine = $overdueDays * self::FINE_PER_DAY;
            $issue->status = 'overdue';
        } else {
            $issue->status = 'returned';
        }
        
        $issue->return_date = now();
        $issue->fine_amount = $fine;
        $issue->save();

        $issue->book->increment('available_quantity');

        session()->flash('message', "Book returned. Overdue fine: ₦{$fine}");
        $this->loadIssuedBooks();
    }

    public function render()
    {
        return view('livewire.librarian.issue-return-books');
    }
}