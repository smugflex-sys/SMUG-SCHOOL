<?php

namespace App\Livewire\Admin;

use App\Models\ExeatRequest;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ApproveExeatRequests extends Component
{
    use WithPagination;

    public $showActionModal = false;
    public $selectedRequest;
    public $actionType; // 'approve' or 'deny'
    public $admin_remarks = '';

    public function openActionModal($requestId, $actionType)
    {
        $this->selectedRequest = ExeatRequest::with('student.user', 'parent')->findOrFail($requestId);
        $this->actionType = $actionType;
        $this->admin_remarks = '';
        $this->showActionModal = true;
    }

    public function confirmAction()
    {
        $this->validate(['admin_remarks' => 'nullable|string']);

        $newStatus = $this->actionType === 'approve' ? 'approved' : 'denied';

        $this->selectedRequest->update([
            'status' => $newStatus,
            'approved_by' => Auth::id(),
            'admin_remarks' => $this->admin_remarks,
        ]);

        // Send a WhatsApp Notification (requires parent phone number on user model)
        // $parentPhoneNumber = $this->selectedRequest->parent->phone_number;
        // if ($parentPhoneNumber) {
        //     $studentName = $this->selectedRequest->student->user->name;
        //     $message = "Dear Parent, the exeat request for {$studentName} has been {$newStatus}.";
        //     if ($newStatus === 'approved') {
        //         $message .= " View the pass here: " . route('exeat.verify', $this->selectedRequest->token);
        //     }
        //     WhatsAppService::sendMessage($parentPhoneNumber, $message);
        // }

        session()->flash('message', "Exeat request has been {$newStatus}.");
        $this->showActionModal = false;
    }

    public function render()
    {
        return view('livewire.admin.approve-exeat-requests', [
            'requests' => ExeatRequest::where('status', 'pending')->with('student.user', 'parent')->latest()->paginate(10)
        ]);
    }
}