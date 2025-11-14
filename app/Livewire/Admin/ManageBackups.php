<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Carbon\Carbon; // Make sure Carbon is imported

class ManageBackups extends Component
{
    public $backups = [];

    public function mount()
    {
        $this->loadBackups();
    }

    public function loadBackups()
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $files = $disk->allFiles(config('backup.backup.name'));
        
        $this->backups = collect($files)
            ->map(function ($file) use ($disk) {
                return [
                    'path' => $file,
                    'name' => basename($file),
                    'size' => round($disk->size($file) / 1024 / 1024, 2) . ' MB',
                    'date' => Carbon::createFromTimestamp($disk->lastModified($file))->toDateTimeString(),
                ];
            })
            ->reverse()
            ->toArray();
    }

    public function createBackup()
    {
        // We'll run this in the background to prevent timeouts on larger databases
        Artisan::queue('backup:run', ['--only-db' => true]);
        session()->flash('message', 'A new database backup has been queued and will be created shortly.');
        $this->loadBackups();
    }

    public function download($fileName)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $filePath = config('backup.backup.name') . '/' . $fileName;

        if ($disk->exists($filePath)) {
            return $disk->download($filePath);
        }

        session()->flash('error', 'The requested backup file could not be found.');
    }

    public function delete($fileName)
    {
        $disk = Storage::disk(config('backup.backup.destination.disks')[0]);
        $filePath = config('backup.backup.name') . '/' . $fileName;

        if ($disk->exists($filePath)) {
            $disk->delete($filePath);
            session()->flash('message', 'The backup was deleted successfully.');
            $this->loadBackups();
        } else {
            session()->flash('error', 'The backup file could not be found for deletion.');
        }
    }

    public function render()
    {
        return view('livewire.admin.manage-backups');
    }
}