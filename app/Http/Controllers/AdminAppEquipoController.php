<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminAppEquipoController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->table = "app_equipo";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Código","name"=>"id"];
			$this->col[] = ["label"=>"Nombre","name"=>"desNombre"];
			$this->col[] = ["label"=>"Nombre Comercial","name"=>"desNombreLargo"];
			$this->col[] = ["label"=>"Estado","name"=>"estRegistro","join"=>"view_estadoregistro,label"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ["label"=>"Nombre","name"=>"desNombre","type"=>"text","validation"=>"required|min:3|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Nombre Largo","name"=>"desNombreLargo","type"=>"text","validation"=>"required|min:3|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Banner","name"=>"imgBanner","type"=>"text","validation"=>"required|min:3|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Logo","name"=>"imgLogo","type"=>"upload","validation"=>"","width"=>"col-sm-10","filemanager_type"=>"image"];
			$this->form[] = ["label"=>"Lugar de Entrenamiento","name"=>"desEntrenamiento","type"=>"text","validation"=>"max:255","width"=>"col-sm-9"];
			$this->form[] = ["label"=>"Horario de Entrenamiento","name"=>"desHorario","type"=>"text","validation"=>"max:255","width"=>"col-sm-9"];
			$this->form[] = ["label"=>"Contacto Referencia","name"=>"desContacto","type"=>"text","validation"=>"max:255","width"=>"col-sm-9"];
			$this->form[] = ["label"=>"Página Web","name"=>"desWebsite","type"=>"text","validation"=>"max:255","width"=>"col-sm-9"];
			$this->form[] = ["label"=>"Página de Facebook","name"=>"desFacebook","type"=>"text","validation"=>"max:255","width"=>"col-sm-9"];
			$this->form[] = ["label"=>"Estado","name"=>"estRegistro","type"=>"select","validation"=>"","width"=>"col-sm-10","datatable"=>"view_estadoregistro,label"];
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
			$this->sub_module[] = ['label'=>'Jugadores','path'=>'app_jugador','parent_columns'=>'numFecha','button_color'=>'success','button_icon'=>'fa fa-users'];	
			$this->sub_module[] = ['label'=>'Plantilla','path'=>'app_plantilla','parent_columns'=>'numFecha','button_color'=>'warning','button_icon'=>'fa fa-th-list'];	

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
	        //$this->alert[] = ["message"=>"Lorem ipsum dolor sit amet, amet sit dolor ipsum lorem...","type"=>"info"];

	        
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
			if( CRUDBooster::myPrivilegeId() == 1 )  return;
			$id = CRUDBooster::myId();
			
			$query2 = DB::table('app_equipoxusuario')
				    ->where('id_cms_users', $id)
			        ->get();
			$arrIds = array();
			foreach($query2 as $app)
			{
				$arrIds[] = $app->id_app_equipo;
			}
			
			$query->whereIn('app_equipo.id', $arrIds );

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

		public function getData(){
			//$id = 12;
			//return route('crudbooster::AdminAppEquipoControllerGetAdd');
			//return view('AdminAppEquipoController',compact('page_title'));
			//$this->getEdit(12);
		}

	    //By the way, you can still create your own method in here... :) 


	}