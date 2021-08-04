<div wire:init="loadData">
    <div class="flex">
        @foreach ($PlansMasters as $plan)
            <!-- Plans Master -->
            <div class="mx-2">
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
    <div class="flex flex-sm-wrap">
        @foreach ($PlansDetail as $detail)
            <div class="md:w-52 sm:w-full rounded overflow-hidden shadow border-2 bg-green-100 m-1 p-2">
                <span class="font-bold text-gray-800 text-sm">{{ $detail->title }}</span>
                {{ $detail->amount }}
            </div>
        @endforeach
    </div>
</div>
