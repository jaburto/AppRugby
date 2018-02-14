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
		text-align: center;
		color: #FFF;
		font-size: 12px;
		font-family: 'TradeG',Arial;
		text-transform: uppercase;
		font-weight: 900;
	}
	.field_nameB{
		text-align: center;
		color: #FFF;
		font-size: 12px;
		font-family: 'TradeG',Arial;
		text-transform: uppercase;
		font-weight: 900;
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
		width : 60px;
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
                      <option value='{{$c->id}}' {{($id_app_campeonato == $c->id)?"selected":""}}>{{$c->desNombre}}</option>
                    @endforeach
				</select>
		
			<label class='label-control'>Fecha</label>
			<select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_encuentrofecha'>                  
				@foreach($app_encuentrofecha as $ef)
				  <option value='{{$ef->numFecha}}' {{($id_app_encuentrofecha == $ef->numFecha)?"selected":""}}>{{$ef->numFecha}}</option>
				@endforeach
			</select>
				
		<br />
		
		@foreach($fixture as $fix) 
				<!--
				<div class="field_fecha">
				 <div>Fecha : {{$fix->first()->numFecha}} 
				 </div>
				</div>
				
				<table class="field_fecha" width="100%"> 
						<tr>
							<td>FECHA</td>
							<td>HORA</td>
							<td></td>
							<td>LOCAL</td>
							<td>SCORE</td>
							<td>VISITA</td>
						</tr>
						
				<table/>
				-->
				@foreach($fix as $row) 
					<table width="100%"> 
						<tr class="row_fixture">
							<td class="field_date"> 05/04/2017 </td>
							<td class="field_hour"> 14:00 </td>
							<td class="field_imgA">
								<img src="{{url('/')}}/{{$row->imgLogoA}}" alt="{img}" width="50" height="50">
							</td>
							<td class="field_nameA">{{$row->desNombreA}}</td>
							<td class="field_score">
													{{is_null($row->numPuntajeLocal)?"0":$row->numPuntajeLocal}} - 
													{{is_null($row->numPuntajeVisita)?"0":$row->numPuntajeVisita}}
							</td>
							<td class="field_nameB">{{$row->desNombreB}}</td>
								
							<td class="field_imgB">
								<img src="{{url('/')}}/{{$row->imgLogoB}}" alt="{img}" width="50" height="50">
							</td>
							<td class="field_estadio">
							{{$row->desEstadio}}
							</td>
							<td class="field_estadio">
							{{$row->estEncuentroLabel}}
							</td>
							<td class="field_icon">
							 <a class='btn btn-xs btn-success' title='stats' target='_blank' href='http://localhost:1024/simulador/match.php?numFecha={{$id_app_encuentrofecha}}&id_app_campeonato={{$row->id_app_campeonato}}&id_app_equipoA={{$row->id_app_equipolocal}}&id_app_equipoB={{$row->id_app_equipovisita}}'>Match</a> 
							 <a class='btn btn-xs btn-success' title='stats' target='_blank' href='http://localhost:1024/simulador/stats.php?numFecha={{$id_app_encuentrofecha}}&id_app_campeonato={{$row->id_app_campeonato}}&id_app_equipoA={{$row->id_app_equipolocal}}&id_app_equipoB={{$row->id_app_equipovisita}}'>stats</a> 										 
							 </td>
							 <!--
							<td class="field_estadio">
							{{$row->estEncuentroLabel}}
							</td>
							-->
							 <!--
							<td class="field_icon">
							 <a class='btn btn-xs btn-success' title='{{trans("crudbooster.action_edit_data")}}' href='{{CRUDBooster::mainpath("edit/$row->id")."?return_url=".urlencode(Request::fullUrl())."&parent_id=".g("parent_id")."&parent_field=".$parent_field }}'>{{trans("crudbooster.action_edit_data")}}</a> 
							 
							<?php $url = CRUDBooster::mainpath("delete/$row->id");?>
        	<a class='btn btn-xs btn-warning' title='{{trans("crudbooster.action_delete_data")}}' href='javascript:;' onclick='{{CRUDBooster::deleteConfirm($url)}}'>{{trans("crudbooster.action_delete_data")}}</a> 

							
				  
							</td>
							
							-->
							<!--td class="field_action">Reporte | Detalle</td-->
						</tr>
					</table>
					
				@endforeach
			@endforeach
			
		
		
	</div>
	</form>
	</div>
         
    </div>   
	<!--END AUTO MARGIN-->

@endsection