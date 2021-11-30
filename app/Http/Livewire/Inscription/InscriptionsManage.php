<?php

namespace App\Http\Livewire\Inscription;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class InscriptionsManage extends Component
{
    public $files=[];
    public $inscripts=[];
    public $careers=[];
    public $inscripts_id;
    public $selectedCount=0;

    public function mount()
    {
        $this->files = Storage::files('private/inscriptions');
        //dd($this->files);
        foreach ($this->files as $key => $file) {
            $this->files[$key] = str_replace('private/inscriptions/', 'files/private/', $file);
            $user_id = explode('-', $this->files[$key])[1];
            $career_id = explode('-', $this->files[$key])[2];
            $config_incription_id = explode('-', $this->files[$key])[3];
            $user=\App\Models\User::find($user_id);
            if ($user!=null) {
                $username=$user->lastname.', '.$user->firstname;
                //dd($user);
            }else{
                $username='No encontrado';
                //dd($user, $key);
            }
            $this->careers=\App\Models\Career::all();
            $career=\App\Models\Career::find($career_id)->name;
            $this->inscripts[$key]['filename'] = $file;
            $this->inscripts[$key]['user'] = $username;
            $this->inscripts[$key]['career'] = $career;
            $this->inscripts[$key]['inscription'] = $config_incription_id;//\App\Models\Config::find($config_incription_id);
            $this->inscripts[$key]['pdflink'] = $this->files[$key];
            $this->inscripts[$key]['checked'] = false;
        }
        // convertir en collection y ordenar por carrera y usuario
        $this->inscripts=collect($this->inscripts)->sortBy(['career','user']);
        // return to array
        $this->inscripts=$this->inscripts->toArray();
    }

    public function render(){
        $inscripts=$this->inscripts;
        $careers=$this->careers;
        return view('livewire.inscription.inscriptions-manage',compact('inscripts','careers'));
    }

    public function fileSelect($key){
        $this->inscripts[$key]['checked'] = !$this->inscripts[$key]['checked'];
        $this->selectedCount = array_reduce($this->inscripts, function ($carry, $item) {
            return $carry + ($item['checked'] ? 1 : 0);
        }, 0);
    }

    public function deleteSelected(){
        foreach ($this->inscripts as $key => $inscript) {
            if ($inscript['checked']) {
                Storage::delete($inscript['filename']);
                unset($this->inscripts[$key]);
            }
        }
        $this->inscripts = array_values($this->inscripts);
        $this->selectedCount = 0;
    }

      

}