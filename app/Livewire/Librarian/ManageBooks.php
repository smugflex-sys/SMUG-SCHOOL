<?php

namespace App\Livewire\Librarian;

use App\Models\Book;
use App\Models\BookCategory;
use Livewire\Component;
use Livewire\WithPagination;

class ManageBooks extends Component
{
    use WithPagination;

    // Book properties
    public $title, $author, $isbn, $book_category_id, $quantity;
    public $bookId;
    public $showBookModal = false;
    public $isBookEditMode = false;

    // Category properties
    public $categoryName, $categoryId;
    public $showCategoryModal = false;

    // Book CRUD
    public function openBookModal()
    {
        $this->reset(['title', 'author', 'isbn', 'book_category_id', 'quantity', 'bookId', 'isBookEditMode']);
        $this->showBookModal = true;
    }

    public function storeBook()
    {
        $this->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'book_category_id' => 'required|exists:book_categories,id',
            'quantity' => 'required|integer|min:1',
        ]);

        Book::create([
            'title' => $this->title,
            'author' => $this->author,
            'isbn' => $this->isbn,
            'book_category_id' => $this->book_category_id,
            'quantity' => $this->quantity,
            'available_quantity' => $this->quantity,
        ]);
        session()->flash('message', 'Book added successfully.');
        $this->showBookModal = false;
    }
    // ... Add edit, update, delete for Book

    // Category CRUD
    public function openCategoryModal()
    {
        $this->reset(['categoryName', 'categoryId']);
        $this->showCategoryModal = true;
    }

    public function storeCategory()
    {
        $this->validate(['categoryName' => 'required|string|unique:book_categories,name']);
        BookCategory::create(['name' => $this->categoryName]);
        session()->flash('category_message', 'Category added successfully.');
        $this->showCategoryModal = false;
    }
    // ... Add edit, update, delete for Category

    public function render()
    {
        return view('livewire.librarian.manage-books', [
            'books' => Book::with('category')->latest()->paginate(10),
            'categories' => BookCategory::all(),
        ]);
    }
}