<div>
  {{-- Formulario de Carreras --}}
  <x-jet-dialog-modal icon='edit' wire:model="updateSubjectForm">
    <x-slot name="title">
      Materia
    </x-slot>

    <x-slot name="content">
      <div class="flex items-stretch flex-1 justify-between">
        <div class="w-full px-1">
          ID<br />
          <x-jet-input type='number' wire:model.lazy='uid' value='{{ $uid }}' /><br />
        </div>
        <div class="w-full px-1">
          IDs Correlatividades<br />
          <x-jet-input wire:model.lazy='correl' value={{ $correl }} /><br />
        </div>
      </div>
      Nombre
      <x-jet-input wire:model.lazy='name' value='{{ $name }}' class="w-full" /><br />
    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updateSubjectForm')" wire:loading.attr="disabled">
          Cancelar
        </x-jet-secondary-button>

        @if ($formAction == 'store')
          <x-jet-button wire:click="store" color="green" class="text-white font-bold px-3 py-1 rounded text-xs">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>&nbsp;Crear
          </x-jet-button>
        @else
          <x-jet-button class="ml-2" wire:click="saveSubjectChange" wire:loading.attr="disabled">
            Modificar
            </x-jet-danger-button>
        @endif
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="bg-white rounded-md shadow-md overflow-hidden max-w-6xl mx-auto my-4">
    <div class="w-full d2c px-4 py-3 text-white">
      <h1 class="inline-block">Materias</h1><small> » {{ $career_id }} » </small>
      <strong>{{ $career_name }}</strong>
    </div>
    <div class="px-4 py-2">
      {{-- NEW Career --}}
      <x-jet-button color='green' wire:click="create" class="mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg> Nueva
      </x-jet-button>


      <table class="w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-700 text-white">
          <tr>
            <th class="w-auto text-left py-2 px-3 uppercase font-semibold text-sm">id</th>
            <th class="w-3/5 text-left py-2 px-3 uppercase font-semibold text-sm">Nombre</th>
            <th class="w-auto text-left py-2 px-3 uppercase font-semibold text-sm">Acciones</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          @foreach ($subjects as $subject)
            <tr>
              <td class="w-1/6 text-left py-2 px-3 border-b">{{ $subject->id }}</td>
              <td class="w-2/6 text-left py-2 px-3 border-b">
                <div class="text-lg font-bold">{{ $subject->name }}</div>
              </td>
              <td class="w-1/6 py-2 px-3 border-b">
                <div class="flex items-center justify-evenly">
                  {{-- Edit Subject --}}
                  <x-jet-button wire:click="edit({{ $subject }})">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                      width="1rem" height="1rem">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                  </x-jet-button>
                  {{-- Delete Subject --}}
                  <x-jet-danger-button wire:click="$emit('triggerDelete',{{ $subject }})">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                      width="1rem" height="1rem">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                  </x-jet-danger-button>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>


  {{-- //scripts stack --}}
  @push('scripts')
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        @this.on('triggerDelete', subject => {
          Swal.fire({
            title: 'Eliminar?',
            text: subject.name,
            icon: "warning",
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#1c64f2',
            confirmButtonText: 'Eliminar',
            confirmButtonColor: '#e02424',

          }).then((result) => {
            //if user clicks on delete
            if (result.value) {
              // calling destroy method to delete
              @this.call('destroy', subject)
              // success response
              Toast.fire('Eliminado', '', 'success');

            } else {
              Toast.fire('Cancelado', '', 'error');
            }
          });
        });
      })
    </script>
  @endpush

</div>
