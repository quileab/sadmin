<div>
    @php
    $colors = [
    "#ffebee","#ffcdd2","#ef9a9a","#e57373","#ef5350","#f44336","#e53935",
    "#d32f2f","#c62828","#b71c1c","#ff8a80","#ff5252","#ff1744","#d50000",
    "#fce4ec","#f8bbd0","#f48fb1","#f06292","#ec407a","#e91e63","#d81b60",
    "#c2185b","#ad1457","#880e4f","#ff80ab","#ff4081","#f50057","#c51162",
    "#f3e5f5","#e1bee7","#ce93d8","#ba68c8","#ab47bc","#9c27b0","#8e24aa",
    "#7b1fa2","#6a1b9a","#4a148c","#ea80fc","#e040fb","#d500f9","#aa00ff",
    "#ede7f6","#d1c4e9","#b39ddb","#9575cd","#7e57c2","#673ab7","#5e35b1",
    "#512da8","#4527a0","#311b92","#b388ff","#7c4dff","#651fff","#6200ea",
    "#e8eaf6","#c5cae9","#9fa8da","#7986cb","#5c6bc0","#3f51b5","#3949ab",
    "#303f9f","#283593","#1a237e","#8c9eff","#536dfe","#3d5afe","#304ffe",
    "#e3f2fd","#bbdefb","#90caf9","#64b5f6","#42a5f5","#2196f3","#1e88e5",
    "#1976d2","#1565c0","#0d47a1","#82b1ff","#448aff","#2979ff","#2962ff",
    "#e1f5fe","#b3e5fc","#81d4fa","#4fc3f7","#29b6f6","#03a9f4","#039be5",
    "#0288d1","#0277bd","#01579b","#80d8ff","#40c4ff","#00b0ff","#0091ea",
    "#e0f7fa","#b2ebf2","#80deea","#4dd0e1","#26c6da","#00bcd4","#00acc1",
    "#0097a7","#00838f","#006064","#84ffff","#18ffff","#00e5ff","#00b8d4",
    "#e0f2f1","#b2dfdb","#80cbc4","#4db6ac","#26a69a","#009688","#00897b",
    "#00796b","#00695c","#004d40","#a7ffeb","#64ffda","#1de9b6","#00bfa5",
    "#e8f5e9","#c8e6c9","#a5d6a7","#81c784","#66bb6a","#4caf50","#43a047",
    "#388e3c","#2e7d32","#1b5e20","#b9f6ca","#69f0ae","#00e676","#00c853",
    "#f1f8e9","#dcedc8","#c5e1a5","#aed581","#9ccc65","#8bc34a","#7cb342",
    "#689f38","#558b2f","#33691e","#ccff90","#b2ff59","#76ff03","#64dd17",
    "#f9fbe7","#f0f4c3","#e6ee9c","#dce775","#d4e157","#cddc39","#c0ca33",
    "#afb42b","#9e9d24","#827717","#f4ff81","#eeff41","#c6ff00","#aeea00",
    "#fffde7","#fff9c4","#fff59d","#fff176","#ffee58","#ffeb3b","#fdd835",
    "#fbc02d","#f9a825","#f57f17","#ffff8d","#ffff00","#ffea00","#ffd600",
    "#fff8e1","#ffecb3","#ffe082","#ffd54f","#ffca28","#ffc107","#ffb300",
    "#ffa000","#ff8f00","#ff6f00","#ffe57f","#ffd740","#ffc400","#ffab00",
    "#fff3e0","#ffe0b2","#ffcc80","#ffb74d","#ffa726","#ff9800","#fb8c00",
    "#f57c00","#ef6c00","#e65100","#ffd180","#ffab40","#ff9100","#ff6d00",
    "#fbe9e7","#ffccbc","#ffab91","#ff8a65","#ff7043","#ff5722","#f4511e",
    "#e64a19","#d84315","#bf360c","#ff9e80","#ff6e40","#ff3d00","#dd2c00",
    "#efebe9","#d7ccc8","#bcaaa4","#a1887f","#8d6e63","#795548","#6d4c41",
    "#5d4037","#4e342e","#3e2723",
    "#fafafa","#f5f5f5","#eeeeee","#e0e0e0","#bdbdbd","#9e9e9e","#757575",
    "#616161","#424242","#212121",
    "#eceff1","#cfd8dc","#b0bec5","#90a4ae","#78909c","#607d8b","#546e7a",
    "#455a64","#37474f","#263238"
    ];
    @endphp

    {{-- Formulario de Infocards --}}
    <x-jet-confirmation-modal icon='edit' wire:model="updateForm">
        <x-slot name="title">
            Informaciones
        </x-slot>

        <x-slot name="content">
            <!-- Formulario sin FORM utilizando livewire -->
            <div class="flex flex-row flex-wrap">
                <div class="mx-2">
                    <label for="title" class="block form-label">Título</label>
                    <input wire:model.lazy="title" id="title" type="text" class="form-input">
                    
                    <label for="type" class="block form-label mt-4">Color Énfasis</label>
                    <div style="background-color:{{ $type }} !important;" class="p-4 rounded-md">
                        <select wire:model="type" name="type">
                            @foreach ($colors as $color)
                                <option style="background-color:{{ $color }};" value="{{ $color }}">
                                    &nbsp;{{ $color }}&nbsp;</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="mx-2">
                    <label for="text" class="block form-label">Información</label>
                    <textarea wire:model.lazy="text" name="text" id="text" cols="30" rows="5"
                        class="form-textarea"></textarea>
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">
                <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
                    Cancelar
                </x-jet-secondary-button>

                @if ($formAction == 'store')
                    <x-jet-button wire:click="store" color="green"
                        class="text-white font-bold px-3 py-1 rounded text-xs">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg> Crear
                    </x-jet-button>
                @else
                    <x-jet-button class="ml-2" wire:click="update" wire:loading.attr="disabled">
                        Modificar
                    </x-jet-danger-button>
                @endif
            </div>
        </x-slot>
    </x-jet-confirmation-modal>


    <div class="bg-gray-100 rounded-md shadow-md overflow-hidden max-w-4xl mx-auto mb-2 mt-4">
        <div class="w-full d2c px-4 py-3 text-white">
            <h1 class="inline-block">Tarjetas de Información</h1>
        </div>
        
        <div class="container my-3 mx-auto px-4 md:px-12">
            {{-- NEW Infocard --}}
            <x-jet-button color='green' wire:click="create">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg> Nueva
            </x-jet-button>

            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                @foreach ($infocards as $infocard)

                    <!-- Column -->
                    <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3">

                        <!-- Article -->
                        <article class="overflow-hidden rounded-lg shadow-lg">

                            <div style="background-color:{{ $infocard->type }}; text-shadow: 1px 1px 4px black;"
                                class="block h-12 w-full overflow-hidden text-white font-bold">
                                <p class="block p-2 mx-2 mt-2">
                                    {{ $infocard->title }}
                                </p>
                            </div>

                            <header class="items-center text-right px-2 border-b md:px-4 bg-gray-50">
                                <p class="text-xs"><small>{{ $infocard->updated_at->format('d-m-Y') }}</small></p>
                                <p class="text-left">
                                    @php
                                    echo nl2br($infocard->text);
                                    @endphp
                                </p>
                            </header>


                            <footer
                                class="bg-gray-200 border-t flex items-center justify-between leading-none p-1 md:p-2">
                                <a class="flex items-center no-underline hover:underline text-black" href="#">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ $infocard->user->profile_photo_url }}"
                                        alt="{{ $infocard->user->name }}" />
                                    <p class="ml-2 text-sm">
                                        {{ $infocard->user->name }}
                                    </p>
                                </a>
                                <a class="no-underline text-grey-darker hover:text-red-dark" href="#">
                                    <button wire:click="edit({{ $infocard }})"
                                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded text-xs">Editar</button>


                                    <button wire:click="$emit('triggerDelete',{{ $infocard }})"
                                        class="bg-red-500 hover:bg-red-700 text-white font-bold px-4 py-2 rounded text-xs">Borrar</button>
                                </a>
                            </footer>

                        </article>
                        <!-- END Article -->

                    </div>
                    <!-- END Column -->

                @endforeach
            </div>
        </div>

        {{ $infocards->links() }}

        {{-- //scripts stack --}}
        @push('scripts')
            <script type="text/javascript">
                document.addEventListener('DOMContentLoaded', function() {
                    @this.on('triggerDelete', infocard => {
                        Swal.fire({
                            title: 'Eliminar?',
                            text: infocard.title,
                            icon: "warning",
                            showCancelButton: true,
                            cancelButtonText: 'Cancelar',
                            cancelButtonColor: '#aa3333',
                            confirmButtonText: 'Eliminar',
                            confirmButtonColor: '#33aa33',

                        }).then((result) => {
                            //if user clicks on delete
                            if (result.value) {
                                // calling destroy method to delete
                                @this.call('destroy', infocard)
                                // success response
                                Toast.fire('Eliminado', '', 'success');

                            } else {
                                Toast.fire('Cancelado', '', 'error');
                            }
                        });
                    });
                })

            </script>
        @endpush

    </div>
</div>
