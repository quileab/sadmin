<div class="bg-gray-300 pb-2">
  <x-jet-dialog-modal wire:model="openModal">
    <x-slot name="title">
        Calificar
    </x-slot>
    <x-slot name="content">

      <div class="inline-flex">
      <div>
      <x-jet-label value="Calificación" />
      <x-jet-input type="number" wire:model.defer='grade' id="grade" />
      <x-jet-input-error for="grade" />
      </div>

        <div class="mx-2 p-1 border rounded border-gray-300 text-center">
          <x-jet-label value="Aprobado" />
          <x-jet-input type="checkbox" wire:model.defer='approved' id="approved" />
          <x-jet-input-error for="approved" />
        </div>

        <div class="mx-2 p-1 border rounded border-gray-300 text-center bg-red-300">
          <x-jet-label value="Eliminar" />
          <x-jet-input type="checkbox" wire:model.defer='remove' id="remove" />
          <x-jet-input-error for="remove" />
        </div>
      </div>

      
      <x-jet-label value="Descripción" />
      <x-jet-input type="text" wire:model.defer='description' id="description" />
      <x-jet-input-error for="description" />
    </x-slot>
    <x-slot name="footer">
      <div class="flex justify-between">
        @if ($errors->any())
          <div class="text-yellow-300">Verifique la información ingresada</div>
        @endif
        <x-jet-button wire:click="updateOrSaveGrade" wire:loading.attr="disabled" wire:target="save">
          Guardar
        </x-jet-button>
        <x-jet-danger-button wire:click="$set('openModal',false)">Cancelar</x-jet-danger-button>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="w-full d2c px-4 py-3 text-white flex justify-between">
    Calificación Rápida
  </div>
  <div class="flex justify-evenly mx-2 my-1">
    <div class="w-1/3 mx-1">
      Inscripcion 
      <select class="w-full" wire:model.lazy="inscriptionType_id">
        @foreach ($inscriptionTypes as $inscriptionType)
          <option value="{{ $inscriptionType->id }}">{{ $inscriptionType->description }}</option>
        @endforeach
      </select>
    </div>
    <div class="w-1/3 mx-1">
      Carrera 
      <select class="w-full" wire:model.lazy="career_id">
        @foreach ($careers as $career)
          <option value="{{ $career->id }}">{{ $career->id }}: {{ $career->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="w-1/3 mx-1">
      Materia 
      <select class="w-full" wire:model.lazy="subject_id">
        @foreach ($subjects as $subject)
          <option value="{{ $subject->id }}">{{ $subject->id }}: {{ $subject->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="w-1/3 mx-1">
      Fecha
      <x-jet-input type="date" wire:model.lazy="gradeDate" class='w-full' />
    </div>
    {{-- <div class="w-1/3 mx-1">
      Estudiante<br />
      <x-jet-input type="text" wire:model.lazy="student_srch" class='w-full' />
    </div> --}}
  </div>

  {{-- <div class="m-2 p-2 rounded-md border-2 border-blue-300 bg-blue-100">
    @if($student!==null)
    {{$student->id}}: {{$student->lastname}}, {{$student->firstname}}
    @endif
  </div> --}}

  <div class="m-2">
  <table class="w-full shadow overflow-hidden rounded-md bg-gray-200">
    <thead>
      <tr>
        <th>Student</th>
        <th>Fechas</th>
        <th>Calif.</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($inscriptions as $key=>$inscription)
      @if($inscription['isStudent']=='1')
      <tr @class([
        'text-green-600'=>$inscription['approved'],
        'bg-red-200'=>!$inscription['enabled']
        ])>
        <td class="px-2">{{$inscription['full_name']}} <small>({{$inscription['user_id']}})</small></td>
        <td class="text-center">{{$inscription['value']}}</td>
        <td class="text-right">{{$inscription['grade']}} 
          <x-jet-button wire:click="edit({{$key}})"><x-svg.edit /></x-jet-button>
        </td>
      </tr>
      @endif
      @endforeach
    </tbody>
  </table>
  </div>

  <!-- Loading indicator -->
  <div wire:loading class="spin absolute top-0 left-1/2">
    <x-svg.wait class="w-[7rem] h-[7rem] m-0 p-0" />
  </div>

{{-- <pre>
  {!! var_dump($inscriptions) !!}
  insctypeid {{$inscriptionType_id}}
  careerid {{$career_id}}
  subjectid {{$subject_id}}
</pre> --}}
</div>