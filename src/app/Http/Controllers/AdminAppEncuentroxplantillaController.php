<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	
	class AdminAppEncuentroxplantillaController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->button_export = true;
			$this->table = "app_encuentroxplantilla";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"App Encuentro","name"=>"id_app_encuentro","join"=>"app_encuentro,id"];
			$this->col[] = ["label"=>"App Equipo","name"=>"id_app_equipo","join"=>"app_equipo,id"];
			$this->col[] = ["label"=>"App Jugador","name"=>"id_app_jugador","join"=>"app_jugador,id"];
			$this->col[] = ["label"=>"ValPosicion","name"=>"valPosicion"];
			$this->col[] = ["label"=>"NumCamiseta","name"=>"numCamiseta"];
			$this->col[] = ["label"=>"DesObservacion","name"=>"desObservacion"];
			$this->col[] = ["label"=>"EstRegistro","name"=>"estRegistro"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ["label"=>"App Encuentro","name"=>"id_app_encuentro","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_encuentro,id"];
			$this->form[] = ["label"=>"App Equipo","name"=>"id_app_equipo","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_equipo,id"];
			$this->form[] = ["label"=>"App Jugador","name"=>"id_app_jugador","type"=>"select2","validation"=>"required|integer|min:0","width"=>"col-sm-10","datatable"=>"app_jugador,id"];
			$this->form[] = ["label"=>"ValPosicion","name"=>"valPosicion","type"=>"number","validation"=>"required|integer|min:0","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"NumCamiseta","name"=>"numCamiseta","type"=>"number","validation"=>"required|integer|min:0","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"DesObservacion","name"=>"desObservacion","type"=>"text","validation"=>"required|min:3|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"EstRegistro","name"=>"estRegistro","type"=>"number","validation"=>"required|integer|min:0","width"=>"col-sm-10"];
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

		public function getIndex(){
		
			//Datos Basicos
			$data['page_title'] = "Plantilla";
			
			$id_app_encuentro = g('parent_id');
			if( id_app_encuentro == null ){
				$id_app_encuentro = g('id_app_encuentro');
			}
			
			$app_encuentro = DB::table('app_encuentro')->where('id',$id_app_encuentro)->first();
			$app_equipo = DB::table('app_equipo')->whereIn('id', [$app_encuentro->id_app_equipolocal,$app_encuentro->id_app_equipovisita])->get();
			
			$id_app_equipo = g('id_app_equipo');
			if( $id_app_equipo == null ){
				$id_app_equipo = $app_equipo[0]->id;
			}
			
			$app_plantilla = DB::table('app_plantilla')->where('id_app_equipo',$id_app_equipo)->get();
			$id_app_plantilla = ( g('id_app_plantilla') == null ) ? $app_plantilla[0]->id : g('id_app_plantilla');
			
			
			$jugadoresFederados = DB::table('app_jugador')
			->Join('app_plantillaxjugador', 'app_jugador.id', '=', 'app_plantillaxjugador.id_app_jugador')
			->where('app_plantillaxjugador.id_app_plantilla',  $id_app_plantilla )
			->whereNotIn('app_jugador.id', function($q){
				$q->select('app_jugadorIn.id')->from('app_jugador as app_jugadorIn')->Join('app_encuentroxplantilla', 'app_jugadorIn.id', '=', 'app_encuentroxplantilla.id_app_jugador');
			})
			->select('app_jugador.*')->orderBy('app_jugador.desApellidoPaterno')->get();

			$jugadoresxencuentro = DB::table('app_jugador')
            ->Join('app_encuentroxplantilla', 'app_jugador.id', '=', 'app_encuentroxplantilla.id_app_jugador')
			->where('app_encuentroxplantilla.id_app_equipo',$id_app_equipo)
            ->select('app_jugador.*')->orderBy('app_jugador.desApellidoPaterno')->get();
			
			$data['jugadoresxencuentro'] = $jugadoresxencuentro;
			$data['jugadoresFederados']= $jugadoresFederados;
			$data['id_app_encuentro']= $id_app_encuentro;
			$data['app_equipo']= $app_equipo;
			$data['app_plantilla']= $app_plantilla;
			$data['id_app_equipo']= $id_app_equipo;
			return view('crudbooster::post_index_encuentroxplantilla',$data);
			
		}

	    //By the way, you can still create your own method in here... :) 

		public function postAddSaveTemplate() {
	  		$id_app_encuentro = Request::input('id_app_encuentro');
			$id_app_jugador = Request::input('id_app_jugador');
			$id_app_equipo = Request::input('id_app_equipo');
			
			
			$exitsRow = DB::table('app_encuentroxplantilla')
						->where('id_app_encuentro',  $id_app_encuentro)
						->where('id_app_equipo',  $id_app_equipo )
						->where('id_app_jugador',  $id_app_jugador )
						->count();
				
			if( $exitsRow == 0){
				DB::table('app_encuentroxplantilla')->insert( 
					[
						'id_app_encuentro' => $id_app_encuentro, 
						'id_app_equipo' => $id_app_equipo,
						'id_app_jugador' => $id_app_jugador ,
						'valPosicion' => 1,'numCamiseta' => 0,'desObservacion' => '' ,'estRegistro' => 1 ]);
			}	  

	  		return response()->json(['success'=>true]);
		}
		public function postDeleteSaveTemplate() {
	  		$id_app_encuentro = Request::input('id_app_encuentro');
			$id_app_jugador = Request::input('id_app_jugador');
			$id_app_equipo = Request::input('id_app_equipo');
			DB::table('app_encuentroxplantilla')->delete( ['id_app_encuentro' => $id_app_encuentro, 'id_app_equipo' => $id_app_equipo,'id_app_jugador' => $id_app_jugador ]);
			
			//Lista Final de jugadores
			DB::table('app_encuentroxplantilla')->where('id_app_encuentro',  $id_app_encuentro )
												->where('id_app_jugador',  $id_app_jugador )
												->where('id_app_equipo',  $id_app_equipo )->delete();
													  
	  		return response()->json(['success'=>true]);
		}	

		public function postExportPdf() {		
		
			//$view = view('crudbooster::pdf_encuentroxplantilla',$response)->render();			
			$id_app_encuentro = Request::input('id_app_encuentro');
			$id_app_equipo = Request::input('app_id_equipo');
			
			$equipo = DB::table('app_equipo')->where('id', $id_app_equipo)->get();
			$jugadoresxencuentro = DB::table('app_jugador')
            ->Join('app_encuentroxplantilla', 'app_jugador.id', '=', 'app_encuentroxplantilla.id_app_jugador')
            ->select('app_jugador.*')->orderBy('app_jugador.desApellidoPaterno')->get();

			$pdf = \App::make('dompdf.wrapper');
			$pdf->loadView('crudbooster::pdf_encuentroxplantilla',array('jugadoresxencuentro' => $jugadoresxencuentro, 'app_equipo' => $equipo));
			//return $pdf->download('aaa.pdf');
			return $pdf->stream('aaa.pdf');
		}
	}