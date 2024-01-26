<div>
  <div class="px-4 py-2 flex items-center d2c w-full">
    Matriculación » Materias » Estudiante »
    <small>({{ $student->id }})</small>
    &nbsp;{{ $student->lastname }}, {{ $student->firstname }}
  </div>
  <div class="bg-gray-200 overflow-hidden rounded-lg shadow-md py-3">
    <div class="mx-3 my-1">
    Carrera&nbsp;
    <select wire:model.lazy="career_id">
      @foreach ($careers as $career)
        <option value='{{ $career->id }}'>{{ $career->name }}</option>
      @endforeach
    </select>
    </div>

    <div class="grid md:grid-cols-2 grid-cols-1 lg:grid-cols-3 gap-3 w-full px-2">
      @foreach ($subjects as $subject)
          <div class="flex w-full rounded shadow shadow-gray-600 bg-gray-50 overflow-hidden">
            <div @class([
                'pt-2 w-1/4',
                'bg-gray-700',
                'text-white text-center',
                'bg-lime-700' => $subject['selected'],
                'hidden'=>$subject['grade_status'],
            ])>
              {{-- button on/off --}}
              <button wire:click="toggleSubject({{ $subject['id'] }})">
                @if ($subject['selected'])
                  <x-svg.switchRight class="h-8 w-8" />
                @else
                  <x-svg.switchLeft class="h-8 w-8" />
                @endif
              </button>
            </div>
            <div @class([
              'p-2',
              'w-full',
              'bg-lime-800 text-white'=>$subject['grade_status']=='FINAL',
              'bg-blue-800 text-white'=>$subject['grade_status']=='REGULAR',
            ])>
              <small>{{ $subject['id'] }}</small>&nbsp;»&nbsp;{{ $subject['name'] }}
              @if($subject['grade_status'])
              <hr class="shadow-black" />
              <div class="w-full text-right">
              Calif.: {{$subject['grade']}} {{$subject['grade_status']}}
              </div>
              @endif
            </div>
          </div>
      @endforeach
    </div>
  </div>
    <!-- Loading indicator -->
    <div wire:loading class="spin fixed top-2 left-1/2 rounded-full bg-black bg-opacity-50">
      <x-svg.loading class="w-[3rem] h-[3rem] m-0 p-0 text-white" />
    </div>
</div>
