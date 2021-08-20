<div wire:init="loadData">
  {{-- Formulario de Planes --}}
  <x-jet-dialog-modal icon='edit' wire:model="updatePayPlanForm">
    <x-slot name="title">Plan de Pago » <strong>{{ $master_uid }}</strong></x-slot>

    <x-slot name="content">
      <p class="mb-3">
        Descripción
        <x-jet-input type="text" wire:model="master_title" class="w-full" />
      </p>
    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updatePayPlanForm')">
          Cerrar
        </x-jet-secondary-button>
        @if ($master_uid == '0')
        <x-jet-button wire:click="createMasterData" wire:loading.attr="disabled" color="green">
          Guardar
        </x-jet-button>
        @else
          <x-jet-button color="red" wire:click="$emit('confirmDelete','{{$master_title}}','{{ $master_uid }}','deleteMasterData')">
            Eliminar
          </x-jet-button>
          <x-jet-button wire:click="updateMasterData({{ $master_uid }})" wire:loading.attr="disabled" color="blue">
            Actualizar
          </x-jet-button>
        @endif
        <x-jet-action-message class='mt-2' on="saved">
          Cambio realizado
        </x-jet-action-message>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  {{-- Formulario de Cuotas --}}
  <x-jet-dialog-modal icon='edit' wire:model="updatePaymentForm">
    <x-slot name="title"><small>Plan {{ $payplan }} » </small>Detalle de Pagos</x-slot>

    <x-slot name="content">
      <div class="flex justify-between">
        <span class="mb-3 text-lg">
          Cuota ID: <strong>{{ $detail_uid }}</strong>
        </span>
        <span class="mb-3">
          Fecha
          <x-jet-input type="date" wire:model="detail_date" />
        </span>
      </div>
      <p class="mb-3">
        Descripción
        <x-jet-input type="text" wire:model="detail_title" class="w-2/3" />
      </p>
      <p class="mb-3">
        Importe
        <x-jet-input type="number" wire:model="detail_amount" />
      </p>

    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updatePaymentForm')">
          Cerrar
        </x-jet-secondary-button>
        @if ($detail_uid == '0')
        <x-jet-button wire:click="createDetailData" wire:loading.attr="disabled" color="green">
          Guardar
        </x-jet-button>
        @else
          <x-jet-button wire:click="$emit('confirmDelete','{{$detail_title}}','{{ $detail_uid }}','deleteDetailData')" color="red">
            Eliminar
          </x-jet-button>
          <x-jet-button wire:click="updateDetailData({{ $detail_uid }})" wire:loading.attr="disabled" color="blue">
            Actualizar
          </x-jet-button>
        @endif
        <x-jet-action-message class='mt-2' on="saved">
          Cambio realizado
        </x-jet-action-message>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="flex flex-wrap">
    <button wire:click="openCreateMasterForm"
      class="flex items-center p-2 mx-1 my-1 content-center rounded shadow-lg bg-blue-700 text-gray-50">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>&nbsp;Nuevo Plan&nbsp;
    </button>
    @foreach ($PlansMasters as $plan)
      <!-- Plans Master -->
      {{-- <div class="mx-2 my-1"> --}}
      <?php $payplan == $plan->id ? ($color = 'blue') : ($color = 'gray'); ?>

      <div class="inline-flex shadow-md mx-1">
        <button wire:click="payplanChanged('{{ $plan->id }}')" 
          class="text-left bg-{{ $color }}-700 hover:bg-{{ $color }}-600 text-gray-50 py-0 px-2 rounded-l">
          {{ $plan->title }}
        </button>
        {{-- **EDIT ICON** --}}
        <button wire:click="populateMasterData('{{ $plan->id }}')" 
        class="bg-{{ $color }}-600 hover:bg-{{ $color }}-500 text-{{ $color }}-300 font-bold py-0 px-1 rounded-r">
        <small>#{{ $plan->id }}</small>
        <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto p-1 w-7" viewBox="0 0 20 20" fill="currentColor">
          <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
          <path fill-rule="evenodd"
            d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
            clip-rule="evenodd" />
        </svg> 
        </button>
      </div>


    @endforeach
  </div>
  <hr class="border-2 border-black my-2 w-full" />
  {{-- List payments of selected plan --}}
  <div class="flex flex-wrap">
    <button wire:click="openCreateDetailForm"
      class="flex items-center p-2 mx-1 my-1 content-center rounded shadow bg-blue-700 text-gray-50">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
      </svg>&nbsp;Nueva Cuota&nbsp;
    </button>

    @foreach ($PlansDetail as $detail)
      <div class="md:w-36 sm:w-full rounded overflow-hidden shadow-lg bg-gray-50 m-1">
        <div class="flex justify-between text-white bg-blue-700">
          <div class="mx-2 my-1">
            <span class="font-bold text-sm">{{ $detail->title }}</span>
          </div>
          <div class="mx-2 my-1">
            <button wire:click="populateDetailData({{ $detail->id }})">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                <path fill-rule="evenodd"
                  d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                  clip-rule="evenodd" />
              </svg>
            </button>
          </div>
        </div>
        <p class="w-full text-right p-2">$ {{ $detail->amount }}</p>
      </div>
    @endforeach
  </div>
</div>
