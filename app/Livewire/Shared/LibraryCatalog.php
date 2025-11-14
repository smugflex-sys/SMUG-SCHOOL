<?php

namespace App\Livewire\Shared;

use App\Models\Book;
use App\Models\BookCategory;
use Livewire\Component;
use Livewire\WithPagination;

class LibraryCatalog extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategoryId = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategoryId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $books = Book::with('category')
            ->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('author', 'like', '%' . $this->search . '%');
            })
            ->when($this->selectedCategoryId, function ($query) {
                $query->where('book_category_id', $this->selectedCategoryId);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.shared.library-catalog', [
            'books' => $books,
            'categories' => BookCategory::all(),
        ]);
    }
}