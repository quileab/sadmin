<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Formulario Archivo Importación de Alumnos
      </h2>
  </x-slot>

  <div class="bg-gray-100 rounded-md shadow-md overflow-hidden max-w-4xl mx-auto mb-2 mt-4">
    <div class="w-full d2c px-4 py-3 text-white">
        <h1 class="inline-block">Importar Alumnos</h1>
    </div>
    
    <div class="container my-3 mx-auto px-4 md:px-12">
      <form action="{{route('students-import-bulk')}}" method="post" enctype="multipart/form-data">
      {{ csrf_field() }}
      <label for="file">Seleccione el archivo a importar</label>
      <input type="file" name="file" id="file" class="form-input"><br>


      <x-jet-button class="text-white font-bold px-3 py-1 rounded text-xs">
        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
        </svg>&nbsp;Importar
      </x-jet-button>

      </form>


    </div>


</x-app-layout>
