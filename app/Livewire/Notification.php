<?php

namespace App\Livewire;

use Livewire\Component;

class Notification extends Component
{
    public $message;
    public $type;

    public function notify($message, $type = 'success')
    {
        $this->message = $message;
        $this->type = $type;
        $this->emitSelf('showNotification'); // Emit an event to trigger display
    }

    public function render()
    {
        return view('livewire.notification');
    }
}
