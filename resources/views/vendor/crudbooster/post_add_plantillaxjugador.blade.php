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
            }
         </style>
         <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script>
  <script type="text/javascript">
  
           $(function  () {
            var id_app_plantilla = {{$id_app_plantilla}};
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
                  var jsonString = JSON.stringify(data, null, ' '); 
                }else{
                  var isActive = 0;
                  var data = $('.draggable-menu-inactive').sortable("serialize").get();
                  var jsonString = JSON.stringify(data, null, ' ');
                  $('#inactive_text').remove();
                }
				//alert(jsonString);
                $.post("{{route('AdminAppPlantillaxjugadorControllerPostSaveTemplate')}}",{plantilla:jsonString,plantillaid:id_app_plantilla},function(resp) {
                  $('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
                });
				
				
                _super($item, container);
              }
            });    



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

              <form method='get' action='' id='form-privilege'>
                <div class='form-group'>
					<label class='label-control'>Plantillas Disponibles</label>
					<select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_plantilla'>                  
						@foreach($plantilla as $p)
						  <option value='{{$p->id}}' {{($id_app_plantilla == $p->id)?"selected":""}}>{{$p->desPlantilla}}</option>
						@endforeach
					</select>
					<label class='label-control'>Mostrar todos los jugadores</label>
                </div>
              </form>
            </div>
    </div>        
	<div class='row'>
		<div class="col-sm-5">
			<div class="panel panel-success">
				<div class="panel-heading">
                    <strong>Listado de Jugadores Disponibles</strong> 
					<span id='menu-saved-info' style="display:none" class='pull-right text-success'>
						<i class='fa fa-check'></i> Actualizando !
					</span>
                </div>
				<div class="panel-body clearfix">
					<ol class="simple_with_animation vertical">
					<ul class='draggable-menu draggable-menu-active'>
						@foreach($jugadores as $c)
						<li data-id='{{$c->id}}' data-name='{{$c->desNombre}}'>
							<div class='' title="{{$c->desApellidoPaterno}} {{$c->desNombre}} ">
								<i class='fa fa-user'></i>
								{{$c->desApellidoPaterno}} {{$c->desNombre}} 
							</div>
						</li>
						@endforeach
					</ul>
					</ol>
				</div>
			</div>
		</div>	

		<div class="col-sm-7">
			<div class="panel panel-success">
				<div class="panel-heading">
                    <strong>Jugadores seleccionados</strong> 
					<span id='menu-saved-info' style="display:none" class='pull-right text-success'>
						<i class='fa fa-check'></i> Actualizando !
					</span>
                </div>
			
			<div class="panel-body clearfix">
				<ol class="simple_with_animation vertical">
				<ul class='draggable-menu draggable-menu-active'>
					
					@foreach($plantillaxjugador as $pj)
					<li data-id='{{$pj->id}}' data-name='{{$pj->desNombre}}'>
						<div class='' title="{{$pj->desApellidoPaterno}} {{$pj->desNombre}}">
							<i class='fa fa-user'></i> {{$pj->desApellidoPaterno}} {{$pj->desNombre}}   
							
						</div>
					</li>
					@endforeach
					
				</ul>
				</ol>
			</div>
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