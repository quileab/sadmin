<?php

namespace App\Http\Livewire\Inscription;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class InscriptionsManage extends Component
{
    public $files=[];
    public $inscripts=[];
    public $inscripts_id;

    public function mount()
    {
        $this->files = Storage::files('private/inscriptions');
        
        foreach ($this->files as $key => $file) {
            $this->files[$key] = str_replace('private/inscriptions/', 'files/private/', $file);
            $user_id = explode('-', $this->files[$key])[1];
            $career_id = explode('-', $this->files[$key])[2];
            $config_incription_id = explode('-', $this->files[$key])[3];
            $this->inscripts[$key]['filename'] = $this->files[$key];
            $this->inscripts[$key]['user'] = \App\Models\User::find($user_id);
            $this->inscripts[$key]['career'] = \App\Models\Career::find($career_id);
            $this->inscripts[$key]['inscription'] = $config_incription_id;//\App\Models\Config::find($config_incription_id);
            $this->inscripts[$key]['pdflink'] = $this->files[$key];
        }
        //dd(array_multisort($this->inscripts, array('career'=>SORT_ASC)));
    }

    public function render(){
        $inscripts=$this->inscripts;
        return view('livewire.inscription.inscriptions-manage',compact('inscripts'));
    }
}
