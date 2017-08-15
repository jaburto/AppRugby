@extends('crudbooster::admin_template')
@section('content')	 

    <link rel="stylesheet" href="" {{asset('css/coderay.css')}}>
         <style type="text/css">
           body.dragging, body.dragging * {
              cursor: move !important;
            }

            .dragged {
              position: absolute;
              opacity: 0.7;
              z-index: 2000;              
            }

            .draggable-menu {
              padding: 0 0 0 0;
              margin:0 0 0 0;
            }

            .draggable-menu li ul {
              margin-top:6px;
            }
  
            .draggable-menu li div {
              padding:5px;
              border:1px solid #cccccc;
              background:#eeeeee;
              cursor: move;
            }

            .draggable-menu li .is-dashboard {
              background: #fff6e0;              
            }  

            .draggable-menu li .icon-is-dashboard {
              color: #ffb600;
            }

            .draggable-menu li {
              list-style-type:none;                            
              margin-bottom:4px;
              min-height: 35px;
            }

            .draggable-menu li.placeholder {
              position: relative;
              border:1px dashed #b7042c;
              background:#ffffff;
              /** More li styles **/
            }
            .draggable-menu li.placeholder:before {
              position: absolute;
              /** Define arrowhead **/
			  color:red;
            }
			
			

            .draggable-number {
              padding: 0 0 0 0;
              margin:0 0 0 0;
            }

            .draggable-number li ul {
              margin-top:6px;
            }
  
            .draggable-number li div {
              padding:5px;
              border:1px solid #cccccc;
              background:#eeeeee;
              cursor: move;

            }

            .draggable-number li .is-dashboard {
              background: #fff6e0;              
            }  

            .draggable-number li .icon-is-dashboard {
              color: #ffb600;
            }

            .draggable-number li {
              list-style-type:none;                            
              margin-bottom:4px;
              min-height: 35px;
            }

            .draggable-number li.placeholder {
              position: relative;
              border:1px dashed #b7042c;
              background:#ffffff;
              /** More li styles **/
            }
            .draggable-number li.placeholder:before {
              position: absolute;
              /** Define arrowhead **/
			  color:red;
            }			
         </style>
         <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script>
  <script type="text/javascript">
  
           $(function  () {
            var id_app_encuentro 	= {{$id_app_encuentro}};
			var id_app_equipo 		= {{$id_app_equipo}};
            var sortactive = $(".draggable-menu").sortable({
              group: '.draggable-menu',  
              delay:200,               
              isValidTarget: function ($item, container) {
                  var depth = 1, // Start with a depth of one (the element itself)
                      maxDepth = 2,
                      children = $item.find('ul').first().find('li');

                  // Add the amount of parents to the depth
                  depth += container.el.parents('ul').length;

                  // Increment the depth for each time a child
                  while (children.length) {
                      depth++;
                      children = children.find('ul').first().find('li');
                  }

                  return depth <= maxDepth;
              },                       
              onDrop: function ($item, container, _super) {                                                    

                if($item.parents('ul').hasClass('draggable-menu-active')) {
                  var isActive = 1;
                  var data = $('.draggable-menu-active').sortable("serialize").get();
				  $('.draggable-menu-inactive').css("color", "blue");
				  
				  
                  var jsonString = JSON.stringify(data, null, ' '); 
				  var idLeft = $item.attr("data-id");
				    alert(idLeft);
					$.post("{{route('AdminAppEncuentroxplantillaControllerPostAddSaveTemplate')}}",{id_app_equipo:id_app_equipo, id_app_encuentro: id_app_encuentro, id_app_jugador:idLeft},function(resp) {
						$('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
					});
					//$('.draggable-menu-active').css("color", "red");
					
					//$('.draggable-menu-active').sortable("refresh")
					$('#inactive_text').remove();
                }else{
				
                  var isActive = 0;
                  var dataInactive = $('.draggable-menu-inactive').sortable("serialize").get();
                  var jsonString = JSON.stringify(data, null, ' ');
				  //$('.draggable-menu-inactive').css("color", "red");
				   var idRight = $item.attr("data-id");
				  alert(idRight);
				  //alert(JSON.stringify(dataInactive));
				  
				  //<i class='icon-is-dashboard fa fa-dashboard'></i> #1  <button class="delete">Delete</button>
					$.post("{{route('AdminAppEncuentroxplantillaControllerPostDeleteSaveTemplate')}}",{id_app_equipo:id_app_equipo, id_app_encuentro: id_app_encuentro, id_app_jugador:idRight},function(resp) {
						$('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
					});
					
                  $('#inactive_text').remove();
                }
				 
				//alert(jsonString);
                /*$.post("{{route('AdminAppPlantillaxjugadorControllerPostSaveTemplate')}}",{plantilla:jsonString,plantillaid:id_app_plantilla},function(resp) {
                  $('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
                });*/
				//$('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
				
                _super($item, container);
              }
            });    



          });
		  $("#draggable-menu-active .delete").click(function() { 
			$(this).parent().remove();
		});
         </script>
		 
   
   
   <script type="text/javascript">
   /*
   $(function  () {
	  var adjustment;

			$("ol.simple_with_animation").sortable({
			  group: 'simple_with_animation',
			  pullPlaceholder: false,
			  // animation on drop
			  onDrop: function  ($item, container, _super) {
				var $clonedItem = $('<li/>').css({height: 0});
				$item.before($clonedItem);
				$clonedItem.animate({'height': $item.height()});

				$item.animate($clonedItem.position(), function  () {
				  $clonedItem.detach();
				  _super($item, container);
				});
				
				var data = $('ol.simple_with_animation').sortable("serialize").get();
                  var jsonString = JSON.stringify(data, null, ' ');
				 // alert( jsonString);
			  },

		  // set $item relative to cursor position
		  onDragStart: function ($item, container, _super) {
			var offset = $item.offset(),
				pointer = container.rootGroup.pointer;

			adjustment = {
			  left: pointer.left - offset.left,
			  top: pointer.top - offset.top
			};

			_super($item, container);
		  },
		  onDrag: function ($item, position) {
			$item.css({
			  left: position.left - adjustment.left,
			  top: position.top - adjustment.top
			});
		  }
		});
	});
	*/
  </script>
  
	<div class='row'>

         
            <div class='col-sm-12'>
			{{$app_id_encuentro}}
              <form method='get' action='' id='form-privilege'>
				<input type="hidden" name="parent_id" value="{{$id_app_encuentro}}">
				<input type="hidden" name="app_id_encuentro" value="{{$app_id_encuentro}}">				
                <div class='form-group'>
                <label class='label-control'>Plantillas Disponibles </label>
					<select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_equipo'>
						@foreach($app_equipo as $e)
						  <option value='{{$e->id}}' {{($id_app_equipo == $e->id)?"selected":""}}>{{$e->desNombre}}</option>
						@endforeach
					</select>
					<select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_plantilla'>
						@foreach($app_plantilla as $p)
							<option value='{{$p->id}}' {{($id_app_plantilla == $p->id)?"selected":""}}>{{$p->desPlantilla}}</option>
						@endforeach
					</select>
                </div>
				
              </form>
			  
			   <form method='post' target="_blank" action='{{ CRUDBooster::mainpath("export-pdf?t=".time()) }}'> 
					<input type="hidden" name="_token" value="{{ csrf_token() }}">
					<input type="hidden" name="app_id_equipo" value="{{$id_app_equipo}}">
					<input type="hidden" name="app_id_encuentro" value="{{$app_id_encuentro}}">
					{!! CRUDBooster::getUrlParameters() !!}
					<button class="btn btn-primary btn-success" type="Descargar PDF">Descargar PDF</button>
			   </form>
            </div>
    
		

			
		<div class="col-sm-5">
			<div class="panel panel-success">
				<div class="panel-heading">
                    <strong>Jugadores seleccionados</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Actualizando !</span>
                </div>
			</div>
			
		
			
			<div class="panel-body clearfix">
				<ol class="simple_with_animation vertical">
				<ul class='draggable-menu draggable-menu-active'>
					@foreach($jugadoresxencuentro as $c)
					
					<li data-id='{{$c->id}}' data-name='{{$c->desNombre}}'>
						<div class='{{$menu->is_dashboard?"is-dashboard":""}}' title="{{$menu->is_dashboard?'This is setted as Dashboard':''}}">
							<i class='{{($menu->is_dashboard)?"icon-is-dashboard fa fa-dashboard":$menu->icon}}'></i> {{$c->desApellidoPaterno}} {{$c->desNombre}} 
						</div>
					</li>
					@endforeach	
				</ul>
				</ol>
			</div>
		</div>
	
		<div class="col-sm-5">
			<div class="panel panel-success">
				<div class="panel-heading">
                    <strong>Jugadores disponibles</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Actualizando !</span>
                </div>
			</div>
			 
			 
			<div class="panel-body clearfix">
				<ol class="simple_with_animation vertical">
				<ul class='draggable-menu draggable-menu-inactive'>
					@foreach($jugadoresFederados as $c)
					<li data-id='{{$c->id}}' data-name='{{$c->desNombre}}'>
						<div class='{{$menu->is_dashboard?"is-dashboard":""}}' title="{{$menu->is_dashboard?'This is setted as Dashboard':''}}">
							<i class='{{($menu->is_dashboard)?"icon-is-dashboard fa fa-dashboard":$menu->icon}}'></i> {{$c->desApellidoPaterno}} {{$c->desNombre}} 
						</div>
					</li>
					@endforeach
				</ul>
				</ol>
			</div>
		</div>		
	</div>
	<!--
	<div class="panel-body clearfix">
		<ol class="simple_with_animation vertical">
        <ul class='draggable-menu draggable-menu-active'>
			
			<li>
				<div class='{{$menu->is_dashboard?"is-dashboard":""}}' title="{{$menu->is_dashboard?'This is setted as Dashboard':''}}">
                    <i class='{{($menu->is_dashboard)?"icon-is-dashboard fa fa-dashboard":$menu->icon}}'></i> 
						
					</div>
			</li>
			
		</ul>
		</ol>
	</div>	
		
	<div class='row'>
		<div class="span4">
			<ol class="simple_with_animation vertical">
                
			</ol>
		</div>
		<div class="span4">
			<ol class="simple_with_animation vertical">
			</ol>
		</div>
	</div>
	-->
	<!--END AUTO MARGIN-->

@endsection