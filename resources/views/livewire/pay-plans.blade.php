<div wire:init="loadData">
  {{-- Formulario de Planes --}}
  <x-jet-dialog-modal icon='edit' wire:model="updatePayPlanForm">
    <x-slot name="title">Plan de Pago » <small>Plan {{ $master_uid }}</small></x-slot>

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
        <x-jet-button wire:click="deleteMasterData({{ $master_uid }})" color="red">
          Borrar
        </x-jet-button>
        <x-jet-button wire:click="updateMasterData({{ $master_uid }})" wire:loading.attr="disabled" color="blue">
          Guardar
        </x-jet-button>
        <x-jet-action-message class='mt-2' on="saved">
          Cambio realizado
        </x-jet-action-message>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  {{-- Formulario de Cuotas --}}
  <x-jet-dialog-modal icon='edit' wire:model="updatePaymentForm">
    <x-slot name="title">Detalle de Pagos » <small>Plan {{ $payplan }}</small></x-slot>

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
        <x-jet-button wire:click="deleteDetailData({{ $detail_uid }})" color="red">
          Borrar
        </x-jet-button>
        <x-jet-button wire:click="updateDetailData({{ $master_uid }})" wire:loading.attr="disabled" color="blue">
          Guardar
        </x-jet-button>
        <x-jet-action-message class='mt-2' on="saved">
          Cambio realizado
        </x-jet-action-message>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="flex flex-wrap">
    @foreach ($PlansMasters as $plan)
      <!-- Plans Master -->
      {{-- <div class="mx-2 my-1"> --}}
      <?php $payplan == $plan->id ? ($color = 'yellow-500') : ($color = 'gray-800'); ?>
      <div class="md:w-52 sm:w-full rounded overflow-hidden shadow bg-{{ $color }} text-white m-1">
        <div class="p-2">
          <small>Plan {{ $plan->id }} »</small> {{ $plan->title }}
        </div>
        <div class="w-52 flex">
          <button wire:click="payplanChanged('{{ $plan->id }}')" class="w-1/2 bg-green-700 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto p-1 h-7 w-7" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </button>
          <button wire:click="populateMasterData('{{ $plan->id }}')" class="w-1/2 bg-blue-700 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto p-1 h-7 w-7" viewBox="0 0 20 20" fill="currentColor">
                <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                <path fill-rule="evenodd"
                  d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                  clip-rule="evenodd" />
              </svg>
          </button>
        </div>

      </div>
    @endforeach
  </div>
  <hr class="border-2 border-black shadow my-2 w-full" />
  {{-- List payments of selected plan --}}
  <div class="flex flex-wrap">
    @foreach ($PlansDetail as $detail)
      <div class="md:w-52 sm:w-full rounded overflow-hidden shadow bg-gray-50 m-1">
        <div class="flex justify-between text-white bg-blue-800">
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
