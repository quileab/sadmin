<div>
  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto">
    {{-- table that displays inscript lastname, firstname and career --}}
    <div class="w-full d2c px-4 py-1 flex justify-between">
      <h1 class="py-1">Inscriptos » <small>{{ count($inscripts) ?? '0' }}</small></h1>
      @if($selectedCount>0)
      <x-jet-button wire:click="deleteSelected">
        <x-svg.trash class="inline-flex text-red-400" />&nbsp;Eliminar {{ $selectedCount }}
      </x-jet-button>
      @endif
    </div>

      <table class="table-auto w-full bg-gray-200">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="px-4 py-2">PDF</th>
            <th class="px-4 py-2">Apellido y Nombre</th>
            <th class="px-4 py-2">Carrera</th>
            <th class="px-4 py-2">Inscripto a</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($inscripts as $key=>$inscript)

            <tr @class(['bg-blue-200'=>($inscript['checked'])])>
              <td class="border px-4 py-2 flex justify-between">
                @hasanyrole('admin|principal|superintendent|administrative')
                <button wire:click='fileSelect({{$key}})'>
                @if ($inscript['checked'])
                  <x-svg.checkboxChecked class="w-6 h-6 inline-flex" />
                @else
                  <x-svg.checkbox class="w-6 h-6 inline-flex" />
                @endif
                </button>
                @endhasanyrole
                &nbsp;
                <a href="{{ $inscript['pdflink'] }}" target="_blank" class="text-red-700">
                  <x-svg.pdf class="w-6 h-6 inline-flex" />
                </a>
              </td>
              <td class="border px-4 py-2">{{ $inscript['user'] ?? '' }}</td>
              <td class="border px-4 py-2">{{ $inscript['career'] ?? '' }}</td>
              <td class="border px-4 py-2">{{ $inscript['inscription'] ?? '' }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>

  </div>
</div>
