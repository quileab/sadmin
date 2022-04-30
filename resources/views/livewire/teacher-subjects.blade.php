<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 bg-gray-200 overflow-hidden rounded-lg shadow-md">
  <x-table>
    <div class="px-4 py-2 flex items-center d2c">
      <div class="flex item center">
        <span class="mt-3">Carrera&nbsp;</span>
        <select wire:model="career"
          class="mr-3 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
          @foreach ($careers as $career)
            <option value="{{ $career->id }}">{{ $career->name }}</option>
          @endforeach
        </select>
        <span class="text-gray-900 mt-3 truncate">&nbsp;{{$user->lastname}} {{$user->firstname}}</span>
      </div>
    </div>

    <div class="p-2 flex flex-wrap">
    @foreach ($subjects as $key => $subject)
      <div class="flex w-80 rounded shadow-md shadow-gray-600 bg-gray-50 m-2 overflow-hidden">
        <div class="p-2 w-1/4 {{ $selected_subjects[$key] ==  true ? 'bg-green-700' : 'bg-gray-700'  }} text-white">
          {{ $key }}
        </div>
        <div class="p-2 w-3/4">
            {{ $subject }}{{ $selected_subjects[$key] }}
        </div>
      </div>
    @endforeach
    </div>
  </x-table>
</div>
