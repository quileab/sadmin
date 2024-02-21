<style>
  * {
    font-family: Arial, Helvetica, sans-serif;
    padding:0px;
    margin:0px;
  }

  hr {
    height: 1rem;
    border: 0px;
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
    width:100%; border:2px solid; border-collapse:collapse;
  }

  table td, table th{
    border:1px solid;
    padding:0.4rem 0.5rem;
  }

  table th{
    border-bottom: 2px solid black;
    background-color:#eee;
  }
  
  table tr{
    page-break-inside: avoid !important;
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

  .right{
    text-align:right;
  }
  .center{
    text-align:center;
  }
  .bold{
    font-weight: bold;
  }

</style>

<style media="print">
@media print {

@page {
  size: A4 portrait;
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
  <div class="dontPrint" style="position:relative; top:0px; left:0px; width:100%; text-align:right; padding:0.4rem; margin-bottom:1rem; background-color: #ddd; border:3px solid #aaa;">
    <button type="button" onclick="window.print();return false;"
      style=".">🖨️ Imprimir</button>
    <button type="button" onclick="window.close();return false;"
      style=".">❌ Cerrar</button>
  </div>
  <h2>Cuotas</small></h2>

  <table>
    <tr>
      <td>
        {{ date('d-m-Y', strtotime($data['dateFrom'])) }} - {{ date('d-m-Y', strtotime($data['dateTo'])) }}
      </td>
      <td>
        {{ $data['search'] }}
        {{-- {{ date('d-m-Y H:i', strtotime(now())) }} --}}
      </td>
    </tr>

  </table>
  <hr />
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Estudiante</th>
        <th>Descripción</th>
        <th>Importe</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($records as $record)
        <tr>
          <td class="center">{{ $record['id'] }}</td>
          <td>{{ $record['created_at']->format('d-m-Y') }}</td>
          <td>{{ $record['user']['lastname'] }}, {{ $record['user']['firstname'] }}</td>
          <td>{{ $record['description'] }}%</td>
          <td class="right">{{ number_format($record['paymentAmount'],2) }}</td>
        </tr>
      @endforeach
      <tr class="bold">
        <td></td>
        <td></td>
        <td></td>
        <td class='right'>TOTAL</td>
        <td class="right">{{ number_format($data['total'],2) }}</td>
      </tr>
    </tbody>
  </table>
