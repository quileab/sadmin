<div wire:init="loadData">

  {{-- Formulario CRUD Planes --}}
  <x-jet-dialog-modal icon='edit' wire:model="openModal">
    <x-slot name="title">
      <small>ID: </small><strong>{{ $uid }}</strong> » <small>Usuario:
      </small><strong>{{ $user->lastname }}, {{ $user->firstname }}</strong>
    </x-slot>

    <x-slot name="content">
      <select wire:model="selectedPlan" class="form-control">
        @foreach ($payplans as $payplan)
          <option value="{{ $payplan->id }}">{{ $payplan->title }}</option>
        @endforeach
      </select>

      <button wire:click="assignPayPlan({{ $selectedPlan }})"
        class="px-4 py-2 m-1 text-sm text-white uppercase bg-blue-700 rounded-md">
        Asignar Plan
      </button>

    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-end">
        <x-jet-secondary-button wire:click="$toggle('openModal')" wire:loading.attr="disabled">
          Salir
        </x-jet-secondary-button>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  {{-- Formulario Ingreso de Pagos --}}
  <x-jet-dialog-modal icon='edit' wire:model="paymentModal">
    <x-slot name="title">
      <small>ID: </small><strong>{{ $uid }}</strong> » <small>Usuario:
      </small><strong>{{ $user->lastname }}, {{ $user->firstname }}</strong>
    </x-slot>

    <x-slot name="content">
      <p>Pagando: <strong>{{ $paymentDescription }}</strong> » Valor: <strong>$ {{ number_format($paymentAmount,2) }}</strong></p>
      <x-jet-input type="number" wire:model.defer="payment" placeholder="Ingrese el monto" />
      <button wire:click="registerUserPayment"
        class="px-4 py-2 m-1 text-sm text-white uppercase bg-blue-700 rounded-md">
        Ingresar Pago
      </button>

    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-end">
        <x-jet-secondary-button wire:click="$toggle('paymentModal')" wire:loading.attr="disabled">
          Salir
        </x-jet-secondary-button>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="max-w-6xl mx-auto mb-2 overflow-hidden bg-gray-200 rounded-md shadow-md">
    <div class="flex items-center justify-between w-full px-4 py-2 text-white d2c">
      <h1 class="inline-block">
        <strong>{{ $user->lastname }}</strong>, {{ $user->firstname }}
        » <small>{{ $user->id }}</small>
      </h1>
      {{-- Asignar nuevo plan de pago --}}
      @if ($hasCounter!=null)
      <div>
        @if ($totalPaid < $totalDebt)
        <x-jet-button color='green' wire:click="addPaymentToUser(true)">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>&nbsp;Ingresar Pago
        </x-jet-button>&nbsp;
        @endif
        <x-jet-button color='green' wire:click="$set('openModal',true)">
          <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" class="bi bi-plus-circle"
            viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
            <path
              d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
          </svg>&nbsp;Agregar plan
        </x-jet-button>
      </div>
      @endif
    </div>

    <div class="container px-3 mx-auto my-3 md:px-6">
      @foreach ($userPayments as $userPayment)
      @php
      $textColor = ($userPayment->paid==$userPayment->amount) ? 'text-green-200' : 'text-blue-200';          
      $textColor = ($userPayment->paid < $userPayment->amount && $userPayment->paid > 0) ? 'text-amber-200' : $textColor;
      $bgColor = ($userPayment->paid==$userPayment->amount) ? 'bg-green-700' : 'bg-blue-700';          
      $bgColor = ($userPayment->paid < $userPayment->amount && $userPayment->paid > 0) ? 'bg-amber-600' : $bgColor;
      @endphp
       
        <div class="inline-block w-32 m-1 overflow-hidden text-sm text-white uppercase bg-gray-700 rounded-md shadow-lg">
          <div class="{{$bgColor}} w-full text-center p-1">{{ $userPayment->title }}
            <p class="text-xs text-gray-200">{{ \Carbon\Carbon::parse($userPayment->date)->format('m-Y') }}</p>
          </div>
          <div class="px-2 py-1">
            <div class="text-right">
              <p class="text-base">$ {{ $userPayment->paid }}</p>
              <p class="{{$textColor}} text-xs">$ {{ $userPayment->amount }}</p>
            </div>
          </div>
        </div>
      @endforeach
    </div>
    <div class="container px-3 py-1 mx-auto my-3 text-xl text-right bg-indigo-200 md:px-6">
      <p>Deuda Total <span class="inline-block font-bold bg-gray-200 w-44">$ {{ number_format($totalDebt,2) }}</span></p>
      <p>Total de Pagos <span class="inline-block font-bold bg-gray-200 w-44">$ {{ number_format($totalPaid,2) }}</span></p>
      <p>Saldo <span class="inline-block font-bold bg-blue-300 w-44">$ {{ number_format($totalDebt - $totalPaid, 2) }}</span></p>
    </div>
    {{$paymentDescription}}
  </div>
</div>
