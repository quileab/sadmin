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
          <textarea wire:model.lazy="text" name="text" id="text" cols="30" rows="5" class="form-textarea"></textarea>
        </div>
      </div>
    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
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
          <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
            Modificar
          </x-jet-button>
        @endif
      </div>
    </x-slot>
  </x-jet-confirmation-modal>


  <div class="bg-gray-200 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-4">
    <div class="w-full d2c px-4 py-3 text-white">
      <h1 class="inline-block">Tarjetas de Información</h1>
    </div>

    <div class="container my-3 mx-auto px-4 md:px-12">
      @hasanyrole('secretary|admin')
      {{-- NEW Infocard --}}
      <x-jet-button color='green' wire:click="create">
        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg> Nueva
      </x-jet-button>
      @endhasanyrole

      <div class="flex flex-wrap -mx-1 lg:-mx-4">
        @foreach ($infocards as $infocard)

          <!-- Column -->
          <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">

            <!-- Article -->
            <article class="overflow-hidden rounded-lg shadow-lg">

              <div style="background-color:{{ $infocard->type }}; text-shadow: 1px 1px 4px black;"
                class="block h-12 w-full overflow-hidden text-white font-bold">
                <p class="block p-2 mx-2 mt-2">
                  {{ $infocard->title }}
                </p>
              </div>

              <header class="items-center text-right py-2 px-2 border-b md:px-4 bg-gray-100">
                <p class="text-xs"><small>{{ $infocard->updated_at->format('d-m-Y') }}</small></p>
                <p class="text-left">
                  @php
                    echo nl2br($infocard->text);
                  @endphp
                </p>
              </header>

              <footer class="bg-gray-300 border-t flex items-center justify-between leading-none p-1 md:p-2">
                <a class="flex items-center no-underline hover:underline text-black" href="#">
                  <img class="h-8 w-8 rounded-full object-cover" src="{{ $infocard->user->profile_photo_url }}"
                    alt="{{ $infocard->user->name }}" />
                  <p class="ml-2 text-sm">
                    {{ $infocard->user->name }}
                  </p>
                </a>
                @hasanyrole('secretary|admin')
                <a class="no-underline text-grey-darker hover:text-red-dark" href="#">
                  <button wire:click="edit({{ $infocard }})"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded text-xs">Editar</button>


                  <button wire:click="$emit('triggerDelete',{{ $infocard }})"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 py-2 rounded text-xs">Borrar</button>
                </a>
                @endhasanyrole
              </footer>

            </article>
            <!-- END Article -->

          </div>
          <!-- END Column -->

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
