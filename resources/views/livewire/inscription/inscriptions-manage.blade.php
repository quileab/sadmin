<div>
  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto">
    {{-- table that displays inscript lastname, firstname and career --}}
    <div class="w-full d2c px-4 py-3 text-white flex justify-between">
      <h1 class="py-1">Inscriptos</h1>
      @if($selectedCount>0)
      <button class="flex rounded-md bg-gray-800 text-gray-200 hover:bg-cool-gray-700 px-3 py-1 shadow-md"
        wire:click="deleteSelected"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
      </svg>&nbsp;<small>Eliminar {{ $selectedCount }}</small></button>
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
                <button wire:click='fileSelect({{$key}})'>
                @if ($inscript['checked'])
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-flex" fill="currentColor" class="bi bi-check2-square" viewBox="0 0 16 16">
                    <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z"/>
                    <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z"/>
                  </svg>
                @else
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 inline-flex" fill="currentColor" class="bi bi-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                  </svg>
                @endif
                </button>
                &nbsp;
                <a href="{{ $inscript['pdflink'] }}" target="_blank" class="text-red-700">
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" height="16" fill="currentColor"
                    class="bi bi-file-earmark-pdf inline-flex" viewBox="0 0 16 16">
                    <path
                      d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                    <path
                      d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                  </svg>
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
