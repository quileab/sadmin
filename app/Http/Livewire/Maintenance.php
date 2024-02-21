<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Config;


class Maintenance extends Component
{
    public $message;

    public function render()
    {
        return view('livewire.maintenance');
    }

    public function backupDatabase()
    {
        $dbConfig=Config::get('database.connections.mysql');
        $fileName="backup-".$dbConfig['database'].".sql";
        $filePath=storage_path().'/app/backup/';
        if(!File::exists($filePath)){
            File::makeDirectory($filePath, $mode = 0777, true, true);
        }

        $command = "mysqldump --user=" . $dbConfig['username'] ." --password=" . $dbConfig['password'] . " --host=" . $dbConfig['host'] . " " . $dbConfig['database'] . " > " .$filePath.$fileName;
        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
        if($returnVar == 0){
            return response()->download($filePath.$fileName);
        }
        else{
            $this->message='Error: Cannot create backup. '.$returnVar;
        }
    }

}
