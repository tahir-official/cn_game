<?php include_once('include/header.php'); ?> 
<?php
 
  $requests = $db->fetch_record_by_order('contact_requests',NULL,'order by id desc');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>User<small>Contact Requests</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?=ADMIN_URL?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Contact Requests</li>
    </ol>
  </section>
   
  <!-- Main content -->
  <section class="content">
    <?php if(isset($_SESSION['message'])){echo $_SESSION['message']; unset($_SESSION['message']);}?>
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Queries</h3>
            
          </div>
   
          <div class="box-body">

            <table class="table DataTable table-hover">
              <thead>
                <tr>
                  <th>S.NO.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Message</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if(!empty($requests)){
                    foreach($requests as $key => $request){
                ?>
                      <tr>
                        <td>
                          <div class="pull-left">
                            <?=$key + 1;?>
                          </div>
                          <div class="pull-right">
                            <?php
                              if($request['is_replied'] == 1){
                            ?>
                                <i class="fa fa-check" aria-hidden="true"></i> 
                            <?php
                              }
                            ?>
                          </div>
                        </td>
                        <td><?=$request['name'];?></td>
                        <td><?=$request['email'];?></td>
                        <td><?=$request['phone'];?></td>
                        <td><?=$request['query'];?></td>
                        <td>
                         
                          <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this Contact Request?')" href="<?=ADMIN_URL.'process/process.php?action=delete_contact_request&id='.$request['id']; ?>"><i class="fa fa-trash"></i></a>
                        </td>
                      </tr>
                      
                <?php
                    }
                  }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
      <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php include_once('include/footer.php'); ?>
