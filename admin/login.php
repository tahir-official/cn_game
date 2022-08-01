<?php 
   include_once('include/function.php');
   $db= new functions();
   if(isset($_SESSION['is_admin_logged_id']))
   {
   	$db->redirect('index.php');
   }
   ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title><?php echo Project; ?></title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
	<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
	<link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">

	<link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
	
	<link rel="stylesheet" href="bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
	
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	<link rel="stylesheet" href="custom/style.css">
</head>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-logo">
				<img src="img/logo.png" style="width: 150px;"  alt="Mokia Club">
				<!-- <a href="index.php"><b>Color</b>App</a> -->
			</div>
			<?php
            if(isset($_SESSION['success']))
            {
            	echo $_SESSION['success'];
            	unset($_SESSION['success']);
            }
            if(isset($_SESSION['error']))
            {
            	echo $_SESSION['error'];
            	unset($_SESSION['error']);
            }
            ?>
			<!-- /.login-logo -->
			<div class="login-box-body">
				<!-- <p class="login-box-msg">Sign in to start your session</p> -->
				<form role="form" id="login_form" action="process/process.php?action=login" method="post">
					<div class="form-group">
						<label>Email address</label>
						<input type="email" class="form-control" name="email" id="email">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" class="form-control" name="password" id="password">
					</div>
					<div class="checkbox">
						<!-- <label class="pull-right">
							<a href="#">Forgotten Password?</a>
						</label> -->
					</div>
					<button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
					
					
				</form>
			</div>
		</div>
		<script src="bower_components/jquery/dist/jquery.min.js"></script>
		<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>

		<script src="dist/js/adminlte.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.js"></script>
		<script src="custom/custom.js"></script>
	</body>
</html>