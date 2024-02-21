<div class="p-2">
  <div class="flex flex-wrap rounded bg-stone-300 shadow-md p-2 m-3">
    <p class="pt-3 pr-1">{{ __('Fecha Desde') }}</p>
    <x-jet-input type='date' wire:model.debounce='dateFrom' />
    &nbsp;&nbsp;
    <p class="pt-3 pr-1">{{ __('Fecha Hasta') }}</p>
    <x-jet-input type='date' wire:model.debounce='dateTo' />
  </div>
  <div class="flex flex-wrap rounded bg-stone-300 shadow-md p-2 m-3">
    <p class="pt-3 pr-1">{{ __('Buscar') }}</p>
    <x-jet-input type="text" wire:model.debounce='search' />
    <div wire:loading.remove class="flex flex-wrap mx-3 justify-between">
      <a href="{{ route('printStudentsPayments', ['dateFrom' => $dateFrom,'dateTo'=>$dateTo, 'search'=>$search]) }}" target='_blank'>
      <x-jet-button><x-svg.list />&nbsp;Caja
      </x-jet-button>
      </a>
    </div>
  </div>
  <!-- Loading indicator -->
  <div wire:loading class="spin fixed top-2 left-1/2 rounded-full bg-black bg-opacity-50">
    <x-svg.loading class="w-[3rem] h-[3rem] m-0 p-0 text-white" />
  </div>
</div>
