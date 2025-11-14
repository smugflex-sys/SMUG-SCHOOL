<?php

namespace App\Livewire\Shared;

use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ViewNotices extends Component
{
    use WithPagination;

    public function render()
    {
        $userRoles = Auth::user()->getRoleNames();

        $notices = Notice::where('published_at', '<=', now())
            ->where(function ($query) use ($userRoles) {
                // Notice is for everyone
                $query->whereNull('audience')
                    // Or notice is for one of the user's roles
                    ->orWhere(function ($subQuery) use ($userRoles) {
                        foreach ($userRoles as $role) {
                            $subQuery->orWhereJsonContains('audience', $role);
                        }
                    });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.shared.view-notices', [
            'notices' => $notices,
        ]);
    }
}