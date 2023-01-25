<div>
  @role('student')
  @else
    {{-- <div class="opacity-75 flex fixed top-2 right-2 text-xs shadow-md bg-gray-700 text-gray-300 rounded-full py-2 px-2"> --}}
    <div class="opacity-75 flex text-xs shadow-md bg-gray-800 text-gray-300 py-1 px-2">
        {{-- if session 'bookmarkedId' --}}
        @if (session()->has('bookmark'))
        <button wire:click="$emit('removeBookmark')" class="mr-1">        
          <x-svg.xCircle />
        </button>
        <span class="text-white mt-1">{{ $bookmarked->lastname }}, {{ $bookmarked->firstname }}</span>
  
        @else
        <x-svg.bookmarkPlus />
        @endif
      </div>
  @endrole
</div>
