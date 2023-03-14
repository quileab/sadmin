<div>
  {{-- Formulario de Infocards --}}
  <x-jet-confirmation-modal icon='edit' wire:model="updateForm">
    <x-slot name="title">
      Informaciones
    </x-slot>

    <x-slot name="content">
      <!-- Formulario sin FORM utilizando livewire -->
      <div class="flex flex-row flex-wrap">
        <div class="mx-2">
          <label for="title" class="block form-label">Título</label>
          <x-jet-input wire:model.defer="title" id="title" type="text" class="form-input" />

          <label for="type" class="block form-label mt-4">Color de Énfasis</label>
          <input type="color" wire:model="type" class="w-full" />
        </div>
        <div class="mx-2">
          <label for="text" class="block form-label">Información</label>
          <textarea wire:model.lazy="text" name="text" id="text" cols="40" rows="5" class="form-textarea w-full"></textarea>
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
          Cancelar
        </x-jet-secondary-button>

        @if ($formAction == 'store')
          <x-jet-button wire:click="store">
            <x-svg.plusCircle class="w-5 h-5" />&nbsp;Crear
          </x-jet-button>
        @else
          <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
            Modificar
          </x-jet-button>
        @endif
      </div>
    </x-slot>
  </x-jet-confirmation-modal>

  <div class="bg-gray-200 rounded-md shadow-md overflow-hidden mb-2">
    <div class="flex justify-between w-full d2c px-4 py-2">
      <h1 class="text-xl">Información</h1>
      @hasanyrole('secretary|admin')
      {{-- NEW Infocard --}}
      <x-jet-button wire:click="create">
        <x-svg.edit />&nbsp;Nueva
      </x-jet-button>
      @endhasanyrole
    </div>

    <div class="flex flex-wrap w-full">

      <div class="flex flex-wrap p-3">
        @foreach ($infocards as $infocard)

          <!-- Card -->
          <div class="flex w-full md:w-full lg:w-1/2 xl:w-1/3">

            <!-- Article -->
            <article class="overflow-hidden rounded-lg shadow-lg w-full m-2" style="text-shadow: 0px 0px 1px;">

              <div style="background-color:{{ $infocard->type }}; text-shadow: 1px 1px 4px black;"
                class="block w-full overflow-hidden text-white">
                <p class="block mx-3 my-2">
                  {{ $infocard->title }}
                </p>
              </div>

              <header class="items-center text-right pb-2 px-2 border-b md:px-4 bg-gray-100 text-gray-900">
                <p class="text-xs"><small>{{ $infocard->updated_at->format('d-m-Y') }}</small></p>
                <p class="text-left">
                  {!! nl2br($infocard->text) !!}
                </p>
              </header>

              <footer class="bg-gray-300 flex justify-between">
                <span class="flex items-center text-black">
                  <img class="h-8 w-8 rounded-full object-cover" src="{{ $infocard->user->profile_photo_url }}"
                    alt="{{ $infocard->user->name }}" />
                  <p class="ml-2 text-sm">
                    {{ $infocard->user->name }}
                  </p>
                </span>
                @hasanyrole('secretary|admin')
                <span>
                  <button wire:click="edit({{ $infocard }})"
                    class="bg-blue-600 hover:bg-blue-800 text-white font-bold px-3 py-2 rounded text-xs">
                    <x-svg.edit class="w-5 h-5" />
                  </button>
                  <button wire:click="$emit('triggerDelete',{{ $infocard }})"
                    class="bg-red-600 hover:bg-red-800 text-white font-bold px-3 py-2 rounded text-xs">
                    <x-svg.trash class="w-5 h-5" />  
                  </button>
                </span>

                @endhasanyrole
              </footer>

            </article>
            <!-- END Article -->

          </div>
          <!-- END Card -->

        @endforeach
      </div>
    </div>

    {{ $infocards->links() }}

    {{-- //scripts stack --}}
    @push('scripts')
      <script type="text/javascript">
        document.addEventListener('DOMContentLoaded', function() {
          @this.on('triggerDelete', infocard => {
            Swal.fire({
              title: 'Eliminar?',
              text: infocard.title,
              icon: "warning",
              showCancelButton: true,
              cancelButtonText: 'Cancelar',
              cancelButtonColor: '#aa3333',
              confirmButtonText: 'Eliminar',
              confirmButtonColor: '#33aa33',

            }).then((result) => {
              //if user clicks on delete
              if (result.value) {
                // calling destroy method to delete
                @this.call('destroy', infocard)
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
</div>
