@extends('crudbooster::admin_template')
@section('content')

    <link rel="stylesheet" href="" {{asset('css/coderay.css')}}>
    <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script>
	<style type="text/css">
	.row_fixture{
		background-color:#0B2F64;
		color: #FFF;
	}
	.row_fixture td{
		padding: 10px 5px 10px 5px;
	}
	.field_fecha{
		background: #FFFFFF;
		color: #010B1C;
		text-shadow: none;
		display:block !important;
		height:25px !important;
		vertical-align: middle;
		border:1px solid #0B2F64;
	}
	.field_fecha div{

		padding-left:20px;
	}
	.field_nameA {
		text-align: right;
		color: #FFF;
		font-size: 1em;
		font-family: 'TradeG',Arial;
		text-transform: uppercase;
	}
	.field_nameB{
		text-align: left;
		color: #FFF;
		font-size: 1em;
		font-family: 'TradeG',Arial;
		text-transform: uppercase;
	}
	.field_date, .field_hour{

		line-height: 1.2em;
		text-align: center;
		padding: 10px 5px 10px 5px;
		font-size: 1em;
		vertical-align: middle;
	}
	.field_date{
	width : 100px;
	}
	.field_hour{
	width : 100px;
	}
	.field_imgA, .field_imgB{
	width : 50px;
	}
	.field_nameA,.field_nameB {
		width : 150px;
	}
	.field_score{
		width : 50px;
	}
	.field_estadio{
		width : 150px;
	}
	.field_icon{
		text-align: rigth;
	}
	</style>




	<div class='row'>
	<div class='col-sm-12'>
	<form method='get' action='' id='form-privilege'>
       <div class='form-group'>



		<label class='label-control'>Campeonato</label>
                <select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_campeonato'>
                    @foreach($app_campeonato as $c)
                      <option value='{{$c->id}}' {{($id_app_campeonato == $c->id)?"selected":""}}>{{$c->desnombre}}</option>
                    @endforeach
				</select>

			<label class='label-control'>Fecha</label>
			<select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_encuentrofecha'>
				@foreach($app_encuentrofecha as $ef)
				  <option value='{{$ef->numfecha}}' {{($id_app_encuentrofecha == $ef->numfecha)?"selected":""}}>{{$ef->numfecha}}</option>
				@endforeach
			</select>

		<br />


				<table id='table_dashboard' class="table table-hover table-striped table-bordered">
                    <thead>
                    <tr class="active">

                      <th width='3%'>Posicion</th>
					  <th width='10%'>Equipo</th>
					  <th width='3%'>PJ</th>
					  <th width='3%'>PG</th>
					  <th width='3%'>PE</th>
					  <th width='3%'>PP</th>
					  <th width='3%'>W.O.</th>
					  <th width='3%'>PF</th>
					  <th width='3%'>PC</th>
					  <th width='3%'>DP</th>
					  <th width='3%'>PB4</th>
					  <th width='3%'>PB7</th>
					  <th width='3%'>PTS</th>
                    </tr>
                    </thead>
                    <tbody>


				@foreach($table as $row)

						<tr>

							<td>1</td>
							<td>{{$row["nombre"]}}</td>
							<td>{{$row["numPartidosJugados"]}}</td>
							<td>{{$row["numPartidosGanados"]}}</td>
							<td>{{$row["numPartidosEmpatados"]}}</td>
							<td>{{$row["numPartidosPerdidos"]}}</td>
							<td>{{$row["numPartidosPerdidosWO"]}}</td>
							<td>{{$row["numSumPuntajefavor"]}}</td>
							<td>{{$row["numSumPuntajeContra"]}}</td>
							<td>{{$row["numSumPuntajeDiferencia"]}}</td>
							<td>{{$row["numBonus4"]}}</td>
							<td>{{$row["numBonus7"]}}</td>
							<td>{{$row["numPuntajeFinal"]}}</td>
						</tr>


				@endforeach

                    </tbody>


                    <tfoot>
                    <tr>

                    <th width='3%'>Posicion</th>
					  <th width='10%'>Equipo</th>
					  <th width='3%'>PJ</th>
					  <th width='3%'>PG</th>
					  <th width='3%'>PE</th>
					  <th width='3%'>PP</th>
					  <th width='3%'>W.O.</th>
					  <th width='3%'>PF</th>
					  <th width='3%'>PC</th>
					  <th width='3%'>DP</th>
					  <th width='3%'>PB4</th>
					  <th width='3%'>PB7</th>
					  <th width='3%'>PTS</th>
                    </tr>
                    </tfoot>
                  </table>





	</div>
	</form>
	</div>

    </div>
	<!--END AUTO MARGIN-->

@endsection
