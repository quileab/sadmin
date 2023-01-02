<div>
  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto">
    <div class="w-full d2c px-4 py-1 flex justify-between">
      <h1 class="py-1 mr-3">Mis Estudiantes</h1>
    </div>

    <div class="p-3">
      Carrera <select wire:model="subjectId">
        @foreach ($mySubjects as $mySubject)
          <option value="{{ $mySubject->id }}">
            {{ $mySubject->id }} : {{ $mySubject->name }}
          </option>
        @endforeach
      </select>

        <div wire:loading wire:target="subjectId" class="spin">
            <x-svg.redo class="w-7 h-7" />
        </div>


      <table class="table-auto w-full bg-gray-200 rounded-md overflow-hidden">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="px-4 py-2">Apellido y Nombre</th>
            <th class="px-4 py-2">Fecha</th>
            <th class="px-4 py-2">Nota</th>
            <th class="px-4 py-2">Descripción</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($myStudents as $myStudent)
            <tr>
              <td class="border px-4 py-2">{{ $myStudent->lastname }}, {{ $myStudent->firstname }}</td>
              <td class="border px-4 py-2"></td>
              <td class="border px-4 py-2"></td>
              <td class="border px-4 py-2"></td>
            </tr>
          @endforeach
        </tbody>
      </table>

    </div>
  </div>
</div>
