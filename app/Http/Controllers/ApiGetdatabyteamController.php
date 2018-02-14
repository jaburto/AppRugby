<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetdatabyteamController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "app_encuentro";        
				$this->permalink   = "getdatabyteam";    
				$this->method_type = "get";    
		    }
		

		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process

		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query
		    }

		    public function hook_after($postdata,&$result) {
				
				$id_app_equipo = g('id_app_equipo');//NAVY
				$id_app_campeonato = g('id_app_campeonato');
				$numFecha = g('numfecha');
				//$id_app_equipo = 3;//Flaming
				$json = array();
				//g('id')
				/*
				DB::table('users')
            ->where('name', '=', 'John')
            ->orWhere(function ($query) {
                $query->where('votes', '>', 100)
                      ->where('title', '<>', 'Admin');
            })
            ->get();*/
				//$result = DB::table('app_encuentro')->where('id_app_campeonato',$id_app_campeonato)->where('id_app_equipolocal',$id_app_equipo)->get();
				$result = DB::table('app_encuentro')
				->join('app_equipo as equipoA', 'equipoA.id', '=', 'app_encuentro.id_app_equipolocal')
				->join('app_equipo as equipoB', 'equipoB.id', '=', 'app_encuentro.id_app_equipovisita')
				->join('app_campeonato', 'app_campeonato.id', '=', 'app_encuentro.id_app_campeonato')
				->select('app_encuentro.*', 'equipoA.desNombre as desNombreA', 'equipoB.desNombre as desNombreB',
				'equipoA.imgLogo as desLogoA', 'equipoB.imgLogo as desLogoB','app_campeonato.desNombre as desNombreCampeonato')
				->where('id_app_campeonato',$id_app_campeonato)
				->where('numFecha','<',$numFecha)
				->where(function ($query) {
					$query->where('id_app_equipolocal', '=', g('id_app_equipo'))
						  ->orWhere('id_app_equipovisita', '=', g('id_app_equipo'));
				})
				->get();
				/*return DB::table('app_encuentro')->where('id_app_campeonato',$id_app_campeonato)->get();
				
				
				$app_campeonatoxequipo = DB::table('app_encuentro')->where('id_app_campeonato',$id_app_campeonato)->get();
				foreach ($app_campeonatoxequipo as $app)
			    {
					$id_app_equipo = $app->id_app_equipo;//Flaming
					array_push($json , $this->GetDataTeam($id_app_campeonato,$id_app_equipo));
				}
				$result = $json;
				return $json;*/

		    }
			
		}