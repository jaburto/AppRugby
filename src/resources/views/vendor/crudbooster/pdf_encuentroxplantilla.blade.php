
<style>

.body{
font-family: "Helvetica Neue",Helvetica,Helvetica,Arial,sans-serif;
font-style: normal;

}
.page-break {
page-break-after: always;
}
.headPdf {
	font-size:12px;

}
.tableprint {
	font-size:10px;
	padding:5px;
    border-collapse: collapse;
}
.tableprint, th, td {
    border: 1px solid black;
}
</style>

<h3>Listado de jugadores</h3>


<label class="headPdf">Club : {{$app_equipo[0]->desNombreLargo}}</label>
<label class="headPdf">Encuentro : {{$app_equipo[0]->desNombreLargo}}</label>
<label class="headPdf">Fecha : {{$app_equipo[0]->desNombreLargo}}</label>
<table class="tableprint" width='100%' cellpadding='5' cellspacing="5" style='border-collapse: collapse;font-size:11px'>
	<tr>
		<th width="3%">#</td>
		<th width="52%">Nombre del jugador</td>
		<th width="35%">Posicion</td>
		<th width="10%">Numero</td>
	</tr>
	@foreach($jugadoresxencuentro as $c)
	<tr>
		<td style='text-align:center'>{{ $loop->iteration}}</td>
		<td>{{$c->desApellidoPaterno}}{{$c->desNombre}} </td>
		<td></td>
		<td></td>
	</tr>
	@endforeach
</table>
<div class="page-break"></div>
