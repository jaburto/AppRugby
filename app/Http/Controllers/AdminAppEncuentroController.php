<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminAppEncuentroController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function __construct() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "100";
			$this->orderby = "numfecha,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = false;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "app_encuentro";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];

			$this->col[] = ["label"=>"#","name"=>"numfecha"];
			$this->col[] = ["label"=>"Fecha","name"=>"fecencuentro","callback_php"=>'date_format(date_create($row->fecencuentro),"Y/m/d H:i")'];
			$this->col[] = ["label"=>"Local","name"=>"id_app_equipolocal","join"=>"app_equipo,desnombre"];
			$this->col[] = ["label"=>"","name"=>"id"]; //FALSE
			$this->col[] = ["label"=>"","name"=>"numpuntajelocal"];
			$this->col[] = ["label"=>"","name"=>"numpuntajevisita"];
			$this->col[] = ["label"=>"","name"=>"id"];//FALSE
			$this->col[] = ["label"=>"Visita","name"=>"id_app_equipovisita","join"=>"app_equipo,desnombre"];
			//$this->col[] = ["label"=>"Estadio","name"=>"id_app_estadio","join"=>"app_estadio,desEstadio"];
			//$this->col[] = ["label"=>"Arbitro","name"=>"id_app_arbitro","join"=>"app_arbitro,desnombre"];
			$this->col[] = ["label"=>"Estado","name"=>"estencuentro","join"=>"view_estadoencuentro,label"];
			$this->col[] = ["label"=>"","name"=>"id","visible"=>false]; //FALSE
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ["label"=>"Campeonato","name"=>"id_app_campeonato","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_campeonato,desnombre"];
			$this->form[] = ["label"=>"Número de Fecha","name"=>"numfecha","type"=>"number","validation"=>"required|integer|min:0","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Estadio","name"=>"id_app_estadio","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_estadio,desEstadio", "value"=>"5"];
			$this->form[] = ["label"=>"Arbitro","name"=>"id_app_arbitro","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_arbitro,desnombre", "value"=>"2"];
			$this->form[] = ["label"=>"Equipo Local","name"=>"id_app_equipolocal","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_equipo,desnombre"];
			$this->form[] = ["label"=>"Equipo Visita","name"=>"id_app_equipovisita","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_equipo,desnombre"];
			$this->form[] = ["label"=>"Fecha","name"=>"fecencuentro","type"=>"datetime","validation"=>"required|date_format:Y-m-d H:i:s","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Puntaje Local","name"=>"numpuntajelocal","type"=>"number","validation"=>"required|integer|min:0","width"=>"col-sm-10", "value"=>"0"];
			$this->form[] = ["label"=>"Puntaje Visita","name"=>"numpuntajevisita","type"=>"number","validation"=>"required|integer|min:0","width"=>"col-sm-10", "value"=>"0"];
			$this->form[] = ["label"=>"Descripción","name"=>"desencuentro","type"=>"text","validation"=>"min:1|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Tipo de Encuentro","name"=>"tipoencuentro","type"=>"select","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"view_tipoencuentro,label", "value"=>"2"];
			$this->form[] = ["label"=>"Estado del Encuentro","name"=>"estencuentro","type"=>"select","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"view_estadoencuentro,label", "value"=>"5"];
			$this->form[] = ["label"=>"Activo / Inactivo","name"=>"estregistro","type"=>"select","validation"=>"required","width"=>"col-sm-10","datatable"=>"view_estadoregistro,label", "value"=>"1"];
			# END FORM DO NOT REMOVE THIS LINE



			/*
	        | ----------------------------------------------------------------------
	        | Sub Module
	        | ----------------------------------------------------------------------
			| @label          = Label of action
			| @path           = Path of sub module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        |
	        */
	        $this->sub_module = array();
			/*
			$this->sub_module[] = ['label'=>'Detail','path'=>'app_encuentrodetalle','parent_columns'=>'numfecha,id_app_equipolocal','button_color'=>'primary','button_icon'=>'fa fa-bars'];*/
			$this->sub_module[] = ['label'=>'Detalle','path'=>'app_encuentrodetallefast','parent_columns'=>'numfecha','button_color'=>'success','button_icon'=>'fa fa-list-ol'];
			$this->sub_module[] = ['label'=>'Players','path'=>'app_encuentroxplantilla','parent_columns'=>'id_app_encuentro','button_color'=>'success','button_icon'=>'fa fa-users','showIf'=>'[estencuentro] == "1"'];

	        /*
	        | ----------------------------------------------------------------------
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        |
	        */
	        $this->addaction = array();

	        /*
	        | ----------------------------------------------------------------------
	        | Add More Button Selected
	        | ----------------------------------------------------------------------
	        | @label       = Label of action
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button
	        | Then about the action, you should code at actionButtonSelected method
	        |
	        */
	        $this->button_selected = array();

	        /*
	        | ----------------------------------------------------------------------
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------
	        | @message = Text of message
	        | @type    = warning,success,danger,info
	        |
	        */
	        $this->alert        = array();



	        /*
	        | ----------------------------------------------------------------------
	        | Add more button to header button
	        | ----------------------------------------------------------------------
	        | @label = Name of button
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        |
	        */
	        $this->index_button = array();


	        /*
	        | ----------------------------------------------------------------------
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.
	        |
	        */
	        $this->table_row_color = array();
			$this->table_row_color[] = ["condition"=>"[estencuentro] == 9","color"=>"danger"];
			$this->table_row_color[] = ["condition"=>"[estencuentro] == 1","color"=>"info"];
			$this->table_row_color[] = ["condition"=>"[estencuentro] == 8","color"=>"warning"];

	        /*
	        | ----------------------------------------------------------------------
	        | You may use this bellow array to add statistic at dashboard
	        | ----------------------------------------------------------------------
	        | @label, @count, @icon, @color
	        |
	        */
	        $this->index_statistic = array();
			$query1 = DB::table('app_encuentro')
				    ->where('id_app_campeonato', '=', g('parent_id') )
					->whereIn('estencuentro', [10,5])
			        ->groupBy('id_app_campeonato')
					->count();

			$query2 = DB::table('app_encuentrodetallefast')
					->join('app_encuentro', 'app_encuentro.id', '=', 'app_encuentrodetallefast.id_app_encuentro')
				    ->where('app_encuentro.id_app_campeonato', '=', $_GET['parent_id'])
					->where('app_encuentrodetallefast.id_app_accion', '=', 1)
			        ->sum('numtotal');
			$query3 = DB::table('app_encuentro')
				    ->where('id_app_campeonato', '=', g('parent_id') )
					->where('estencuentro', '=', 9)
			        ->groupBy('id_app_campeonato')
					->count();
			$queryWO = DB::table('app_encuentro')
				    ->where('id_app_campeonato', '=', g('parent_id') )
					->where('estencuentro', '=',8)
			        ->groupBy('id_app_campeonato')
					->count();
					//->count();
			$this->index_statistic[] = ['label'=>'Finalizados','count'=>$query1,'icon'=>'fa fa-check','color'=>'blue'];
			$this->index_statistic[] = ['label'=>'Reprogramados','count'=>$query3,'icon'=>'fa fa-calendar-check-o','color'=>'yellow'];
			$this->index_statistic[] = ['label'=>'W.O.','count'=>$queryWO,'icon'=>'fa fa-calendar-times-o','color'=>'red'];
			$this->index_statistic[] = ['label'=>'Numero de tries','count'=>$query2,'icon'=>'fa fa-flash','color'=>'blue'];
			//$this->index_statistic[] = ['label'=>'Try Man','count'=>'Juan Perez','icon'=>'fa fa-book','color'=>'blue'];
			//$this->index_statistic[] = ['label'=>'max Try','count'=>'Newton','icon'=>'fa fa-book','color'=>'blue'];
			//$this->index_statistic[] = ['label'=>'Winner','count'=>'U. Lima','icon'=>'fa fa-book','color'=>'blue'];


	        /*
	        | ----------------------------------------------------------------------
	        | Add javascript at body
	        | ----------------------------------------------------------------------
	        | javascript code in the variable
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;



	        /*
	        | ----------------------------------------------------------------------
	        | Include Javascript File
	        | ----------------------------------------------------------------------
	        | URL of your javascript each array
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();



	        //No need chanage this constructor
	        $this->constructor();
	    }




	    /*
	    | ----------------------------------------------------------------------
	    | Hook for button selected
	    | ----------------------------------------------------------------------
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {

	    }


	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate query of index result
	    | ----------------------------------------------------------------------
	    | @query = current sql query
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	        //$query->where('is_protected',0);
			//$query->where('is_protected',0);


			//$this->sub_module[] = ['label'=>'Players2','path'=>'app_encuentroxplantilla','parent_columns'=>'id_app_encuentro','button_color'=>'success','button_icon'=>'fa fa-users'];
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */

	    public function hook_row_index($column_index,&$column_value) {

			if($column_index==4){
				$id_app_encuentro = $column_value;
				$isLocal = true;
				$column_value =  $this->getDetalle($id_app_encuentro,$isLocal);
			}
			//5-6 Score
			if($column_index==7){
				$id_app_encuentro = $column_value;
				$isLocal = false;
				$column_value =  $this->getDetalle($id_app_encuentro,$isLocal);
			}
			if($column_index==8){
				//$id_app_equipoVisita = $column_value;
			}




	    	//Your code here
			//$column_value['id_app_arbitro'] = 2;
			//$column_value['id_app_estadio'] = 5;
			//$column_value['estRegistro'] = 1;
			//$column_value['id_app_campeonato'] = 5;
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before add data is execute
	    | ----------------------------------------------------------------------
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
			//Your code here
	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after add public static function called
	    | ----------------------------------------------------------------------
	    | @id = last insert id
	    |
	    */
	    public function hook_after_add($id) {
	        //Your code here
			$app_encuentro = DB::table('app_encuentro')->where('id',$id)->get();
			$countDetallefast =  DB::table('app_encuentrodetallefast')->where('id_app_encuentro',$id)->count();
			if( $countDetallefast < 6 ){
				DB::table('app_encuentrodetallefast')->insert([
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipolocal,'numtotal' => 0, 'id_app_accion' => 1],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipolocal,'numtotal' => 0, 'id_app_accion' => 2],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipolocal,'numtotal' => 0, 'id_app_accion' => 3],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipovisita,'numtotal' => 0, 'id_app_accion' => 1],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipovisita,'numtotal' => 0, 'id_app_accion' => 2],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipovisita,'numtotal' => 0, 'id_app_accion' => 3]
				]);
			}

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate data input before update data is execute
	    | ----------------------------------------------------------------------
	    | @postdata = input post data
	    | @id       = current id
	    |
	    */
	    public function hook_before_edit(&$postdata,$id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_edit($id) {
	        //Your code here
			$app_encuentro = DB::table('app_encuentro')->where('id',$id)->get();
			$countDetallefast =  DB::table('app_encuentrodetallefast')->where('id_app_encuentro',$id)->count();
			if( $countDetallefast < 6 ){
				DB::table('app_encuentrodetallefast')->insert([
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipolocal,'numtotal' => 0, 'id_app_accion' => 1],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipolocal,'numtotal' => 0, 'id_app_accion' => 2],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipolocal,'numtotal' => 0, 'id_app_accion' => 3],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipovisita,'numtotal' => 0, 'id_app_accion' => 1],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipovisita,'numtotal' => 0, 'id_app_accion' => 2],
					['id_app_encuentro' => $id,'id_app_equipo' => $app_encuentro[0]->id_app_equipovisita,'numtotal' => 0, 'id_app_accion' => 3]
				]);
			}

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------
	    | @id       = current id
	    |
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :)
		private function getDetalle($encuentroId, $isLocal){
			$app_encuentro = DB::table('app_encuentro')->where('id',$encuentroId)->get();
			$app_equipo = $isLocal?$app_encuentro[0]->id_app_equipolocal : $app_encuentro[0]->id_app_equipovisita;

			$detalleFast = DB::table('app_encuentrodetallefast')
			->where('id_app_encuentro',$app_encuentro[0]->id)
			->where('id_app_equipo',$app_equipo)
			//->where('id_app_accion',1)
			->get();

			$Try = 0;
			$Conv = 0;
			$Pen = 0;
			foreach ($detalleFast as $obj)
		   {
				if( $obj->id_app_accion == 1)$Try = $obj->numtotal;
				if( $obj->id_app_accion == 2)$Conv = $obj->numtotal;
				if( $obj->id_app_accion == 3)$Pen = $obj->numtotal;
		   }

			if($Try == 0 && $Pen == 0){
				return "-";
			}
			$Concaternar =  ($Try>0)?$Try."T " : "";
			$Concaternar =  $Concaternar.(($Conv>0)?" | ".$Conv."C " : "");
			$Concaternar =  $Concaternar.(($Pen>0)?" | ".$Pen."P" : "");
			return $Concaternar;
		}

		public function getMatch($id){

			header("Location: http://localhost:1024/simulador/tabla.php?id_app_campeonato=".$id."");
             exit();
			return redirect("http://localhost:1024/simulador/tabla.php?id_app_campeonato=".$id);
		}

		public function getFixture(){

			$id_app_campeonato = Request::get('id_app_campeonato');
			if( $id_app_campeonato == null ){
				$app_campeonatoTemp = DB::table('app_campeonato')->first();
				$id_app_campeonato = $app_campeonatoTemp->id;
			}
			$id_app_encuentrofecha = Request::get('id_app_encuentrofecha');
			if( $id_app_encuentrofecha == null ){
				$id_app_encuentrofecha = 1;
			}


			$app_encuentrofecha = DB::table('app_encuentro')->select('numfecha')->where('id_app_campeonato',$id_app_campeonato)->groupBy('numfecha')->get();
			if( count($app_encuentrofecha) < $id_app_encuentrofecha ){
				$id_app_encuentrofecha = 1;
			}
			$fixture = DB::table('app_encuentro')
					   ->join('app_equipo as equipoa', 'equipoa.id', '=', 'app_encuentro.id_app_equipolocal')
					   ->join('app_equipo as equipob', 'equipob.id', '=', 'app_encuentro.id_app_equipovisita')
					   ->join('app_estadio as estadio', 'estadio.id', '=', 'app_encuentro.id_app_estadio')
					   ->join('view_estadoencuentro as estadoencuentro', 'estadoencuentro.id', '=', 'app_encuentro.estencuentro')
			->select(
			'equipoa.desnombre as desnombrea','equipoa.imglogo as imglogoa',
			'equipob.desnombre as desnombreb','equipob.imglogo as imglogob',
			'estadio.desestadio as desestadio',
			'estadoencuentro.label as estencuentroLabel',
			'app_encuentro.*')
			->where('id_app_campeonato',$id_app_campeonato)
			->where('numfecha',$id_app_encuentrofecha)
			->orderBy('numfecha')
			->get()
			->groupBy('numfecha');

			$data['page_title'] = "Fixture";
			$data['fixture']  = $fixture;
			$data['app_campeonato'] = DB::table('app_campeonato')->get();
			$data['app_encuentrofecha'] = $app_encuentrofecha;

			$data['id_app_campeonato'] = $id_app_campeonato;
			$data['id_app_encuentrofecha'] = $id_app_encuentrofecha;

			return view('crudbooster::post_index_encuentro',$data);


		}


		public function getTablePosition(){

			$id_app_campeonato = Request::get('id_app_campeonato');
			if( $id_app_campeonato == null ){
				$app_campeonatoTemp = DB::table('app_campeonato')->first();
				$id_app_campeonato = $app_campeonatoTemp->id;
			}
			$id_app_encuentrofecha = Request::get('id_app_encuentrofecha');
			if( $id_app_encuentrofecha == null ){
				$id_app_encuentrofecha = 1;
			}
			$app_encuentrofecha = DB::table('app_encuentro')->select('numfecha')->where('id_app_campeonato',$id_app_campeonato)->groupBy('numfecha')->get();
			if( count($app_encuentrofecha) < $id_app_encuentrofecha ){
				$id_app_encuentrofecha = 1;
			}
			$fixture = DB::table('app_encuentro')
					   ->join('app_equipo as equipoa', 'equipoa.id', '=', 'app_encuentro.id_app_equipolocal')
					   ->join('app_equipo as equipob', 'equipob.id', '=', 'app_encuentro.id_app_equipovisita')
					   ->join('app_estadio as estadio', 'estadio.id', '=', 'app_encuentro.id_app_estadio')
					   ->join('view_estadoencuentro as estadoencuentro', 'estadoencuentro.id', '=', 'app_encuentro.estencuentro')
			->select('equipoa.desnombre as desnombrea','equipob.desnombre as desnombreb','estadio.desEstadio as desEstadio',
			'estadoencuentro.label as estencuentroLabel',
			'app_encuentro.*')
			->where('id_app_campeonato',$id_app_encuentrofecha )->orderBy('numfecha')
			->get()
			->groupBy('numfecha');

			$data['page_title'] = "Fixture";
			$data['fixture']  = $fixture;

			$arr = array();
			$app_campeonatoxequipo = DB::table('app_campeonatoxequipo')->where('id_app_campeonato',$id_app_campeonato)->get();
			foreach ($app_campeonatoxequipo as $app)
			{
				$id_app_equipo = $app->id_app_equipo;//Flaming
				array_push($arr , $this->GetDataTeam($id_app_campeonato,$id_app_equipo,$id_app_encuentrofecha ));
			}

			$arr = collect($arr)->sortBy('numPuntajeFinal')->reverse()->toArray();

			$data['table']  = $arr;
			$data['page_title'] = "Tabla de posiciones";
			$data['app_campeonato'] = DB::table('app_campeonato')->get();
			$data['app_encuentrofecha'] = $app_encuentrofecha;

			$data['id_app_campeonato'] = $id_app_campeonato;
			$data['id_app_encuentrofecha'] = $id_app_encuentrofecha;
			return view('crudbooster::post_index_tablaposicion',$data);


		}

		public function GetDataTeam($id_app_campeonato,$id_app_equipo,$numfecha) {

				$app_campeonato 	= DB::table('app_campeonato')->where('id',$id_app_campeonato)->get();
				$app_equipo 		= DB::table('app_equipo')->where('id',$id_app_equipo)->get();
				$app_encuentroLocal = DB::table('app_encuentro')->where('id_app_equipolocal',$id_app_equipo)
																->where('id_app_campeonato',$id_app_campeonato)
																->where('numfecha', '<=', $numfecha)
																->get();
				$app_encuentroVisita = DB::table('app_encuentro')->where('id_app_equipovisita',$id_app_equipo)
																->where('id_app_campeonato',$id_app_campeonato)
																->where('numfecha', '<=', $numfecha)
																->get();



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
					$numSumPuntajefavor = $numSumPuntajefavor + $app_encuentro->numpuntajelocal;
					$numSumPuntajeContra = $numSumPuntajeContra + $app_encuentro->numpuntajevisita;


					$s = $this->getLastMatchString($app_encuentro->numpuntajelocal, $app_encuentro->numpuntajevisita);
                        if ($s === "WIN") {
                            $numPartidosGanados++;
                        } else if ($s === "LOST") {
							if( $app_encuentro->estencuentro == 8 ){
								$numPartidosPerdidosWO++;
							}
                            $numPartidosPerdidos++;
                            if (($app_encuentro->numpuntajevisita - $app_encuentro->numpuntajelocal) <= 7) {
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
						$sumTryLocal = $sumTryLocal  + $detalleFastLocal[0]->numtotal;
						if($detalleFastLocal[0]->numtotal >= 4){
							$sumBonus4++;
						}
						if($detalleFastLocal[1]->numtotal > 0){
							$promConv =  (100*$detalleFastLocal[1]->numtotal)/$detalleFastLocal[0]->numtotal;
							$sumEfectividadConv = $sumEfectividadConv+$promConv;
						}
					}
			    }

				// VISITA
				foreach ($app_encuentroVisita as $app_encuentro)
			    {
					$numSumPuntajefavor = $numSumPuntajefavor + $app_encuentro->numpuntajevisita;
					$numSumPuntajeContra = $numSumPuntajeContra + $app_encuentro->numpuntajelocal;

					$s = $this->getLastMatchString($app_encuentro->numpuntajevisita, $app_encuentro->numpuntajelocal);
                        if ($s === "WIN") {
                            $numPartidosGanados++;
                        } else if ($s === "LOST") {
							if( $app_encuentro->estencuentro == 8 ){
								$numPartidosPerdidosWO++;
							}
                            $numPartidosPerdidos++;
                            if (($app_encuentro->numpuntajelocal - $app_encuentro->numpuntajevisita) <= 7) {
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
						$sumTryVisita = $sumTryVisita  + $detalleFastVisita[0]->numtotal;
						if($detalleFastVisita[0]->numtotal >= 4){
							$sumBonus4++;
						}
						if($detalleFastVisita[1]->numtotal > 0){
							$promConv =  (100*$detalleFastVisita[1]->numtotal)/$detalleFastVisita[0]->numtotal;
							$sumEfectividadConv = $sumEfectividadConv+$promConv;
						}
					}

			    }


				$puntaje = (4*$numPartidosGanados) + (2*$numPartidosEmpatados)+ (1*$sumBonus4)+ (1*$sumBonus7) - (1*$numPartidosPerdidosWO);
				$numPromedioConv =  ($sumPartidosConTry>0)? ceil($sumEfectividadConv / $sumPartidosConTry):0;
				//TODO
				$nombreEquipo = ($id_app_campeonato == 7)?$app_equipo[0]->desnombreFemenino:$app_equipo[0]->desnombre;
				return
					array(
					'id_app_equipo' => $id_app_equipo,
					'nombreCampeonato' => $app_campeonato[0]->desnombre,
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
					'numtotalTry' => $sumTryLocal+$sumTryVisita,
					'numPromedioConv' => $numPromedioConv,
					'imgLogo' => $app_equipo[0]->imglogo,
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
