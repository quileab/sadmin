<?php

namespace App\Http\Livewire;

use Throwable;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Classbooks extends Component
{
    public $openModal = false;
    public $updating = false;
    public $deleteModal = false;

    // record
    public $date_id;
    public $subject_id;
    public $user_id = null;
    public $classnr=0;
    public $unit=0;
    public $type='';
    public $contents='';
    public $activities='';
    public $observations='';

    // utility
    public $Me;
    public $mySubjects; 
    public $subject_classes=[];
    public $calendar='';

    protected $rules = [
        'subject'=>'required'
        //'uid'=>'required|numeric',
        //'name' => 'required|unique:users,name',
        //'pid' => 'unique:users,pid|required|numeric',
    ];

    public function mount(){
        $this->Me=Auth::user();
        $this->mySubjects=$this->Me->enrolled_subjects()->get();

        if (count($this->mySubjects)!==0) {
            if (session()->has('subject_id')){
                $this->subject_id=session('subject_id');
            } else {
                $this->subject_id=$this->mySubjects->first()->id;
            }
            $this->updatedSubjectId($this->subject_id);
        }else{
            $this->subject_id=0;
        }
    }
    
    public function render(){
        $this->subject_classes=\App\Models\Subject::classes($this->subject_id);
        return view('livewire.classbooks');
    }
    
    public function updatedSubjectId($value){
        $this->subject_id=$value;
        $this->subject_classes=\App\Models\Subject::classes($this->subject_id);
        session(['subject_id'=>$this->subject_id]);
    }

    // @param $date_id datetime
    public function createOrUpdate($date_id){
        if ($date_id==0){ // create
            $this->updating=false;
            $this->reset([
                'user_id','unit','type',
                'contents','activities','observations'
            ]);
            //set defaults
            $this->date_id=today()->toDateString();
            // count classes of current 'cycle' setted in session('cycle')
            $this->classnr=\App\Models\Classbook::where('subject_id',$this->subject_id)
                ->whereBetween(
                    'date_id', [session('cycle').'-01-01',session('cycle').'-12-31']
                )->count()+1;
            
            // $this->classnr=\App\Models\Classbook::where('subject_id',$this->subject_id)
            //     ->max('ClassNr')+1;
            $this->openModal=true;
            }
        else{ // update
            $this->updating=true;
            $class=\App\Models\Subject::getClass($this->subject_id,$date_id);            
            $this->date_id=$class->date_id;
            $this->user_id = $this->Me;
            $this->classnr=$class->ClassNr;
            $this->unit=$class->Unit;
            $this->type=$class->Type;
            $this->contents=$class->Contents;
            $this->activities=$class->Activities;
            $this->observations=$class->Observations;
        
            $this->openModal=true;
        }
    }

    public function update(){
        $class=new \App\Models\Classbook();
        $result=$class::where('subject_id',$this->subject_id)
          ->where('date_id',$this->date_id)
          ->update([
            'subject_id'=>$this->subject_id,
            'user_id'=>$this->Me->id,
            'ClassNr'=>$this->classnr,
            'Unit'=>$this->unit,
            'Type'=>$this->type,
            'Contents'=>$this->contents,
            'Activities'=>$this->activities,
            'Observations'=>$this->observations
          ]);
        $type=$result>0 ? 'info':'error';
        $this->emit('toast', 'Actualizado ('.$result.')', $type);
        $this->openModal=false;
    }

    public function save(){
        try {
            $class=new \App\Models\Classbook();
            $class->subject_id=$this->subject_id;
            $class->date_id=$this->date_id;
            $class->user_id=$this->Me->id;
            $class->ClassNr=$this->classnr;
            $class->Unit=$this->unit;
            $class->Type=$this->type;
            $class->Contents=$this->contents;
            $class->Activities=$this->activities;
            $class->Observations=$this->observations;
            $result=$class->save();
            } catch (Throwable $e) {
                $error=implode(' ', array_slice(explode(' ', $e->getMessage()), 0, 7));
                $this->emit('toast', 'ERROR: '.$error.'...', 'danger');
                //report($e);  
                return false;
        }
  
        $this->emit('toast', 'Guardado ('.$result.')', 'info');
        $this->openModal=false;
    }

    public function calendar($date = null) {
        // create date keyed event texts
        $captions=[];
        foreach($this->subject_classes as $subject){
            $captions[$subject->date_id]=$subject->Contents;
        }
        //if date empty then now() else create from Date
        $date = empty($date) ? Carbon::now() : Carbon::createFromDate($date);
        $startOfCalendar = $date->copy()->firstOfMonth()->startOfWeek(Carbon::SUNDAY);
        $endOfCalendar = $date->copy()->lastOfMonth()->endOfWeek(Carbon::SATURDAY);

        $html = '<div class="calendar">';

        $html .= '<div class="month-year">';
        $html .= '<span class="month">' . $date->translatedFormat('M') . '</span>';
        $html .= '<span class="year">' . $date->format('Y') . '</span>';
        $html .= '</div>';

        $html .= '<div class="days">';

        $dayLabels = ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'];
        foreach ($dayLabels as $dayLabel)
        {
            $html .= '<span class="day-label">' . $dayLabel . '</span>';
        }

        while($startOfCalendar <= $endOfCalendar)
        {
            $caption= isset($captions[$startOfCalendar->format('Y-m-d')]) ? ' »'.$captions[$startOfCalendar->format('Y-m-d')] : '';
            $extraClass = $startOfCalendar->format('m') != $date->format('m') ? 'dull' : '';
            $extraClass .= $startOfCalendar->isToday() ? ' today' : '';
            //$extraClass .= $caption='' ? '' : ' bg-blue-800';

            $html .= '<span class="day '.$extraClass.'"><span class="content">' . $startOfCalendar->format('j') . '<small>'.$caption.'</small>' .'</span></span>';
            $startOfCalendar->addDay();
        }
        $html .= '</div></div>';
        return $html;
    }

    public function confirmDeletion($subject_id,$date_id){
        $this->deleteModal=true;
        $this->subject_id=$subject_id;
        $this->date_id=$date_id;
    }

    public function delete($subject_id,$date_id){
        // delete from classbook
        $result=\App\Models\Classbook::where('subject_id',$subject_id)
        ->where('date_id',$date_id)->delete();
        if($result){
            $this->emit('toast', 'Borrado ('.$result.')', 'info');
        }else{
            $this->emit('toast', 'No se pudo borrar', 'error');
        }
        $this->deleteModal=false;  
    }

    public function createCalendar(){
      if ($this->calendar=='') {
          $this->calendar = $this->calendar();
        }
      else {
        $this->calendar='';
        }
    }
}
