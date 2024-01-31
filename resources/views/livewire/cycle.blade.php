<div class="flex">
    <x-jet-input type="number" wire:model='cycle' min="2020" max="2050" />
    <button wire:click='setCycle' class="rounded-md bg-blue-700 hover:bg-blue-600 px-2">
        <x-svg.check class="w-3 h-3 m-0 p-0 text-white" />
    </button>   
</div>
