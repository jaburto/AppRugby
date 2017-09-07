<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminAppCampeonatoController extends \crocodicstudio\crudbooster\controllers\CBController {

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
			$this->button_filter = false;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "app_campeonato";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Título","name"=>"desNombre"];
			$this->col[] = ["label"=>"Fecha de Inicio","name"=>"fecInicio"];
			$this->col[] = ["label"=>"Fecha de Termino","name"=>"fecFin"];
			$this->col[] = ["label"=>"Año","name"=>"numPeriodo"];
			$this->col[] = ["label"=>"Tipo ","name"=>"valTipo","join"=>"view_tipocampeonato,label"];
			$this->col[] = ["label"=>"Forma","name"=>"valForma","join"=>"view_formacampeonato,label"];
			$this->col[] = ["label"=>"Estado","name"=>"estRegistro","join"=>"view_estadoregistro,label"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ["label"=>"Título","name"=>"desNombre","type"=>"text","validation"=>"required|min:3|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Fecha de Inicio","name"=>"fecInicio","type"=>"date","validation"=>"required|date","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Fecha de Termino","name"=>"fecFin","type"=>"date","validation"=>"required|date","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Periodo","name"=>"numPeriodo","type"=>"text","validation"=>"required|min:3|max:255","width"=>"col-sm-10"];
			$this->form[] = ["label"=>"Tipo de campeonato","name"=>"valTipo","type"=>"select","validation"=>"required","width"=>"col-sm-10","datatable"=>"view_tipocampeonato,label"];
			$this->form[] = ["label"=>"Forma de campeonato","name"=>"valForma","type"=>"select","validation"=>"required","width"=>"col-sm-9","datatable"=>"view_formacampeonato,label"];
			$this->form[] = ["label"=>"Estado","name"=>"estRegistro","type"=>"select","validation"=>"required","width"=>"col-sm-9","datatable"=>"view_estadoregistro,label"];
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
			//$this->sub_module[] = ['label'=>'Equipos','path'=>'app_campeonatoxequipo','parent_columns'=>'desTitulo','button_color'=>'primary','button_icon'=>'fa fa-bars'];
			//$this->sub_module[] = ['label'=>'Fixture','path'=>'app_encuentro','parent_columns'=>'desNombre,numPeriodo','button_color'=>'primary','button_icon'=>'fa fa-bars','colslabel'=>'Nombre,Periodo'];
			


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
			//$this->addaction[] = ['label'=>'Tabla','icon'=>'fa fa-pay','color'=>'warning','url'=>CRUDBooster::mainpath('table-position').'/[id]'];
			

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
			if( CRUDBooster::myPrivilegeId() == 1 )
				$this->addaction[] = ['label'=>'Tabla','icon'=>'fa fa-pay','color'=>'warning','url'=>CRUDBooster::mainpath('table-position').'/[id]'];

			$this->sub_module[] = ['label'=>'Equipos','path'=>'app_campeonatoxequipo','parent_columns'=>'desNombre','button_color'=>'primary','button_icon'=>'fa fa-bars'];
			$this->sub_module[] = ['label'=>'Fixture','path'=>'app_encuentro','parent_columns'=>'desNombre,numPeriodo','button_color'=>'primary','button_icon'=>'fa fa-bars'];
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

		public function getTablePosition($id){
			 	
			header("Location: http://localhost:1024/simulador/tabla.php?id_app_campeonato=".$id."");
             exit();
			return redirect("http://localhost:1024/simulador/tabla.php?id_app_campeonato=".$id); 
		}

	    //By the way, you can still create your own method in here... :) 


	}