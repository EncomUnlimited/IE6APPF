<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>Faceboot - A Facebook style template for Bootstrap</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    {{HTML::style('/css/bootstrap.min.css')}}
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
    {{HTML::style('/css/styles.css')}}
    {{HTML::style('/css/font-awesome.min.css')}}
    {{HTML::style('/css/bootstrap-social.css')}}
    
	</head>
	<body>
<div class="wrapper">
    <div class="box">
        <div class="row row-offcanvas row-offcanvas-left">
                      
          

          
            @yield('content')



	<!-- script references -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
    {{HTML::script('/js/jquery-fileupload.js')}}
		<script src="js/bootstrap.min.js"></script>
		<script src="js/scripts.js"></script>
    @yield('footerScripts')
	</body>
</html>