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
      /* padding-top: 3cm;
      padding-bottom: 3.1cm; */
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
      border: 0px solid #000;
      border-bottom: 0px solid #000;
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
      border-bottom: 0px solid #000;
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
      border-bottom: 0px solid #000;
    }

    /* table tfoot total */
    table tfoot tr:last-child td:first-child {
      border-right: 0px solid #000;
    }

    table tfoot tr:last-child td:last-child {
      border-left: 0px solid #000;
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

    .w-full {
      width: 100%;
    }
  </style>
</head>

<body>
    {{-- <header> --}}
      <div>
        <table>
          <tr>
            <td>
              <div>
                <img style="height:3cm; width:auto;" src="./storage/imgs/logo.jpg">
              </div>
              <div>
                RECIBO Nº: 000000
              </div>

            </td>
            <td class="text-center">
              <p class="font-xl font-bold">
                ESCUELA DE EDUCACIÓN SECUNDARIA ORIENTADA<br>
                PARTICULAR INCORPORADA Nº 8206
              </p>
              <p class="font-md">
                <strong>"Roberto Vicentín"</strong>
              </p>
              <p class="font-sm">
                Calle 14 Nº 581 (3561) AVELLANEDA (Santa Fe) - Tel. (03482) 481182
              </p>
              <p class="font-xsm">
                CUIT: 30-56780754-8 - IVA: Excento
              </p>
            </td>
          </tr>
        </table>
      </div>
    {{-- </header>
    <footer>
      Receipt Footer
    </footer> --}}
    <main class="font-md">
      <div class="text-right w-full">Avellaneda, 00/00/0000</div>
      <table>
        <tr>
          <td class="text-right">
            Recibí de:<br>
            la cantidad de pesos:<br>
            Concepto:<br>
            Curso/Div:<br>
            <br>
            SON PESOS:
          </td>
          <td class="text-left">
            <strong>Perez, Juan</strong><br>
            <strong>Mil ciento diez</strong><br>
            <strong>Pago voluntario, mayo 2022</strong><br>
            <strong>Quinto "B"</strong><br>
            <br>
            <strong>$ 1.110,00</strong>
          </td>
        </tr>
        <tr>
          <td><span class="font-md">DUPLICADO</span></td>
          <td><span class="font-xsm">Firma Autorizada</span></td>
        </tr>
      </table>
    </main>
</body>

</html>
