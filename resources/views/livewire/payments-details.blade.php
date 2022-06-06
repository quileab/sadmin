<div wire:init="loadData">
    {{-- Formulario CRUD Libros --}}
    <x-jet-dialog-modal wire:model="openModal">
      <x-slot name="title">
        @if ($updating)
          Actualizando
        @else
          Nuevo
        @endif
      </x-slot>
      <x-slot name="content">

        {{-- <div class="mb-4">
          <x-jet-label value="Prestado a" />
          <x-jet-input type="number" wire:model.defer='user_id' />
          <x-jet-input-error for="user_id" />
        </div> --}}
  
      </x-slot>
      <x-slot name="footer">
        <div class="flex justify-between">
          @if ($errors->any())
            <div class="text-yellow-300">Verifique la información ingresada</div>
          @endif
          <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="save">
            @if ($updating)
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
      <x-table>
        <div class="px-6 py-2 flex items-center d2c justify-between">
            <h1 class="flex item">
                <strong>{{ $user->lastname }}</strong>, {{ $user->firstname }}
                » {{ $user->id }}
            </h1>
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
        </div>
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="text-gray-100 bg-gray-700">
            <tr>
              <th class="text-center px-4 py-3 text-xs font-medium uppercase tracking-wider">
                Fecha
              </th>
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
                Descripción
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
                Importe
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
              <th scope="col" class="relative px-4 py-3">
                <span class="sr-only">Acciones</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($payments as $payment)
              <tr class="hover:bg-gray-100">
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">{{ $payment->created_at }}</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">{{ $payment->id }}</div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">{{ $payment->description }}</div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="text-sm text-gray-900">{{ $payment->paymentAmount }}</div>
                </td>
                <td class="bg-gray-100 px-2 py-1 whitespace-nowrap text-right text-sm font-medium">
                  @if(auth()->user()->can('payment.cancel') && $payment->paymentAmount > 0)
                  <x-jet-danger-button wire:click="cancelPayment('{{ $payment->id }}')" class="mx-1">
                    <x-svg.x class="h-4 w-4" />Anular
                  </x-jet-danger-button>
                  @endif
                </td>
              </tr>
            @endforeach
            <!-- More items... -->
          </tbody>
        </table>
        @if (count($payments))
          <div class="px-5 py-2 bg-gray-300">
            {{ $payments->links() }}
          </div>
        @endif
      </x-table>
    </div>
  
  </div>
  