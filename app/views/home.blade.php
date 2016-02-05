@extends('layout')
@section('content')
<!-- main right col -->
            <div class="column col-sm-12 col-xs-12" id="main">
                
                <!-- top nav -->
              	<div class="navbar navbar-blue navbar-static-top">  
                    <div class="navbar-header">
                      <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle</span>
                        <span class="icon-bar"></span>
          				<span class="icon-bar"></span>
          				<span class="icon-bar"></span>
                      </button>
                      <a href="/" class="navbar-brand logo">b</a>
                  	</div>
                  	<nav class="collapse navbar-collapse" role="navigation">
                    <form class="navbar-form navbar-left">
                        <div class="input-group input-group-sm" style="max-width:360px;">
                          <input type="text" class="form-control" placeholder="Search" name="srch-term" id="srch-term">
                          <div class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                          </div>
                        </div>
                    </form>
                    <ul class="nav navbar-nav">
                      <li>
                        <a href="#"><i class="glyphicon glyphicon-home"></i> Home</a>
                      </li>
                      <li>
                        <a href="#postModal" role="button" data-toggle="modal"><i class="glyphicon glyphicon-plus"></i> Post</a>
                      </li>
                      <li>
                        <a href="#"><span class="badge">badge</span></a>
                      </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
                        <ul class="dropdown-menu">
                          <li><a href="">More</a></li>
                          <li><a href="">More</a></li>
                          <li><a href="">More</a></li>
                          <li><a href="">More</a></li>
                          <li><a href="">More</a></li>
                        </ul>
                      </li>
                    </ul>
                  	</nav>
                </div>
                <!-- /top nav -->
              
                <div class="padding">
                    <div class="full col-sm-9">
                      
                        <!-- content -->                      
                      	<div class="row">
                          <div class="col-sm-3"></div>
                         <!-- main col left --> 
                         <div class="col-sm-6">
                              @if(Session::has('mensaje'))
                              <div class="alert alert-info">{{Session::get('mensaje')}}</div>
                              @endif
                              <div class="well"> 
                                   <form class="form-horizontal" action="{{URL::to('upload')}}" id="publish" role="form">
                                    <h4>¿Que hay de nuevo?</h4>
                                     <div class="form-group" style="padding:14px;">
                                      <textarea class="form-control" name="quePiensas" id="quePiensas" placeholder="Actualiza tu estado"></textarea>
                                      <input type="file" class="hide form-control" id="photo" name="photo" />
									                    <input type="hidden" name="publish" value="me" />
                                    </div>
                                    <div class="form-group">
                                      <div class="contenedor hide" id="contenedor">
                                        <div class="loader" id="loader">Loading...</div>
                                      </div>
                                      <div class="contenedor hide" id="upPhoto">

                                      </div>
                                    	<input class="btn btn-primary pull-right" value="Publicar" type="submit" /><ul class="list-inline"><li><a href=""><i class="glyphicon glyphicon-upload"></i></a></li><li><a id="openPhoto" href="#"><i class="glyphicon glyphicon-camera"></i></a></li><li><a href=""><i class="glyphicon glyphicon-map-marker"></i></a></li></ul>
                                  	</div>
                                  </form>
                              </div>

                           		
                           
                          </div>
                          <div class="col-sm-3"></div>
                       </div><!--/row-->
                      
                        <div class="row">
                          <div class="col-sm-6">
                            <a href="#">Twitter</a> <small class="text-muted">|</small> <a href="#">Facebook</a> <small class="text-muted">|</small> <a href="#">Google+</a>
                          </div>
                        </div>
                      
                        <div class="row" id="footer">    
                          <div class="col-sm-6">
                            
                          </div>
                          <div class="col-sm-6">
                            <p>
                            <a href="#" class="pull-right">©Copyright 2013</a>
                            </p>
                          </div>
                        </div>
                      
                      <hr>
                      
                      <h4 class="text-center">
                      <a href="http://bootply.com/96266" target="ext">Download this Template @Bootply</a>
                      </h4>
                        
                      <hr>
                        
                      
                    </div><!-- /col-9 -->
                </div><!-- /padding -->
            </div>
            <!-- /main -->
          
        </div>
    </div>
</div>

@if(!Session::has('fb_access_token'))
<!--post modal-->
<div id="postModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			Iniciar sesion
      </div>
      <div class="modal-body">
            <div class="form-group">
              <a class="btn btn-block btn-social btn-facebook" href="{{$loginUrl}}">
        				<span class="fa fa-facebook"></span> Iniciar sesion con Facebook
        			</a>
            </div>
      </div>
  </div>
  </div>
</div>
@endif
@stop
@section('footerScripts')
@if(!Session::has('fb_access_token'))
<script>
	$(document).ready(function(){
		$('#publish').on('click',function(){$('#postModal').modal()})
		$('textarea[name="quePiensas"').on('click',function(){$('#postModal').modal()})
		$('input[value="Publicar"]').on('click',function(e){e.preventDefault();$('#postModal').modal()})
	});
</script>
@else
<script>
$(document).ready(function(){
	var up = $('#publish').fileUpload({
	    before        : function(){
	    	$('input[value="Publicar"]').prop("disabled", true);
        $('#contenedor').removeClass('hide');
	    }, // Run stuff before the upload happens
	    beforeSubmit  : function(uploadData){ 
        console.log(uploadData); 
        $('#contenedor').addClass('hide'); 
        $('input[value="Publicar"]').prop("disabled", false);
         $('#upPhoto').append($('<img/>').attr({'src':uploadData.photo,'width':'100px','height':'100px'})).removeClass('hide');
        }, // access the data returned by the upload return false to stop the submit ajax call
	    success       : function(data, textStatus, jqXHR){ 
        console.log(data);
        $('#contenedor').addClass('hide'); 
        $('input[value="Publicar"]').prop("disabled", false);
        
        }, // Callback for the submit success ajax call
	    error         : function(jqXHR, textStatus, errorThrown){ 
        console.log(jqXHR); 
        $('#contenedor').addClass('hide');
      }, // Callback if an error happens with your upload call or the submit call
	    complete      : function(jqXHR, textStatus){
        $('#contenedor').addClass('hide'); 
        $('input[value="Publicar"]').prop("disabled", false);
        
      } // Callback on completion
	});
	$('#openPhoto').on('click',function(){
		$('#photo').click().on('change',function(){
      up.submit();
    });

	});
  $('input[value="Publicar"]').on('click',function(e){
    if($('textarea[name="quePiensas"').val()=='') return false;
    e.preventDefault();
   var send =  $('<form/>').append($('<input/>').attr({'type':'text','name':'quePiensas','value':$('textarea[name="quePiensas"').val()})).attr({'method':'post','action':'{{URL::to("publish")}}','class':'hide','id':'sendPublication'});
  $('body').append(send);
  $('#sendPublication').submit();
  $('#sendPublication').remove();
  });
});
</script>
@endif
@stop