<?php

namespace App\Livewire;

use Livewire\Component;

class PollsList extends Component
{
    public function render()
    {
        $pollsList = \App\Models\Poll::with('options.votes')->latest()->get();

        return view('livewire.polls-list', ['pollsList' => $pollsList]);
    }
}
