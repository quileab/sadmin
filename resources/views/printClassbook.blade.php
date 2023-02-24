<style>
  * {
    font-family: Arial, Helvetica, sans-serif;
    padding:0px;
    margin:0px;
  }

  body {
    margin:1rem;
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
    padding:0.4rem 0.5rem;
  }

  .right{
    text-align:right;
  }

  button {
			color: #ffffff;
			background-color: #2d63c8;
			font-size: 19px;
			border: 1px solid #1b3a75;
			border-radius: 0.5rem;
			padding: 0.5rem 2rem;
			cursor: pointer
		}
	button:hover {
    background-color: #3271e7;
			color: #ffffff;
	}

</style>

<style media="print">
/* @page {size:landscape}  */ 
@media print {

@page {
  size: A4 landscape;
  max-height:100%;
  max-width:100%;
  margin: 1cm;
}

body {
  width:100%;
  height:100%;
  margin: 0cm;
  padding: 0cm;
  }    
}

.dontPrint {
     display:none;
}

</style>   
  <div class="dontPrint" style="width:100%; text-align:right; padding:0.4rem; margin-bottom:1rem; background-color: #ddd; border:3px solid #aaa;">
    <button type="button" onclick="window.print();return false;"
      style=".">🖨️ Imprimir</button>
    <button type="button" onclick="window.close();return false;"
      style=".">❌ Cerrar</button>
  </div>
  <h2>{{ $config['shortname'] }} - {{ $config['longname'] }}</h2>

  <table>
    <tr>
      <td>
        {{ $data['subject']->id }}: {{ $data['subject']->name }}
      </td>
      <td class='right'>
        {{ date('d-m-Y H:i', strtotime(now())) }}    
      </td>
    </tr>
  </table>


  <table>
    <thead>
      <tr>
        <th>Fecha</th>
        <th>Clase - Unidad</th>
        <th>Tipo</th>
        <th>Contenido</th>
        <th>Actividades</th>
        <th>Observaciones</th>
        <th>Profesor</th>
        <th>Autoridad</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($classbooks as $classbook)
        <tr>
          <td>{{ date('d-m-Y',strtotime($classbook->date_id)) }}</td>
          <td>{{ $classbook->ClassNr }} - {{ $classbook->Unit }}</td>      
          <td>{{ $classbook->Type }}</td>
          <td>{{ $classbook->Content }}</td>
          <td>{{ $classbook->Activities }}</td>
          <td>{{ $classbook->Observations }}</td>
          <td>{{ \App\Models\User::find($classbook->user_id)->lastname }}</td>
          <td>{{ $classbook->Authority_user_id }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
