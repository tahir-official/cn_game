<aside class="main-sidebar">
	<section class="sidebar" style="height: auto;">
		<!-- Sidebar user panel -->
		<div class="user-panel" style="height: 63px;">
			<div class="text-center info">
				<p><?php echo $admin_data['admin_name'] ?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div>
		<!-- sidebar menu: : style can be found in sidebar.less -->
		<ul class="sidebar-menu" data-widget="tree">
			<li class="header">MAIN NAVIGATION</li>
				<li class="active">
				<a href="index.php">
					<i class="fa fa-dashboard"></i> <span>Dashboard</span>
				</a>
			</li>
			<li>
            <a href="user_management.php">
              <i class="fa fa-users"></i><span> Users Management </span>
            </a>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-gavel"></i>
              <span>Bid Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="bid_list.php"><i class="fa fa-circle-o"></i> Bid List</a></li>
              
            </ul>
          </li>


          <li>
            <a href="contact_management.php">
              <i class="fa fa-address-card"></i><span> Contacts Management </span>
            </a>
          </li>

           <li class="treeview">
            <a href="#">
              <i class="fa fa-file"></i>
              <span>Page Contents Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
             
              <li><a href="about_us_management.php"><i class="fa fa-circle-o"></i> About Us</a></li>
              <li><a href="terms_conditions_management.php"><i class="fa fa-circle-o"></i> Terms and conditions</a></li>
              <li><a href="privacy_policy_management.php"><i class="fa fa-circle-o"></i> Privacy Policy</a></li>
              
            </ul>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa fa-home"></i>
              <span>Home Page Management</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="home_page_management.php"><i class="fa fa-circle-o"></i> Home Page Section</a></li>
              <li><a href="app_stores.php"><i class="fa fa-circle-o"></i> Application Stores Management</a></li>
              <li><a href="other_content.php"><i class="fa fa-circle-o"></i> Other Content Management</a></li>
            </ul>
          </li>


           <li>
            <a href="social_management.php">
              <i class="fa fa-link"></i><span> Social Link Management </span>
            </a>
          </li>



			
		</ul>
	</section>
</aside>