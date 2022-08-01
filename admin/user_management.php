<?php include_once('include/header.php'); ?>
<?php    $users = $db->fetch_record_by_order('users', Null,'order by id desc');?>
<div class="content-wrapper">
   <section class="content-header">
      <h1>Users<small>Management</small></h1>
      <ol class="breadcrumb">
        <li><a href="<?=ADMIN_URL?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Users</li>
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
                  <h3 class="box-title">Users</h3>
                  
                  
               </div>
               <div class="box-body">
                  <table class="table DataTable table-hover">
                     <thead>
                        <tr>
                           <th>S.NO.</th>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Mobile Number</th>
                           <th>Status</th>
                           <th>Joined</th>
                           <th>Action</th>
                          
                        </tr>
                     </thead>
                     <tbody>

                        <?php 

                        if(!empty($users)){
                           foreach($users as $key => $user){?>                      
                        <tr>
                           <td><?=$key + 1;?></td>
                           <td><?=$user['name'];?></td>
                           <td><?=$user['email'];?></td>
                           <td><?=$user['mobile_number'];?></td>
                           <td>
                              <?php 
                              if($user['status']==0){ ?>
                                 <a class="btn btn-success btn-xs" onclick="return confirm('Are you sure you want to deactive this User?')" href="<?=ADMIN_URL.'process/process.php?action=change_user_status&act=1&id='.$user['id']; ?>">Active</a>
                                 <?php }else{
                                 ?><a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to active this User?')" href="<?=ADMIN_URL.'process/process.php?action=change_user_status&act=0&id='.$user['id']; ?>">Deactive</a><?php }
                              ?></td>
                           <td><?=date("d M Y", strtotime($user['cdate']));?></td>
                           <td><a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this User?')" href="<?=ADMIN_URL.'process/process.php?action=delete_user&id='.$user['id']; ?>"><i class="fa fa-trash"></i></a></td>
                           
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


<?php include_once('include/footer.php'); ?>


