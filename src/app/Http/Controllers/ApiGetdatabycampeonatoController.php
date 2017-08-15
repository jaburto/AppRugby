<?php namespace App\Http\Controllers;

		use Session;
		use Request;
		use DB;
		use CRUDBooster;

		class ApiGetdatabycampeonatoController extends \crocodicstudio\crudbooster\controllers\ApiController {

		    function __construct() {    
				$this->table       = "app_encuentro";        
				$this->permalink   = "getdatabycampeonato";    
				$this->method_type = "get";    
		    }
		


		    public function hook_before(&$postdata) {
		        //This method will be execute before run the main process

		    }

		    public function hook_query(&$query) {
		        //This method is to customize the sql query
		    }

		    public function hook_after($postdata,&$result) {
				$id_app_campeonato = g('id');//Primera 5
				//$id_app_equipo = 3;//Flaming
				$json = array();
				//g('id')
				$app_campeonatoxequipo = DB::table('app_campeonatoxequipo')->where('id_app_campeonato',$id_app_campeonato)->get();
				foreach ($app_campeonatoxequipo as $app)
			    {
					$id_app_equipo = $app->id_app_equipo;//Flaming
					array_push($json , $this->GetDataTeam($id_app_campeonato,$id_app_equipo));
				}
				$result = $json;
				return $json;

		    }
			
			public function GetDataTeam($id_app_campeonato,$id_app_equipo) {
				
				$app_campeonato 	= DB::table('app_campeonato')->where('id',$id_app_campeonato)->get();
				$app_equipo 		= DB::table('app_equipo')->where('id',$id_app_equipo)->get();
				$app_encuentroLocal = DB::table('app_encuentro')->where('id_app_equipolocal',$id_app_equipo)
																->where('id_app_campeonato',$id_app_campeonato)
																->get();
				$app_encuentroVisita = DB::table('app_encuentro')->where('id_app_equipovisita',$id_app_equipo)->where('id_app_campeonato',$id_app_campeonato)->get();

				
				
				$numPartidosGanados = 0;
				$numPartidosPerdidos = 0;
				$numPartidosEmpatados = 0;
				$numPartidosPerdidosWO = 0;
				$numSumPuntajefavor = 0;
				$numSumPuntajeContra = 0;
				$sumTryLocal = 0;
				$sumTryVisita = 0;
				$sumBonus4 = 0;
				$sumBonus7 = 0;
				
				$sumEfectividadConv = 0;
				$sumPartidosConTry =0;
				
				// LOCAL
				foreach ($app_encuentroLocal as $app_encuentro)
			    {
					$numSumPuntajefavor = $numSumPuntajefavor + $app_encuentro->numPuntajeLocal;
					$numSumPuntajeContra = $numSumPuntajeContra + $app_encuentro->numPuntajeVisita;
					
					$s = $this->getLastMatchString($app_encuentro->numPuntajeLocal, $app_encuentro->numPuntajeVisita);
                        if ($s === "WIN") {
                            $numPartidosGanados++;
                        } else if ($s === "LOST") {
                            $numPartidosPerdidos++;
                            if (($app_encuentro->numPuntajeVisita - $app_encuentro->numPuntajeLocal) <= 7) {
                                $sumBonus7++;
                            }
                        } else if ($s === "DRAW") {
                            $numPartidosEmpatados++;
                        }			
						
					$detalleFastLocal = DB::table('app_encuentrodetallefast')->where('id_app_encuentro',$app_encuentro->id)
					->where('id_app_equipo',$id_app_equipo)
					->whereIn('id_app_accion',[1,2])//Trys
					->orderBy('id_app_accion', 'asc')
					->get();
					
					
					
					if($detalleFastLocal!=null){
						$sumPartidosConTry++;
						$sumTryLocal = $sumTryLocal  + $detalleFastLocal[0]->numTotal;
						if($detalleFastLocal[0]->numTotal >= 4){
							$sumBonus4++;
						}
						if($detalleFastLocal[1]->numTotal > 0){
							$promConv =  (100*$detalleFastLocal[1]->numTotal)/$detalleFastLocal[0]->numTotal;
							$sumEfectividadConv = $sumEfectividadConv+$promConv;
						}
					}
			    }
				
				// VISITA
				foreach ($app_encuentroVisita as $app_encuentro)
			    {
					$numSumPuntajefavor = $numSumPuntajefavor + $app_encuentro->numPuntajeVisita;
					$numSumPuntajeContra = $numSumPuntajeContra + $app_encuentro->numPuntajeLocal;
					
					$s = $this->getLastMatchString($app_encuentro->numPuntajeVisita, $app_encuentro->numPuntajeLocal);
                        if ($s === "WIN") {
                            $numPartidosGanados++;
                        } else if ($s === "LOST") {
                            $numPartidosPerdidos++;
                            if (($app_encuentro->numPuntajeLocal - $app_encuentro->numPuntajeVisita) <= 7) {
                                $sumBonus7++;
                            }
                        } else if ($s === "DRAW") {
                            $numPartidosEmpatados++;
                        }	
						
						
					$detalleFastVisita = DB::table('app_encuentrodetallefast')->where('id_app_encuentro',$app_encuentro->id)
					->where('id_app_equipo',$id_app_equipo)
					->whereIn('id_app_accion',[1,2])//Trys
					->orderBy('id_app_accion', 'asc')
					->get();
					
					if($detalleFastVisita != null){
						$sumPartidosConTry++;
						$sumTryVisita = $sumTryVisita  + $detalleFastVisita[0]->numTotal;
						if($detalleFastVisita[0]->numTotal >= 4){
							$sumBonus4++;
						}
						if($detalleFastVisita[1]->numTotal > 0){
							$promConv =  (100*$detalleFastVisita[1]->numTotal)/$detalleFastVisita[0]->numTotal;
							$sumEfectividadConv = $sumEfectividadConv+$promConv;
						}
					}
					
			    }
				
				
				$puntaje = (4*$numPartidosGanados) + (2*$numPartidosEmpatados)+ (1*$sumBonus4)+ (1*$sumBonus7);
				$numPromedioConv =  ($sumPartidosConTry>0)? ceil($sumEfectividadConv / $sumPartidosConTry):0;
				//TODO
				$nombreEquipo = ($id_app_campeonato == 7)?$app_equipo[0]->desNombreFemenino:$app_equipo[0]->desNombre;
				return
					array(
					'id_app_equipo' => $id_app_equipo, 
					'nombreCampeonato' => $app_campeonato[0]->desNombre, 
					'nombre' => $nombreEquipo, 
					'numPartidosJugados' => $numPartidosGanados+$numPartidosPerdidos, 
					'numPartidosGanados' => $numPartidosGanados, 
					'numPartidosPerdidos' => $numPartidosPerdidos, 
					'numPartidosEmpatados' => $numPartidosEmpatados, 
					'numPartidosPerdidosWO'  => $numPartidosPerdidosWO, 
					'numBonus4' => $sumBonus4,
					'numBonus7' => $sumBonus7,
					'numSumPuntajefavor' => $numSumPuntajefavor, 
					'numSumPuntajeContra' => $numSumPuntajeContra, 
					'numSumPuntajeDiferencia' => $numSumPuntajefavor-$numSumPuntajeContra, 
					'numPuntajeFinal' => $puntaje, 
					'numTotalTry' => $sumTryLocal+$sumTryVisita, 
					'numPromedioConv' => $numPromedioConv, 
					'imgLogo' => $app_equipo[0]->imgLogo,
					'e' => g('id')
					);
				
   
		    }
			
			public function getLastMatchString($Puntaje1, $Puntaje2) {
				$r = '';
				if ($Puntaje1 > 0 || $Puntaje2 > 0) {
					if ($Puntaje1 > $Puntaje2) {
						$r = 'WIN';
					} else if ($Puntaje1 < $Puntaje2) {
						$r = 'LOST';
					} else {
						$r = 'DRAW';
					}
				} else {
					$r = 'ERROR';
				}
				return $r;
			}
		}