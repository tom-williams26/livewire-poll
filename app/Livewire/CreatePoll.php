<?php

namespace App\Livewire;

use App\Models\Poll;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreatePoll extends Component
{
    #[Validate(
        'required|min:3|max:255',
        message: 'Please enter a title for the poll.',
    )]
    public $title;

    #[Validate(
        [
            'options' => 'required',
            'options.*' => 'required|min:1|max:255',
        ],
        message: [
            'required' => 'The :attribute is missing.',
            'options.required' => 'The :attribute are missing.',
            'min' => 'The :attribute is too short.',
        ],
        attribute: [
            'options.*' => 'option',
        ],
    )]
    public $options = ['First'];

    public function render()
    {
        return view('livewire.create-poll');
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption($index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options);
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function createPoll()
    {
        $this->validate();

        $poll = Poll::create([
            'title' => $this->title
        ])->options()->createMany(
            collect($this->options)
                ->map(fn($option) => ['name' => $option])
                ->all()
        );

        $this->reset(['title', 'options']);
    }
}
