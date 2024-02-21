<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-lime-900 to-blue-800">
    <div>
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md mt-6 px-4 py-4 border-gray-100 border border-opacity-60 bg-gray-200 bg-opacity-60 shadow-md overflow-hidden rounded">
        {{ $slot }}
    </div>
</div>
