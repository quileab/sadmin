<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;
use Livewire\WithPagination;

class ShowBooks extends Component
{
    use WithPagination;
    public $search='';    
    public $sort='id';
    public $cant='10';
    public $direction='asc';
    public $openModal=false;
    public $updating=false;
    public $readyToLoad=false;

    public $book;
    // --- Record ---
    public $uid, $title, $publisher, $author,
           $gender, $extent, $edition, $isbn,
           $container, $signature, $digital, $origin,
           $date_added, $price, $discharge_date,
           $discharge_reason, $synopsis, $note, $user_id;

    // *** VARIOS PROTECTED de Livewire ***

    // Listener para los EMIT - Conexión entre PHP-JS
    protected $listeners=['delete','bookmarkCleared']; 
        
    // Para este caso no es necesario PERO lo dejo como ejemplo
    protected $queryString=[
        'cant'=>['except'=>'10'],
        'sort'=>['except'=>'id'],
        'direction'=>['except'=>'asc'],
        'search'=>['except'=>'']
    ];
    
    protected $rules=[
        'uid'=>'required|numeric',
        'title'=>'required', 
        'publisher'=>'required', 
        'author'=>'required',
        'gender'=>'required',
        'extent'=>'required|numeric',
        'edition'=>'required|date',
        // 'isbn',
        // 'container',
        // 'signature',
        // 'digital',
        'origin'=>'required',
        'date_added'=>'required',
        'price'=>'required',
        'discharge_date'=>'required',
        // 'discharge_reason',
        'synopsis'=>'required',
        // 'note',
        // 'user_id'

    ];

    public function render()
    {
        if ($this->readyToLoad){
            //$this->search='ladr sanch';
            $searchValues = preg_split('/\s+/', $this->search, -1, PREG_SPLIT_NO_EMPTY);
            $books=Book::where(function($query) use ($searchValues){
                    foreach ($searchValues as $srch) {
                        $query->whereRaw(\Illuminate\Support\Facades\DB::raw('CONCAT(title,author,synopsis) LIKE "%'.$srch.'%"'));
                    }
                })
                ->orderBy($this->sort,$this->direction)->paginate($this->cant);
        } else {
            $books=[];
        }

        // $books=Book::where('title','like','%'.$this->search."%")
        //     ->orwhere('synopsis','like','%'.$this->search."%")
        //     ->orwhere('author','like','%'.$this->search."%")
        //     ->orderBy($this->sort, $this->direction)
        //     ->paginate($this->cant);
        // } else {
        //     $books=[];
        // }      
        return view('livewire.show-books', compact('books'));
        // si quiero que utilice una plantilla diferente a app.blade.php -> name.blade.php
        // return view('livewire.show-books')->layout('layouts.name');
    }

    public function loadData(){
        $this->readyToLoad=true;
    }

    public function updatingSearch(){ // livewire hook - cuando cambie la variable $search
        // updating+Variable ---> $variable
        // permite reiniciar el paginado para que
        // funcione correctamente la búsqueda.
        $this->resetPage(); 
    }

    public function order($sort){
        if ($sort==$this->sort){
            if ($this->direction=="desc"){
                $this->direction="asc";
            }else{
                $this->direction="desc";
            }
        }
        else{
            $this->sort=$sort;
        }
        
    }
    
    public function newBook(){
        $this->reset([
            'uid', 'title', 'publisher', 'author', 'gender',
            'extent', 'edition', 'isbn', 'container', 'signature',
            'digital', 'origin', 'date_added', 'price',
            'discharge_date', 'discharge_reason', 'synopsis',
            'note', 'user_id'
        ]);
        $this->updating=false;
        $this->openModal=true;
        $this->emit('toast','Nuevo Libro','success');
    }

    public function save(){ 
        $this->validate($this->rules);
        
        if (!$this->updating){
        
        book::create([
            'id'=>$this->uid,
            'title'=>$this->title,
            'publisher'=>$this->publisher,
            'author'=>$this->author,
            'gender'=>$this->gender,
            'extent'=>$this->extent,
            'edition'=>$this->edition,
            'isbn'=>$this->isbn,
            'container'=>$this->container,
            'signature'=>$this->signature,
            'digital'=>$this->digital,
            'origin'=>$this->origin,
            'date_added'=>$this->date_added,
            'price'=>$this->price,
            'discharge_date'=>$this->discharge_date,
            'discharge_reason'=>$this->discharge_reason,
            'synopsis'=>$this->synopsis,
            'note'=>$this->note,
            'user_id'=>$this->user_id,
        ]);
        }
        else // update !
        {
            $this->book->id=$this->uid;
            $this->book->title=$this->title;
            $this->book->publisher=$this->publisher;
            $this->book->author=$this->author;
            $this->book->gender=$this->gender;
            $this->book->extent=$this->extent;
            $this->book->edition=$this->edition;
            $this->book->isbn=$this->isbn;
            $this->book->container=$this->container;
            $this->book->signature=$this->signature;
            $this->book->digital=$this->digital;
            $this->book->origin=$this->origin;
            $this->book->date_added=$this->date_added;
            $this->book->price=$this->price;
            $this->book->discharge_date=$this->discharge_date;
            $this->book->discharge_reason=$this->discharge_reason;
            $this->book->synopsis=$this->synopsis;
            $this->book->note=$this->note;
            $this->book->user_id=$this->user_id;

            $this->book->save();
        }

        //$this->openModal=false;
        if ($this->updating){
            $this->emit('toast','Actualizado correctamente','success');
        }else{
            $this->emit('toast','Guardado correctamente','success');
        }
        
        $this->reset([
            'openModal','updating',
            'id', 'title', 'publisher', 'author', 'gender',
            'extent', 'edition', 'isbn', 'container', 'signature',
            'digital', 'origin', 'date_added', 'price',
            'discharge_date', 'discharge_reason', 'synopsis',
            'note', 'user_id'
        ]);
    }

    public function edit($uid){ 
        $this->book=book::find($uid);
        $this->uid=$this->book->id;
        $this->title=$this->book->title;
        $this->publisher=$this->book->publisher;
        $this->author=$this->book->author;
        $this->gender=$this->book->gender;
        $this->extent=$this->book->extent;
        $this->edition=$this->book->edition;
        $this->isbn=$this->book->isbn;
        $this->container=$this->book->container;
        $this->signature=$this->book->signature;
        $this->digital=$this->book->digital;
        $this->origin=$this->book->origin;
        $this->date_added=$this->book->date_added;
        $this->price=$this->book->price;
        $this->discharge_date=$this->book->discharge_date;
        $this->discharge_reason=$this->book->discharge_reason;
        $this->synopsis=$this->book->synopsis;
        $this->note=$this->book->note;
        $this->user_id=$this->book->user_id;

        $this->updating=true;
        $this->openModal=true;
        $this->emit('toast','Preparado para Edición','info');
    }

    public function delete(book $book){
        $book->delete();
        $this->emit('toast','Registro eliminado','error');
    }

    public function bookmarkCleared(){
        $this->render();
    }

    public function bookLendReturn(book $book, bool $action){
        if ($action) {
            $book->user_id=session('bookmark');
            $this->emit('toast', 'Libro Prestado', 'success');
        } else {
            $book->user_id=null;
            $this->emit('toast', 'Libro Devuelto', 'success');
        }
        $book->save();
        $this->render();
    }

}
