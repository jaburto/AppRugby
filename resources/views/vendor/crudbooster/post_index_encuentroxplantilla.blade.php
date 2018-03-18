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

			.jugadorTitular{
				color:blue;
			}
			.jugadorNS{
				color:black;
			}
			.jugadorSuplente{
				color:red;
			}
			.numberCircle {
				border-radius: 50%;
				width: 25px;
				font-size: 12px;
				border: 2px solid #666;
				display: inline-block;
			}
			.numberCircle span {
				text-align: center;
				line-height: 12px;
				display: block;
			}
        </style>
        <script src='{{asset("vendor/crudbooster/assets/jquery-sortable-min.js")}}'></script>
		<script type="text/javascript">


		function UpdateList(){
			$( ".draggable-menu-active li" ).each(function( index ) {
				if(index+1<=15)
				{
					$( this ).find('span').html(index+1);
					$( this ).find('span').removeClass();
					$( this ).find('span').addClass('jugadorTitular');

				}else{
					$( this ).find('span').html(index+1);
					$( this ).find('span').removeClass();
					$( this ).find('span').addClass('jugadorSuplente');
				}
			});
			$( ".draggable-menu-inactive li" ).each(function( index ) {
				$( this ).find('span').html('X');
				$( this ).find('span').removeClass();
				$( this ).find('span').addClass('jugadorNS');

			});
		}
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
				$(this).sortable('cancel');
				//event.preventDefault();
				//return false;
                if($item.parents('ul').hasClass('draggable-menu-active')) {
                  var isActive = 1;
                  var data = $('.draggable-menu-active').sortable("serialize").get();

                  var jsonString = JSON.stringify(data, null, ' ');
				  var idLeft = $item.attr("data-id");

					$.post("{{route('AdminAppEncuentroxplantillaControllerPostSaveTemplate')}}",{plantilla:jsonString,id_app_equipo:id_app_equipo, id_app_encuentro: id_app_encuentro, id_app_jugador:idRight},function(resp) {
						$('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
					});
					UpdateList();
					$('#inactive_text').remove();
                }else{

                  var isActive = 0;
                  //var dataInactive = $('.draggable-menu-inactive').sortable("serialize").get();
				  var data = $('.draggable-menu-active').sortable("serialize").get();
                  var jsonString = JSON.stringify(data, null, ' ');
				  var idRight = $item.attr("data-id");

					$.post("{{route('AdminAppEncuentroxplantillaControllerPostSaveTemplate')}}",{plantilla:jsonString,id_app_equipo:id_app_equipo, id_app_encuentro: id_app_encuentro, id_app_jugador:idRight},function(resp) {
						$('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
					});
					UpdateList();

                  $('#inactive_text').remove();
                }


                /*$.post("{{route('AdminAppPlantillaxjugadorControllerPostSaveTemplate')}}",{plantilla:jsonString,plantillaid:id_app_plantilla},function(resp) {
                  $('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');
                });*/
				//$('#menu-saved-info').fadeIn('fast').delay(1000).fadeOut('fast');

                _super($item, container);
              }
            });


			UpdateList();
          });
		  $("#draggable-menu-active .delete").click(function() {
			$(this).parent().remove();
		});

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
						  <option value='{{$e->id}}' {{($id_app_equipo == $e->id)?"selected":""}}>{{$e->desnombre}}</option>
						@endforeach
					</select>
					<select class='form-control' onChange="$('#form-privilege').submit()" name='id_app_plantilla'>
						@foreach($app_plantilla as $p)
							<option value='{{$p->id}}' {{($id_app_plantilla == $p->id)?"selected":""}}>{{$p->desplantilla}}</option>
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


	</div>
	<div class='row'>
		<div class="col-sm-5">
			<div class="panel panel-success">
				<div class="panel-heading">
                    <strong>Jugadores seleccionados</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Actualizando !</span>
                </div>
			<div class="panel-body clearfix">
				<ol class="simple_with_animation vertical">
				<ul class='draggable-menu draggable-menu-inactive'>

						@foreach($jugadoresFederados as $c)
						<li data-id='{{$c->id}}' data-name='{{$c->desnombre}}'>
							<div class='' title="">
								<div class="numberCircle"><span>X</span></div>
								<i class='fa fa-user'></i>
								{{$c->desapellidopaterno}} {{$c->desnombre}}
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
                    <strong>Jugadores disponibles</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Actualizando !</span>
                </div>
				<div class="panel-body clearfix">
					<ol class="simple_with_animation vertical">
					<ul class='draggable-menu draggable-menu-active'>
					@foreach($jugadoresxencuentro as $c)

					<li data-id='{{$c->id}}' data-name='{{$c->desnombre}}'>
						<div class='' title="">
							<div class="numberCircle"><span>1</span></div>
							<i class='fa fa-user'></i>
							{{$c->desApellidopaterno}} {{$c->desnombre}}
						</div>
					</li>
					@endforeach
					</ul>
					</ol>
				</div>
			</div>
		</div>
	</div>
	<!--END AUTO MARGIN-->

@endsection
