<div wire:init="loadData">
{{-- Formulario de Planes --}}
<x-jet-dialog-modal icon='edit' wire:model="updatePayPlanForm">
    <x-slot name="title">
            Title PayPlan
    </x-slot>

    <x-slot name="content">
        <p class="mb-3 text-lg">
        <strong>Some Text</strong>
        </p>
        <span class="mr-4">
        Email: <strong>some data</strong>
        </span>
        <span class="mb-3">
        Teléfono: <strong>some data</strong>
        </span>
        <p class="my-2">
        Asunto:&nbsp;
        <strong>some long text</strong><br />
        </p>

    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updatePayPlanForm')">
            Cerrar
        </x-jet-secondary-button>
        <x-jet-secondary-button wire:loading.attr="disabled">
            Guardar
        </x-jet-secondary-button>
        <x-jet-action-message class='mt-2' on="saved">
            Cambio realizado
        </x-jet-action-message>
        </div>
    </x-slot>
</x-jet-dialog-modal>

{{-- Formulario de Cuotas --}}
<x-jet-dialog-modal icon='edit' wire:model="updatePaymentForm">
    <x-slot name="title">
            Title PayPlan - Payments
    </x-slot>

    <x-slot name="content">
        <p class="mb-3 text-lg">
        <strong>Some Text</strong>
        </p>
        <span class="mr-4">
        Email: <strong>some data</strong>
        </span>
        <span class="mb-3">
        Teléfono: <strong>some data</strong>
        </span>
        <p class="my-2">
        Asunto:&nbsp;
        <strong>some long text</strong><br />
        </p>

    </x-slot>

    <x-slot name="footer">
        <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('updatePaymentForm')">
            Cerrar
        </x-jet-secondary-button>
        <x-jet-secondary-button wire:loading.attr="disabled">
            Guardar
        </x-jet-secondary-button>
        <x-jet-action-message class='mt-2' on="saved">
            Cambio realizado
        </x-jet-action-message>
        </div>
    </x-slot>
</x-jet-dialog-modal>

<x-jet-button wire:click="$toggle('updatePayPlanForm')">Open Pay Plan Modal</x-jet-button>
<x-jet-button wire:click="$toggle('updatePaymentForm')">Open Payments</x-jet-button>


    <div class="flex flex-wrap">
        @foreach ($PlansMasters as $plan)
            <!-- Plans Master -->
            <div class="mx-2 my-1">
              <?php ($payplan==$plan->id) ? $color="green" : $color="gray"; ?>
                <x-jet-button wire:click="payplanChanged('{{ $plan->id }}')" color="{{ $color }}">

                    <small>Plan {{ $plan->id }} »</small> {{ $plan->title }}</span>&nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </x-jet-button>
            </div>
        @endforeach
    </div>
  <hr class="border-2 shadow-md my-1" />
    {{-- List payments of selected plan --}}
    <div class="flex flex-wrap">
        @foreach ($PlansDetail as $detail)
            <div class="md:w-52 sm:w-full rounded overflow-hidden shadow border-2 bg-gray-50 m-1 p-2">
                <span class="font-bold text-gray-800 text-sm">{{ $detail->title }}</span><br />
                <p class="w-full text-right">$ {{ $detail->amount }}</p>
            </div>
        @endforeach
    </div>
</div>
