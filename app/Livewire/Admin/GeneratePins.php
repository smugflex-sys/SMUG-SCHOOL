<?php

namespace App\Livewire\Admin;

use App\Models\ResultPin;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class GeneratePins extends Component
{
    use WithPagination;

    public $quantity = 10;
    public $usage_limit = 5;
    public $generatedPins = [];

    public function generate()
    {
        $this->validate([
            'quantity' => 'required|integer|min:1|max:1000',
            'usage_limit' => 'required|integer|min:1',
        ]);

        $this->generatedPins = [];
        for ($i = 0; $i < $this->quantity; $i++) {
            $pin = $this->generateUniquePin();
            ResultPin::create([
                'pin' => $pin,
                'usage_limit' => $this->usage_limit,
            ]);
            $this->generatedPins[] = $pin;
        }

        session()->flash('message', "{$this->quantity} new result checker PINs have been generated successfully.");
        $this->resetPage(); // Go back to the first page of pagination to see new pins
    }

    private function generateUniquePin()
    {
        do {
            // Generate a 12-digit random number
            $pin = str_pad(random_int(0, 999999999999), 12, '0', STR_PAD_LEFT);
        } while (ResultPin::where('pin', $pin)->exists());

        return $pin;
    }

    public function render()
    {
        return view('livewire.admin.generate-pins', [
            'pins' => ResultPin::latest()->paginate(20),
        ]);
    }
}