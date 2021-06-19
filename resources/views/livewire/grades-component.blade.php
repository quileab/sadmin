<div wire:init="loadData">

    {{-- Formulario --}}
{{-- 
    <x-jet-confirmation-modal icon='edit' wire:model="updateForm">
      <x-slot name="title">
              {{ \Carbon\Carbon::parse($datetime)->format('d-m-Y') }} » 
              {{ \Carbon\Carbon::parse($datetime)->format('H:i') }}
      </x-slot>

      <x-slot name="content">
          <p class="mb-3 text-lg">
          <strong>{{ $fullname }}</strong>
          </p>
          <span class="mr-4">
          Email: <strong>{{ $email }}</strong>
          </span>
          <span class="mb-3">
          Teléfono: <strong>{{ $phone }}</strong>
          </span>
          <p class="my-2">
          Asunto:&nbsp;
          <strong>{{ $subject }}</strong><br />
          </p>

          @if ($target_file!='')
              <p class="my-2">
                  <a href="{{ $target_file }}" target="_blank">
                  <x-jet-button>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                          <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                      </svg> Archivo adjunto
                  </x-jet-button>
                  </a>
              </p>
          @endif

          <x-jet-button color='{{ $status=== "S" ? "red" : "gray" }}' class="ml-2"
          wire:click="changeStatus('S')">Trabado
          </x-jet-button>
          <x-jet-button color='{{ $status=== "P" ? "yellow" : "gray" }}' class="ml-2"
          wire:click="changeStatus('P')">Pausar
          </x-jet-button>
          <x-jet-button color='{{ $status=== "C" ? "purple" : "gray" }}' class="ml-2"
          wire:click="changeStatus('C')">Cancelar
          </x-jet-button>
          <x-jet-button color='{{ $status=== "D" ? "green" : "gray" }}' class="ml-2"
          wire:click="changeStatus('D')">Hecho!!
          </x-jet-button>
          <x-jet-button color='{{ $status=== "O" ? "green" : "gray" }}' class="ml-2"
          wire:click="changeStatus('O')">En curso
          </x-jet-button>
      </x-slot>

      <x-slot name="footer">
          <div class="flex justify-between">
          <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
              Cerrar
          </x-jet-secondary-button>
          <x-jet-action-message class='mt-2' on="saved">
              Cambio realizado
          </x-jet-action-message>
          </div>
      </x-slot>
  </x-jet-confirmation-modal>
 --}}

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <x-table>
      <div class="px-6 py-2 flex items-center d2c">
        <div class="flex flex-1 justify-between place-items-center">
          <span class="text-2xl">
            <strong>{{ $lastname }}</strong>, {{ $firstname }} »
            <small>({{ $uid }})</small>
          </span>
          <span>Carrera&nbsp;
          <select wire:model.lazy="selectedCareer">
            {{-- opcion 0 por default --}}
            @foreach ($careers as $career)
              <option value="{{ $career->id }}">
                {{ $career->name }}
              </option>
            @endforeach
          </select>
          </span>
        </div>

        {{-- <x-jet-button wire:click="$set('openModal',true)" color="green">
          Nuevo Libro
        </x-jet-button> --}}

      </div>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="text-gray-100 bg-cool-gray-700">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Materia</th>
            <th scope="col">Calif.</th>
            <th scope="col" class="relative px-4 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($subjects as $subject)
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">
                {{ $subject->id }}
              </td>
              <td class="px-6 py-4">
                {{ $subject->name }}
              </td>
              <td class="px-6 py-4">
                Nota
              </td>
              <td class="w-28 bg-gray-100 px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                Acciones
              </td>
            </tr>
          @endforeach
          <!-- More items... -->
        </tbody>
      </table>
    </x-table>
  </div>

</div>
