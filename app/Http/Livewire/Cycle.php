<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Cycle extends Component
{
    public $cycle;

    public function mount()
    {
        $this->cycle = session('cycle');
    }

    public function render()
    {
        return view('livewire.cycle');
    }

    public function setCycle(){
        session()->put('cycle',$this->cycle);
        session()->save();
        $this->emit('toast', 'Actualizado '.session('cycle').'', 'info');
    }
}
