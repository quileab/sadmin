<?php

namespace App\Http\Livewire;

use App\Models\Subject;
use Livewire\Component;

class SubjectsComponent extends Component
{
    public $uid;

    public $name;

    public $correl;
    public $correl_course;
    public $correl_exam;
    public $career_id;
    public $career_name;
    public $formAction = 'store';
    public $updateSubjectForm = false;

    // toma el valor enviado desde el Router (web.php) // livewire no utiliza __construct
    private function cleanDates($dates)
    {
        $dates = str_replace('  ', ' ', $dates);
        $dates = str_replace([':', '\\', '  ', '*'], '', $dates);
        $dates = str_replace(['/', '.'], '-', $dates);

        return $dates;
    }

    public function mount($career_id)
    {
        $this->career_id = $career_id;
        $career = \App\Models\Career::find($career_id);
        $this->career_name = $career->name;

        //dd('mount',$career_id);
    }

    public function render()
    {
        $subjects = Subject::where('career_id', $this->career_id)->get();
        // fullpage livewire por lo tanto no uso "index"
        return view('livewire.subjects-component', compact('subjects'));
    }

    public function store()
    {
        //$this->exam_dates=$this->cleanDates($this->exam_dates);

        Subject::create([
            'id' => $this->uid,
            'name' => $this->name,
            'correl' => $this->correl,
            //'exam_dates'=>$this->exam_dates,
            'career_id' => $this->career_id,
        ]);
        $this->reset(['uid', 'name', 'correl']);
        $this->updateSubjectForm = false;
    }

    public function edit(Subject $subject){
        $this->uid = $subject->id;
        $this->name = $subject->name;
        $this->correl = $subject->correl;
        //$this->exam_dates=$subject->exam_dates;

        $subjects=Subject::where('career_id', $this->career_id)->pluck('name', 'id');
        $correl_course_temp = $subject->Correlativities("course");
        $correl_exam_temp = $subject->Correlativities("exam");
        foreach($subjects as $key=>$name){
            $this->correl_course[$key]['name']=$name;
            $this->correl_course[$key]['selected']=isset($correl_course_temp[$key]);
        }
        foreach($subjects as $key=>$name){
            $this->correl_exam[$key]['name']=$name;
            $this->correl_exam[$key]['selected']=isset($correl_exam_temp[$key]);
        }

        //dd( $this->correl_course, $this->correl_exam));

        $this->formAction = 'update';
        $this->updateSubjectForm = true;
    }

    public function toggleSelection($key, $type='exam'){
        if($type=='exam'){
            $this->correl_exam[$key]['selected'] = !$this->correl_exam[$key]['selected'];
        }else{
            $this->correl_course[$key]['selected'] = !$this->correl_course[$key]['selected'];
        }
        $correl='';
        foreach($this->correl_course as $key=>$value){
            if($value['selected']){
                $correl.=$key.' ';
            }
        }
        $correl.='/';
        foreach($this->correl_exam as $key=>$value){
            if($value['selected']){
                $correl.=$key.' ';
            }
        }
        $this->correl=$correl;
        //dd($this->correl)

    }

    public function saveSubjectChange(){
        //$this->exam_dates=$this->cleanDates($this->exam_dates);

        $this->formAction = 'update';
        $subject = Subject::find($this->uid);
        $subject->career_id = $this->career_id;
        $subject->name = $this->name;
        $subject->correl = $this->correl;
        //$subject->exam_dates=$this->exam_dates;

        $subject->save();
        // cerrar Update Modal
        $this->updateSubjectForm = false;
    }

    public function create()
    {
        $this->reset(['uid', 'name', 'correl']);

        $this->formAction = 'store';
        $this->updateSubjectForm = true;
    }

    public function showModalSubjectForm(Subject $subject)
    {
        $this->uid = $subject->id;
        $this->name = $subject->name;
        $this->resol = $subject->correl;
        //$this->exam_dates=$subject->exam_dates;

        // Modificar (Edit)-> true
        $this->updateSubjectForm = true;
    }

    public function destroy(Subject $subject)
    {
        //dd('destroy',$subject);
        try {
            $subject->delete();
        } catch(\Exception $e) {
            $this->emit('toast', 'ERROR: Esta MATERIA puede contener INSCRIPCIONES', 'error');
        }
    }

}
