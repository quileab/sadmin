<style>
  * {
    font-family: Arial, Helvetica, sans-serif
  }

  table{
    width:100%; border:1px solid; border-collapse:collapse;
  }

  table td, table th{
    border:1px solid;
    padding:0.5rem 1rem;
  }

</style>

<div>
  <h3>
    {{$student->lastname}}, {{$student->firstname}}
  </h3>
  <h4>
    {{ $career->id }}: {{ $career->name }}
  </h4>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Materia</th>
        <th>Inscripción</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($inscriptions as $inscription)
        @if ($inscription->subject['career_id']==$career->id)    
        <tr>
          <td>{{ $inscription->subject_id }}</td>
          <td>{{ $inscription->subject['name'] }}</td>      
          <td>{{ $inscription->value }}</td>
        </tr>
        @endif
      @endforeach
    </tbody>
  </table>
</div>