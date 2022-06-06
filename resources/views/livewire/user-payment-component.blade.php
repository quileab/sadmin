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
        class="px-4 py-2 m-1 text-sm text-white uppercase bg-green-800 rounded-md ">
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
        <x-jet-button wire:click="addPaymentToUser(true)">
          <x-svg.dolarRound />&nbsp;Ingresar Pago
        </x-jet-button>&nbsp;
        @endif
        <x-jet-button wire:click="$set('openModal',true)">
          <x-svg.plusCircle />&nbsp;Agregar plan
        </x-jet-button>
        <a href="{{ route('paymentsDetails',$user->id) }}" class="ml-2">
          <x-jet-button>
            <x-svg.list />&nbsp;Ver Pagos
          </x-jet-button>
        </a>
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
    <div class="container px-3 py-1 mx-auto my-3 text-lg text-right bg-gray-300 md:px-6">
      <p>Deuda Total <span class="inline-block font-bold bg-gray-200 w-44">$ {{ number_format($totalDebt,2) }}</span></p>
      <p>Total de Pagos <span class="inline-block font-bold bg-gray-200 w-44">$ {{ number_format($totalPaid,2) }}</span></p>
      <p>Saldo <span class="inline-block font-bold bg-gray-100 w-44">$ {{ number_format($totalDebt - $totalPaid, 2) }}</span></p>
    </div>
  </div>
</div>
