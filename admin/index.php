<?php include_once('include/header.php'); 
$users=$db->fetch_record('users');
$bid=$db->fetch_record('bid');
$contact_requests=$db->fetch_record('contact_requests');
?> 
<div class="content-wrapper">
	<section class="content-header">
		<h1>Dashboard<small>Control panel</small></h1>
		<ol class="breadcrumb">
			<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Dashboard</li>
		</ol>
   </section>
   
   <!-- Main content -->
   <section class="content">
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
		<!-- ./col -->
			
		<!-- Small boxes (Stat box) -->
		<div class="row">
			<div class="col-lg-3 col-xs-6">
			<!-- small box -->
				<div class="small-box bg-yellow">
					<div class="inner">
						<h3><?=count($users)?></h3>
						<p>User Registrations</p>
					</div>
					<div class="icon">
						<i class="ion ion-person-add"></i>
					</div>
					<a href="user_management.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?=count($bid)?></h3>
						<p>Bids</p>
					</div>
					<div class="icon">
						<i class="ion ion-stats-bars"></i>
					</div>
						<a href="bid_list.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
					</div>
			</div>
			<div class="col-lg-3 col-xs-6">
				<!-- small box -->
				<div class="small-box bg-red">
					<div class="inner">
						<h3><?=count($contact_requests)?></h3>
						<p>Contact Requests</p>
					</div>
					<div class="icon">
						<i class="ion ion-pie-graph"></i>
					</div>
					<a href="contact_management.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
				</div>
			</div>
			<!-- ./col -->
			
			
			<!-- ./col -->
			
			<!-- ./col -->
		</div>
			<!-- /.row -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once('include/footer.php'); ?>