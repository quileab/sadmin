<!DOCTYPE html>
<html lang="es">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <style>
    /* import from google fonts open sans */
    @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,700');

    /* page size A4, all borders 0.5 cm */
    @page {
      size: A4;
      margin: 0.5cm;
    }

    /* page header */
    header {
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
      height: 3cm;
    }

    /* page footer */
    footer {
      position: fixed;
      bottom: 0cm;
      left: 0cm;
      right: 0cm;
      height: 3cm;
    }

    footer .page:after {
      counter-increment: pages content: counter(pages);
    }

    footer .page:before {
      content: counter(page) "/";
    }

    /* page body */
    body {
      font-family: 'Open Sans', sans-serif;
      padding-top: 3cm;
      padding-bottom: 3.1cm;
      counter-reset: pages 1;
    }

    /* table */
    table {
      border-collapse: collapse;
      border-spacing: 0;
      font-family: 'Open Sans', sans-serif;
      font-size: 12px;
      width: 100%;
    }

    table thead {
      border: 1px solid #000;
      border-bottom: 2px solid #000;
    }

    table thead th {
      padding: 1mm;
      text-align: center;
    }

    table tbody td {
      padding: 1mm;
      text-align: center;
    }

    table tbody tr:nth-child(even) {
      background-color: #eee;
    }

    table tbody tr:nth-child(odd) {
      background-color: #fff;
    }

    table tbody tr:last-child td {
      border-bottom: 1px solid #000;
    }

    /* table tfoot */
    table tfoot {
      border: 1px solid #000;
      border-top: 2px solid #000;
    }

    table tfoot td {
      padding: 1mm;
      text-align: center;
    }

    table tfoot tr:last-child td {
      border-bottom: 1px solid #000;
    }

    /* table tfoot total */
    table tfoot tr:last-child td:first-child {
      border-right: 1px solid #000;
    }

    table tfoot tr:last-child td:last-child {
      border-left: 1px solid #000;
    }

    p {
      margin: 0rem;
      padding: 0rem;
    }

    /* font sizes */
    .font-xsm {
      font-size: .6rem;
    }

    .font-sm {
      font-size: .8rem;
    }

    .font-md {
      font-size: 1.2rem;
    }

    .font-lg {
      font-size: 1.4rem;
    }

    .font-xl {
      font-size: 1.6rem;
    }

    .font-xxl {
      font-size: 2rem;
    }

    /* font weights */
    .font-bold {
      font-weight: bold;
    }

    .font-light {
      font-weight: 300;
    }

    .font-normal {
      font-weight: normal;
    }

    /* text align */
    .text-left {
      text-align: left;
    }

    .text-center {
      text-align: center;
    }

    .text-right {
      text-align: right;
    }

    /* border */
    .border {
      border: 1px solid #000;
    }

    .border-top {
      border-top: 1px solid #000;
    }

    .border-bottom {
      border-bottom: 1px solid #000;
    }

    .border-left {
      border-left: 1px solid #000;
    }

    .border-right {
      border-right: 1px solid #000;
    }

    .borderless {
      border: 0px;
    }

    .flex {
      display: flex;
    }

    .inline-flex {
      display: inline-flex;
    }

    .inline-block {
      display: inline-block;
    }

    .page-break {
      page-break-after: always;
    }

  </style>
</head>

<body>
    <header>
      <div>
        <table>
          <tr>
            <td style="width:45%;" class="text-left border">
              <div>
                <img style="height:1.5cm; width:auto;" src="{{ public_path('imgs') . '/logo.jpg' }}">
              </div>
              <div class="font-sm">
                <small>Datos Alumno: </small><br />
              </div>

            </td>
            <td style="width:10%;" class="border">
              <div class="font-bold font-xxl"> data['inv_letter'] </div>
              cod <br>
              <p class="font-sm">Copia</p>
            </td>
            <td style="width:45%;" class="text-left border">
              <span class="font-bold font-lg">
                data
              </span>&nbsp;
              <span class="font-md">data['ptoVta'] - data['invoice_number'] </span>
              <br />
              Fecha:  data['invoice_date'] <br />
              CUIT:  data['conf']['cuit']  -
              IIBB:  data['conf']['iibb'] <br />
              Inicio de Actividades:  data['conf']['start_date']
              {{ public_path() }}
            </td>
          </tr>
        </table>
      </div>
    </header>
    <footer>
      Receipt Footer
    </footer>
    <main>
      <table>
        <tr>
          <td style="width:50%;" class="text-left border">
            <strong>Cliente: data['customer']->name </strong><br />
            Domicilio:  data['customer']->address ,  data['customer']->city 
          </td>
          <td style="width:50%;" class="text-left border">
            Cond. fte. al IVA: <strong> data['customer']->responsibility_type_id </strong><br />
            CUIT:  data['customer']->CUIT 

          </td>
        </tr>
      </table>
      <table class="font-xsm">
        <thead style="background-color: #dddddd;">
          <tr>
            <th style="width:5%; overflow:hidden;" class="border-top border-left">Cód.</th>
            <th style="width:60%;" class="border-top border-left">Descripción</th>
            <th style="width:10%;" class="border-top border-left">Cant.</th>
            <th style="width:10%;" class="border-top border-left">U. med.</th>
            <th style="width:15%;" class="border-top border-left">Precio Unitario</th>
            <th style="width:10%;" class="border-top border-left">% Desc.</th>
            <th style="width:15%;" class="border-top border-left">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          Table body
        </tbody>
        <tfoot>
          <tr>
            <td colspan=" data['inv_letter'] === 'A' ? 7:5 " class="text-right border-top border-left">
              Subtotal
            </td>
            <td colspan="2" class="text-right border-top border-right">
               currency_format(data['ImpNeto']) 
            </td>
          </tr>
          <tr>
            <td colspan=" data['inv_letter'] === 'A' ? 7:5 " class="text-right border-left border-right">
              <strong>Total</strong>
            </td>
            <td colspan="2" class="text-right border-top border-left border-right">
              <strong> currency_format(data['ImpTotal']) </strong>
            </td>

        </tfoot>
      </table>

    </main>
</body>

</html>
