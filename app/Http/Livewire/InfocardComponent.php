<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Infocard;

class InfocardComponent extends Component
{
    public $uid, $title, $text, $type;

    public $formAction = "store";

    public function render()
    {
        $infocards=Infocard::latest('id')->paginate(5);
        return view('livewire.infocard-component',compact('infocards'));
    }

    public function store(){
        $user = auth()->user();
        
        Infocard::create([
            'title'=>$this->title,
            'text'=>$this->text,
            'type'=>$this->type,
            'user_id'=>$user->id
        ]);
        $this->reset(['title','text','type']);
    }

    public function edit(Infocard $infocard){
        $this->title=$infocard->title;
        $this->text=$infocard->text;
        $this->type=$infocard->type;
        $this->uid=$infocard->id;
        $this->formAction = "update";
    }

    public function update(){
        $user = auth()->user();

        $infocard=Infocard::find($this->uid);
        
        $infocard->update([
            'title'=>$this->title,
            'text'=>$this->text,
            'type'=>$this->type,
            'user_id'=>$user->id
        ]);
        $this->reset(['title','text','type','uid','formAction']);
    }

    public function default(){
        $this->reset(['title','text','type','uid','formAction']);
    }

    public function destroy(Infocard $infocard){
        $infocard->delete();
    }

}
