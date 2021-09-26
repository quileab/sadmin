<?php

namespace App\Http\Livewire;

use App\Models\Config;
use Livewire\Component;

class ConfigsComponent extends Component
{
    public $uid, $group, $description, $value, $type;
    public $formAction = "store";
    public $updateForm = false;
    
    public function render()
    {
        $configs=Config::orderBy('group','asc')->orderBy('id','asc')->get();
        return view('livewire.configs-component',compact('configs'));
    }

    public function saveChange(){
        $config=Config::find($this->uid);
        $config->value=$this->value;
        $config->type=$this->type;
        
        $config->save();
        $this->updateForm=false;
    }

    public function showModalForm(Config $config){
        $this->uid=$config->id;
        $this->group=$config->group;
        $this->description=$config->description;
        $this->value=$config->value;
        $this->type=$config->type;
        $this->updateForm=true;
    }

    // public function store(){
    //     $user = auth()->user();
        
    //     Infocard::create([
    //         'title'=>$this->title,
    //         'text'=>$this->text,
    //         'type'=>$this->type,
    //         'user_id'=>$user->id
    //     ]);
    //     $this->reset(['title','text','type']);
    // }

    // public function edit(Infocard $infocard){
    //     $this->title=$infocard->title;
    //     $this->text=$infocard->text;
    //     $this->type=$infocard->type;
    //     $this->uid=$infocard->id;
    //     $this->formAction = "update";
    // }

    // public function update(){
    //     $user = auth()->user();

    //     $infocard=Infocard::find($this->uid);
        
    //     $infocard->update([
    //         'title'=>$this->title,
    //         'text'=>$this->text,
    //         'type'=>$this->type,
    //         'user_id'=>$user->id
    //     ]);
    //     $this->reset(['title','text','type','uid','formAction']);
    // }

    // public function default(){
    //     $this->reset(['title','text','type','uid','formAction']);
    // }

    // public function destroy(Infocard $infocard){
    //     $infocard->delete();
    // }

}
