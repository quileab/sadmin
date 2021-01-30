<?php

namespace App\Http\Livewire;

use Livewire\Component;

class GradesComponent extends Component
{
    public $uid;

    // toma el valor enviado desde el Router (web.php) // livewire no utiliza __construct
    public function mount($id){
        $this->uid=$id;


        // $career=\App\Models\Career::find($career_id);
        // $this->career_name=$career->name;

    }

    public function render()
    {
        return view('livewire.grades-component');
    }
}
