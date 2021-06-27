<div wire:init="loadData">
  {{-- Formulario CRUD Libros --}}
  <x-jet-dialog-modal wire:model="openModal">
    <x-slot name="title">
      @if ($updating)
        Actualizando Libro
      @else
        Nuevo libro
      @endif
    </x-slot>
    <x-slot name="content">
      <div class="mb-4">
        <x-jet-label value="ID" />
        <x-jet-input type="text" class="w-full" wire:model.defer='uid' />
        <x-jet-input-error for="uid" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Título" />
        <x-jet-input type="text" class="w-full" wire:model.defer='title' />
        <x-jet-input-error for="title" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Editor" />
        <x-jet-input type="text" class="w-full" wire:model.defer='publisher' />
        <x-jet-input-error for="publisher" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Autor" />
        <x-jet-input type="text" class="w-full" wire:model.defer='author' />
        <x-jet-input-error for="author" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Tema/Género/Materia" />
        <x-jet-input type="text" class="w-full" wire:model.defer='gender' />
        <x-jet-input-error for="gender" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Páginas" />
        <x-jet-input type="number" class="w-full" wire:model.defer='extent' />
        <x-jet-input-error for="extent" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Edición" />
        <x-jet-input type="date" class="w-full" wire:model.defer='edition' />
        <x-jet-input-error for="edition" />
      </div>
      <div class="mb-4">
        <x-jet-label value="ISBN" />
        <x-jet-input type="text" class="w-full" wire:model.defer='isbn' />
        <x-jet-input-error for="isbn" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Encuadernación / Contenedor" />
        <x-jet-input type="text" class="w-full" wire:model.defer='container' />
        <x-jet-input-error for="container" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Signatura Topográfica" />
        <x-jet-input type="text" class="w-full" wire:model.defer='signature' />
        <x-jet-input-error for="signature" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Digital (URL)" />
        <x-jet-input type="text" class="w-full" wire:model.defer='digital' />
        <x-jet-input-error for="digital" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Origen" />
        <x-jet-input type="text" class="w-full" wire:model.defer='origin' />
        <x-jet-input-error for="origin" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Fecha Ingreso" />
        <x-jet-input type="date" class="w-full" wire:model.defer='date_added' />
        <x-jet-input-error for="date_added" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Precio de compra" />
        <x-jet-input type="number" step=".01" class="w-full" wire:model.defer='price' />
        <x-jet-input-error for="price" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Fecha de Baja" />
        <x-jet-input type="date" class="w-full" wire:model.defer='discharge_date' />
        <x-jet-input-error for="discharge_date" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Razón de la Baja" />
        <x-jet-input type="text" class="w-full" wire:model.defer='discharge_reason' />
        <x-jet-input-error for="discharge_reason" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Sinopsis" />
        <textarea wire:model.defer="synopsis"
          class="w-full p-3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          rows="6"></textarea>
        <x-jet-input-error for="synopsis" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Nota" />
        <textarea wire:model.defer="Note"
          class="w-full p-3 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          rows="6"></textarea>
        <x-jet-input-error for="Note" />
      </div>
      <div class="mb-4">
        <x-jet-label value="Prestado a" />
        <x-jet-input type="number" wire:model.defer='user_id' />
        <x-jet-input-error for="user_id" />
      </div>

    </x-slot>
    <x-slot name="footer">
        <div class="flex justify-between">
            @if($errors->any())
                <div class="text-yellow-300">Verifique la información ingresada</div>
            @endif
            <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="save">
                @if($updating)
                    Actualizar
                @else
                    Guardar
                @endif
            </x-jet-button>
            <x-jet-danger-button wire:click="$set('openModal',false)">Cancelar</x-jet-danger-button>
        </div>
    </x-slot>
  </x-jet-dialog-modal>


  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <x-table>
      <div class="px-6 py-2 flex items-center d2c">
        <div class="flex item center">
          <span class="mt-3">Mostrar&nbsp;</span>
          <select wire:model="cant"
            class="mr-4 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>

        <x-jet-input class="flex-1 mr-4" type="search" placeholder="Ingrese su búsqueda aquí" wire:model="search" />
        <x-jet-button wire:click="newBook" color="green">Nuevo Libro</x-jet-danger-button>
      </div>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="text-gray-100 bg-cool-gray-700">
          <tr>
            <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
              wire:click="order('id')">
              ID
              @if ($sort != 'id')
                <x-sortNone />
              @else
                @if ($direction == 'asc')
                  <x-sortUp />
                @else
                  <x-sortDown />
                @endif
              @endif
            </th>
            <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
              wire:click="order('title')">
              Title
              @if ($sort != 'title')
                <x-sortNone />
              @else
                @if ($direction == 'asc')
                  <x-sortUp />
                @else
                  <x-sortDown />
                @endif
              @endif
            </th>
            <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
              wire:click="order('author')">
              Author
              @if ($sort != 'author')
                <x-sortNone />
              @else
                @if ($direction == 'asc')
                  <x-sortUp />
                @else
                  <x-sortDown />
                @endif
              @endif

            </th>
            <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
              wire:click="order('user_id')">
              Stat
              @if ($sort != 'user_id')
                <x-sortNone />
              @else
                @if ($direction == 'asc')
                  <x-sortUp />
                @else
                  <x-sortDown />
                @endif
              @endif

            </th>
            <th scope="col" class="relative px-4 py-3">
              <span class="sr-only">Edit</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($books as $book)
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $book->id }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $book->title }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $book->author }}</div>
              </td>
              <td class="px-6 py-4">
                @if ($book->user)
                  <span
                    class="px-2 text-center block text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                    <a href="{{ route('students', ['search' => $book->user->pid]) }}">
                      {{ $book->user->pid }}
                    </a>
                  </span>
                @else
                  <span
                    class="text-center block text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                    Libre
                  </span>
                @endif

              </td>
              <td class="w-28 bg-gray-100 px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                {{-- <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a> --}}
                <button wire:click="edit('{{ $book->id }}')" class="mr-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </button>
                <button wire:click="$emit('confirmDelete','{{ $book->title }}','{{ $book->id }}','delete')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="red">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
              </td>
            </tr>
          @endforeach
          <!-- More items... -->
        </tbody>
      </table>
      @if (count($books))
        <div class="px-5 py-2 bg-gray-300">
          {{ $books->links() }}
        </div>
      @endif
    </x-table>
  </div>

</div>
