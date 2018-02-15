<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminAppPlantillaxjugadorController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function __construct() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "app_plantillaxjugador";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Plantilla","name"=>"id_app_plantilla","join"=>"app_plantilla,desplantilla"];
			$this->col[] = ["label"=>"Jugador","name"=>"id_app_jugador","join"=>"app_jugador,desnombre"];
			$this->col[] = ["label"=>"FecCreacion","name"=>"feccreacion"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ["label"=>"Plantilla","name"=>"id_app_plantilla","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_plantilla,id"];
			$this->form[] = ["label"=>"Jugador","name"=>"id_app_jugador","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_jugador,id"];
			$this->form[] = ["label"=>"FecCreacion","name"=>"fecCreacion","type"=>"date","validation"=>"required|date","width"=>"col-sm-10"];
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


	        /*
	        | ----------------------------------------------------------------------
	        | You may use this bellow array to add statistic at dashboard
	        | ----------------------------------------------------------------------
	        | @label, @count, @icon, @color
	        |
	        */
	        $this->index_statistic = array();



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
			$this->load_js[] = asset("jquery-sortable.js");


	        //No need chanage this constructor
	        $this->constructor();
	    }


		public function getAdd(){

			if( CRUDBooster::myPrivilegeId() == 1 )  {
				$app_plantilla = DB::table('app_plantilla')->get();
			}

			//Usuario Login
			$id = CRUDBooster::myId();

			$teams = DB::table('app_equipoxusuario')
				    ->where('id_cms_users', $id)
			        ->get();
			$arrIds = array();
			foreach($teams as $app)
			{
				$arrIds[] = $app->id_app_equipo;
			}

			$app_plantilla = DB::table('app_plantilla')->whereIn('id_app_equipo',$arrIds)->get();

			$id_app_plantilla = Request::input('id_app_plantilla');
			if( $id_app_plantilla == null ){
				$plantillaTemp = DB::table('app_plantilla')->whereIn('id_app_equipo',$arrIds)->first();
				$id_app_plantilla = $plantillaTemp->id;
			}


			$jugadoresPlantilla = DB::table('app_jugador')
            ->Join('app_plantillaxjugador', 'app_jugador.id', '=', 'app_plantillaxjugador.id_app_jugador')
			->where('app_plantillaxjugador.id_app_plantilla',  $id_app_plantilla )
			->whereIn('app_jugador.id_app_equipo',  $arrIds )
            ->select('app_jugador.*')->orderBy('app_jugador.desapellidopaterno')->get();





			$jugadoresDisponibles = DB::table('app_jugador')
			->whereIn('app_jugador.id_app_equipo',  $arrIds )
			->whereNotIn('app_jugador.id', function($q) use ($id_app_plantilla){
				$q->select('app_plantillaxjugador.id_app_jugador')->from('app_plantillaxjugador')->where('id_app_plantilla', '=', $id_app_plantilla );
			})
			->select('app_jugador.*')->orderBy('app_jugador.desapellidopaterno')->get();


			$data['id_app_plantilla'] = $id_app_plantilla;
			$data['page_title'] = "Plantilla Por jugador";
			$data['plantilla']  = $app_plantilla;
			$data['jugadores']  = $jugadoresDisponibles;
			$data['plantillaxjugador']  = $jugadoresPlantilla;

			return view('crudbooster::post_add_plantillaxjugador',$data);
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
	        //Your code here

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

	    }

	    /*
	    | ----------------------------------------------------------------------
	    | Hook for manipulate row of index table html
	    | ----------------------------------------------------------------------
	    |
	    */
	    public function hook_row_index($column_index,&$column_value) {
	    	//Your code here
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
		public function postSaveTemplate() {

			$id_app_plantilla = Request::input('plantillaid');
			$post = Request::input('plantilla');
	  		$post = json_decode($post,true);

			$idslist = array();

			//Jugadores Marcados seleccionados
			foreach($post[0] as $ro) {
	  			$pid = $ro['id'];
				$idslist[] = $pid;
				$exitsRow = DB::table('app_plantillaxjugador')
															->where('id_app_jugador',  $pid)
															->where('id_app_plantilla',  $id_app_plantilla )
															->count();

				if( $exitsRow == 0){

					DB::table('app_plantillaxjugador')->insert( ['id_app_jugador' => $pid, 'id_app_plantilla' => $id_app_plantilla]);
				}
	  		}
			//Lista Final de jugadores
			DB::table('app_plantillaxjugador')->where('id_app_plantilla',  $id_app_plantilla )
													  ->whereNotIn('id_app_jugador',  $idslist )->delete();

	  		return response()->json(['success'=>true]);
		}

	}
