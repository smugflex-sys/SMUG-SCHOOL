<?php

namespace App\Livewire\Admin;

use App\Models\Notice;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ManageNotices extends Component
{
    use WithPagination;

    public $title, $content;
    public $audience = [];
    public $noticeId;
    public $showModal = false;
    public $isEditMode = false;

    protected $rules = [
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'audience' => 'sometimes|array',
    ];

    public function openModal()
    {
        $this->reset();
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();
        Notice::create([
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => Auth::id(),
            'audience' => empty($this->audience) ? null : $this->audience,
            'published_at' => now(),
        ]);
        session()->flash('message', 'Notice published successfully.');
        $this->showModal = false;
    }
    // Add edit, update, delete methods here...

    public function render()
    {
        return view('livewire.admin.manage-notices', [
            'notices' => Notice::with('author')->latest()->paginate(10),
            'roles' => Role::all()->pluck('name'),
        ]);
    }
}