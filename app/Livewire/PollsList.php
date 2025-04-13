<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Component;

class PollsList extends Component
{
    #[On('pollCreated')]
    public function render()
    {
        $pollsList = \App\Models\Poll::with('options.votes')
            ->latest()->get();

        return view('livewire.polls-list', ['pollsList' => $pollsList]);
    }

    public function vote(Option $option)
    {
        $option->votes()->create();
    }
}
