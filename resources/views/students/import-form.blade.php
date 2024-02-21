<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      Formulario Archivo Importación de Alumnos
    </h2>
  </x-slot>

  <div class="bg-gray-100 rounded-md shadow-md overflow-hidden w-full">
    <div class="w-full d2c px-4 py-3 text-white">
      <h1 class="inline-block">Importar Usuarios</h1>
    </div>

    <div class="container mt-3 mx-auto mx-4">
      <form action="{{ route('students-import-bulk') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="mx-4 my-1">
        <label for="file">Seleccione el archivo a importar</label>
        <input type="file" name="file" id="file" accept=".csv" class="form-input">
        </div>
        <div class="flex mt-2 p-1 bg-gray-300 rounded-md justify-between">
          <select name="role" class="border border-gray-400 mx-1">
            <option value="">Seleccione un Rol</option>
            @foreach ($roles as $role)
              <option value="{{ $role->id }}">{{ $role->name }}</option>
            @endforeach
          </select>
          <x-jet-button class="text-white font-bold px-3 py-1 my-1 rounded text-xs">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>&nbsp;Importar
          </x-jet-button>
        </div>
      </form>

      @isset($message)
        {{ $message }}
      @endisset
    </div>


</x-app-layout>
