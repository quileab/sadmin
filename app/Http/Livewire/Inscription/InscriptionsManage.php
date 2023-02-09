<?php

namespace App\Http\Livewire\Inscription;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class InscriptionsManage extends Component
{
    public $files = [];
    public $inscripts = [];
    public $careers = [];
    public $inscripts_id;
    public $selectedCount = 0;

    public function mount()
    {
        $pathToStorage = storage_path('app'); // == Storage::path('');
        $pathToFiles='private/inscriptions';
        $filter ="insc-*";
        // Check if Logged User has "elevated" Roles
        if (auth()->check() && auth()->user()->hasAnyRole('admin|principal|superintendent|administrative')){
            $filter ="insc-*";
        } // Check for "self" registrations
        else{
            $filter="insc-".auth()->user()->id."-*";
        }
        $this->files=[];
        foreach (glob("$pathToStorage/$pathToFiles/$filter") as $nombre_fichero) {
            $this->files[]="$pathToFiles/".basename($nombre_fichero);
            //echo "$pathToFiles/".basename($nombre_fichero)."<br/>";
        }
        // $this->files = Storage::files('private/inscriptions');
        // if user is "student" then search files belongsTo
        //dd($this->files);
        foreach ($this->files as $key => $file) {
            $this->files[$key] = str_replace('private/inscriptions/', 'files/private/', $file);
            //dd($key, $file, $this->files[$key]);
            $user_id = explode('-', $this->files[$key])[1];
            $career_id = explode('-', $this->files[$key])[2];
            $config_incription_id = explode('-', $this->files[$key])[3];
            $user = \App\Models\User::find($user_id);
            if ($user != null) {
                $username = $user->lastname.', '.$user->firstname;
            } else {
                $username = 'No encontrado';
            }
            $this->careers = \App\Models\Career::all();
            if (count($this->careers) == 0) {
                return;
            }
            // Get career name
            $career = \App\Models\Career::where('id', $career_id)->first();
            $career != null ? $career = $career->name : $career = '🚫Carrera/Curso';

            $this->inscripts[$key]['filename'] = $file;
            $this->inscripts[$key]['user'] = $username;
            $this->inscripts[$key]['career'] = $career;
            $this->inscripts[$key]['inscription'] = $config_incription_id; //\App\Models\Config::find($config_incription_id);
            $this->inscripts[$key]['pdflink'] = $this->files[$key];
            $this->inscripts[$key]['checked'] = false;
        }
        // convertir en collection y ordenar por carrera y usuario
        $this->inscripts = collect($this->inscripts)->sortBy(['career', 'user']);
        // return to array
        $this->inscripts = $this->inscripts->toArray();
    }

    public function render()
    {
        $inscripts = $this->inscripts;
        $careers = $this->careers;

        return view('livewire.inscription.inscriptions-manage', compact('inscripts', 'careers'));
    }

    public function fileSelect($key)
    {
        $this->inscripts[$key]['checked'] = ! $this->inscripts[$key]['checked'];
        $this->selectedCount = array_reduce($this->inscripts, function ($carry, $item) {
            return $carry + ($item['checked'] ? 1 : 0);
        }, 0);
    }

    public function deleteSelected()
    {
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
