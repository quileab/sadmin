<style>
  * {
    font-family: Arial, Helvetica, sans-serif
  }

  h2{
    margin: 0rem;
    padding: 0rem;
  }
  h4{
    margin: 0rem;
    padding: 0rem;
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
  <h2>{{ $config['shortname'] }} - {{ $config['longname'] }}</h2>
  <h4>{{ $config[$insc_conf_id] }} - 
    {{ $career->id }}: {{ $career->name }}
  </h4>
<br />
  <table>
    <tr>
      <td>
        <strong>{{$student->lastname}}, {{$student->firstname}}</strong><br />
        <small>{{$student->email}} - {{$student->phone}}</small>
      </td>
      <td>
        {{ date('d-m-Y H:i', strtotime(now())) }}    
      </td>
    </tr>
  </table>


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