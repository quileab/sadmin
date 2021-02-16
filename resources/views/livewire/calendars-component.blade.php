<div>
    Empty Calendar {{ $text ?? 'vacío' }}
    <br>
    Oficina de Atención » {{ $office }}
    <select wire:model.lazy="office" wire:change.lazy="officeChanged" name="office" id="office">
        <option value="0">
            Seleccione una Opción
        </option>

        @foreach ($offices as $off)
            <option value="{{ $off->id }}">
                {{ $off->description }}
            </option>
        @endforeach
    </select><br />
    <br>
    Turnos<hr>
    @if(empty($schedules))
        Sin registros
    @else
        @foreach ($schedules as $schedule)
        {{ $schedule->user->name }} -
        {{$schedule->datetime}} - {{$schedule->fullname}}<br />
        @endforeach
    @endif


</div>
