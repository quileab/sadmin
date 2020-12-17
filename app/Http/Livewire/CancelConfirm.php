<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CancelConfirm extends Component
{
    public $color='purple'; // default if nothing
    public $title='Title';
    public $message="Empty";
    public $cancelConfirmVisible=false;

    public function alertOn(){
        $this->cancelConfirmVisible=true;
    }

    public function render()
    {
        return view('livewire.cancel-confirm');
    }
}
