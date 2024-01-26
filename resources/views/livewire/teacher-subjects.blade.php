<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-200 overflow-hidden rounded-lg shadow-md">
  <x-table>
    <div class="px-4 py-2 flex items-center d2c">
      <div class="flex w-full">
        <span class="mt-3">Carrera&nbsp;</span>
        <select wire:model="career"
          class="mr-3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
          @foreach ($careers as $career)
            <option value="{{ $career->id }}">{{ $career->name }}</option>
          @endforeach
        </select>
        <span class="text-gray-100 mt-3 truncate">Profesor:&nbsp;{{$user->lastname}} {{$user->firstname}}</span>
      </div>
    </div>

    @if(!$user->hasRole('teacher'))
      <h1 class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md relative center" role="alert">NO ES PROFESOR</h1>
    @else


    <div class="grid md:grid-cols-2 grid-cols-1 lg:grid-cols-3 gap-3 w-full p-2">
    @foreach ($subjects as $key => $subject)
    <div class="flex w-full rounded shadow shadow-gray-600 bg-gray-50 overflow-hidden">
        <div class="py-2 w-1/4 {{ $selected_subjects[$key] ==  true ? 'bg-green-700' : 'bg-gray-700'  }} text-white text-center">
          {{ $key }}<br />
          {{-- button on/off --}}
          <button wire:click="toggleSubject({{ $key }})">
          @if($selected_subjects[$key])
            <x-svg.switchRight class="h-7 w-7" />
          @else
            <x-svg.switchLeft class="h-7 w-7" />
          @endif
          </button>

        </div>
        <div class="p-2 w-3/4">
            {{ $subject }}
        </div>
      </div>
    @endforeach
    </div>

    @endif

  </x-table>
  <!-- Loading indicator -->
  <div wire:loading class="spin fixed top-2 left-1/2 rounded-full bg-black bg-opacity-50">
    <x-svg.loading class="w-[3rem] h-[3rem] m-0 p-0 text-white" />
  </div>
  
</div>
