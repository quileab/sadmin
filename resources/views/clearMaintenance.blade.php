<x-guest-layout>
  <div class="flex flex-col gap-1 sm:px-6 lg:px-8">

      @foreach ($logs as $key => $value)
        <div class="flex border-b-2 px-2">
          <div class="w-52">{{ $key }}</div>
          <div class="w-5">{{ $value }}</div>
        </div>
      @endforeach

  </div>
</x-guest-layout>
