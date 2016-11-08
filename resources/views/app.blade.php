<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Hall Booking</title>

	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

	<!-- bootsrap links, move to local later -->

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="<?php echo asset('css/bootstrap.min.css')?>" type="text/css"> 

	<!-- Optional theme -->
	<link rel="stylesheet" href="<?php echo asset('css/bootstrap-theme.min.css')?>" type="text/css"> 


	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>

<style type="text/css">
	.checkbox {
  		padding-left: 20px; 
  		}
	.checkbox label {
    	display: inline-block;
    	position: relative;
    	padding-left: 5px; 
    	}
    .checkbox label::before {
    	content: "";
    	display: inline-block;
    	position: absolute;
    	width: 17px;
    	height: 17px;
    	left: 0;
    	margin-left: -20px;
    	border: 1px solid #cccccc;
     	border-radius: 3px;
     	background-color: #fff;
      	-webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
      	-o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
      	transition: border 0.15s ease-in-out, color 0.15s ease-in-out; 
      	}
    .checkbox label::after {
    	display: inline-block;
      	position: absolute;
      	width: 16px;
      	height: 16px;
      	left: 0;
      	top: 0;
      	margin-left: -20px;
      	padding-left: 3px;
      	padding-top: 1px;
      	font-size: 11px;
      	color: #555555; 
      	}
	.checkbox input[type="checkbox"] {
    	opacity: 0; 
    	}
    .checkbox input[type="checkbox"]:focus + label::before {
      	outline: thin dotted;
      	outline: 5px auto -webkit-focus-ring-color;
      	outline-offset: -2px; 
      	}
    .checkbox input[type="checkbox"]:checked + label::after {
      	font-family: 'FontAwesome';
      	content: "\f00c"; 
      	}
    .checkbox input[type="checkbox"]:disabled + label {
      	opacity: 0.65; 
      	}
    .checkbox input[type="checkbox"]:disabled + label::before {
        background-color: #eeeeee;
        cursor: not-allowed; 
        }
	.checkbox.checkbox-circle label::before {
    	border-radius: 50%; 
    	}
	.checkbox.checkbox-inline {
    	margin-top: 0; 
    	}

	.checkbox-primary input[type="checkbox"]:checked + label::before {
  		background-color: #428bca;
  		border-color: #428bca; 
  		}
	.checkbox-primary input[type="checkbox"]:checked + label::after {
  		color: #fff; 
  		}

	.checkbox-danger input[type="checkbox"]:checked + label::before {
		background-color: #d9534f;
  		border-color: #d9534f; 
  	}
	.checkbox-danger input[type="checkbox"]:checked + label::after {
	  	color: #fff; 
	}
	.checkbox-info input[type="checkbox"]:checked + label::before {
	  	background-color: #5bc0de;
	  	border-color: #5bc0de; 
	}
	.checkbox-info input[type="checkbox"]:checked + label::after {
	  	color: #fff; 
	}

	.checkbox-warning input[type="checkbox"]:checked + label::before {
		background-color: #f0ad4e;
	  	border-color: #f0ad4e; 
	}
	.checkbox-warning input[type="checkbox"]:checked + label::after {
		color: #fff; 
	}

	.checkbox-success input[type="checkbox"]:checked + label::before {
		background-color: #5cb85c;
		border-color: #5cb85c; 
	}
	.checkbox-success input[type="checkbox"]:checked + label::after {
		color: #fff; 
	}
</style>

<body>
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">Hall Booking</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<!-- <ul class="nav navbar-nav">
					<li><a href="/">Home</a></li>
				</ul> -->

				<ul class="nav navbar-nav navbar-right">
					@if (!session()->has('user'))
						<li><a href="/auth/login">Login</a></li>
						<!-- <li><a href="/auth/register">Register</a></li> -->
					@else
					@if (session()->get('user') == 'admin')
						<li><a href="/admin/myHalls">My Halls</a></li>
						<li><a href="/admin/book">Book</a></li>
					@else 
						<li><a href="/myHalls">My Halls</a></li>
						<li><a href="/book">Book</a></li>
					@endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ session()->get('user') }}<span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<!-- <li><a href="/auth/logout">Logout</a></li> -->
								<li><a href="/auth/logout">Logout</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>

	@yield('content')

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
</body>
</html>	