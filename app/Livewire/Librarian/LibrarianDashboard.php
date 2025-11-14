<?php

namespace App\Livewire\Librarian;

use App\Models\Book;
use App\Models\BookIssue;
use Livewire\Component;

class LibrarianDashboard extends Component
{
    public $totalBooks;
    public $booksIssued;
    public $booksOverdue;
    public $recentlyReturned = [];

    public function mount()
    {
        $this->totalBooks = Book::sum('quantity');
        $this->booksIssued = BookIssue::where('status', 'issued')->count();
        $this->booksOverdue = BookIssue::where('status', 'issued')
            ->where('due_date', '<', now())
            ->count();

        $this->recentlyReturned = BookIssue::where('status', '!=', 'issued')
            ->with(['book', 'user'])
            ->latest('return_date')
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.librarian.librarian-dashboard');
    }
}