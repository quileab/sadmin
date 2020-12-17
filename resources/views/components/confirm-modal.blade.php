@props(['id' => null, 'maxWidth' => null,'color'=>null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-{{$color}}-100 text-{{$color}}-800 shadow-md">
        <div class="text-lg bg-{{$color}}-700 text-white px-4 py-2">
            {{ $title }}
        </div>

        <div class="mt-4 pb-2 px-4 shadow-md mb-2">
            {{ $content }}
        </div>

        <div class="px-2 pb-2 bg-{{$color}}-50 text-right">
            {{ $footer }}
        </div>
    </div>

</x-jet-modal>