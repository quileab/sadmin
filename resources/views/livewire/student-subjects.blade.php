<div>
  <div class="px-4 py-2 flex items-center d2c w-full">
    Matriculación » Estudiantes » Materias »
    Estudiante: {{ $student->lastname }}, {{ $student->firstname }}
  </div>
  <div class="mx-auto px-4 bg-gray-200 overflow-hidden rounded-lg shadow-md">
    <div class="p-2">
    Carrera&nbsp;
    <select wire:model.lazy="career_id">
      @foreach ($careers as $career)
        <option value='{{ $career->id }}'>{{ $career->name }}</option>
      @endforeach
    </select>
    </div>

    <div class="p-0 flex flex-wrap mx-auto">
      @foreach ($subjects as $subject)
        <div class="flex w-1/3 rounded shadow-md shadow-gray-600 bg-gray-50 m-2 overflow-hidden">
          <div @class([
              'py-2',
              'w-1/4',
              'bg-gray-700',
              'text-white',
              'text-center',
              'bg-green-700' => isset($subjects_selected[$subject->id]),
          ])>
            {{ $subject->id }}<br />
            {{-- button on/off --}}
            <button wire:click="toggleSubject({{ $subject->id }})">
              @if (isset($subjects_selected[$subject->id]))
                <x-svg.switchRight class="h-7 w-7" />
              @else
                <x-svg.switchLeft class="h-7 w-7" />
              @endif
            </button>

          </div>
          <div class="p-2 w-3/4">
            {{ $subject->name }}
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
