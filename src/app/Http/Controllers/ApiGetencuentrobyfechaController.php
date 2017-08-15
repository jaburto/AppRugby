<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetencuentrobyfechaController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "app_encuentro";        
				$this->permalink   = "getencuentrobyfecha";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process

		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query

		    }

		    public function hook_after($postdata,&$result) {
				$numFecha = 1; //g('numFecha');//Primera 5
				$id_app_campeonato = 7;// g('id_app_campeonato');//Primera 5

		        //This method will be execute after run the main process
				
				$fixture = DB::table('app_encuentro')
					   ->join('app_equipo as equipoA', 'equipoA.id', '=', 'app_encuentro.id_app_equipolocal')
					   ->join('app_equipo as equipoB', 'equipoB.id', '=', 'app_encuentro.id_app_equipovisita')
					   ->join('app_estadio as estadio', 'estadio.id', '=', 'app_encuentro.id_app_estadio')
					   ->join('view_estadoencuentro as estadoencuentro', 'estadoencuentro.id', '=', 'app_encuentro.estEncuentro')
			->select(
			'equipoA.desNombreFemenino as desNombreA','equipoA.imgLogo as imgLogoA',
			'equipoB.desNombreFemenino as desNombreB','equipoB.imgLogo as imgLogoB',
			'estadio.desEstadio as desEstadio',
			'estadoencuentro.label as estEncuentroLabel',
			'app_encuentro.*')
			->where('id_app_campeonato',$id_app_campeonato)->orderBy('numFecha')
			->get();
			$result = $fixture;
		    }

		}