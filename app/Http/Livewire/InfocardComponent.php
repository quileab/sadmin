<?php

namespace App\Http\Livewire;

use App\Models\Infocard;
use Livewire\Component;

class InfocardComponent extends Component
{
    public $uid;

    public $title;

    public $text;

    public $type = '#991211';

    public $formAction = 'store';

    public $updateForm = false;

    // rules
    public $rules = [
        'title' => 'required',
        'text' => 'required',
        'type' => 'required',
    ];

    public function render()
    {
        $infocards = Infocard::latest('id')->paginate(5);

        return view('livewire.infocard-component', compact('infocards'));
    }

    public function store()
    {
        $this->validate();

        Infocard::create([
            'title' => $this->title,
            'text' => $this->text,
            'type' => $this->type,
            'user_id' => auth()->user()->id,
        ]);
        $this->reset(['title', 'text', 'type']);
        $this->updateForm = false;
    }

    public function edit(Infocard $infocard)
    {
        $this->title = $infocard->title;
        $this->text = $infocard->text;
        $this->type = $infocard->type;
        $this->uid = $infocard->id;

        $this->formAction = 'update';
        $this->updateForm = true;
    }

    public function create()
    {
        $this->reset(['uid', 'title', 'text', 'type', 'formAction']);
        $this->updateForm = true;
    }

    public function update()
    {
        $this->validate();

        $infocard = Infocard::find($this->uid);

        $infocard->update([
            'title' => $this->title,
            'text' => $this->text,
            'type' => $this->type,
            'user_id' => auth()->user()->id,
        ]);
        $this->reset(['title', 'text', 'type', 'uid', 'formAction']);
        $this->updateForm = false;
    }

    public function default()
    {
        $this->reset(['title', 'text', 'type', 'uid', 'formAction']);
    }

    public function destroy(Infocard $infocard)
    {
        $infocard->delete();
    }
}
