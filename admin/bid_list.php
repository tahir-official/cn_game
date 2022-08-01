<?php include_once('include/header.php'); ?> 
<?php
  $bid_lists = $db->fetch_record_by_order('bid',NULL,'order by id Desc');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Bid<small>List</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?=ADMIN_URL?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Bid List</li>
    </ol>
  </section>
   
  <!-- Main content -->
  <section class="content">
    <?php
      if(isset($_SESSION['message'])){
        echo $_SESSION['message'];
        unset($_SESSION['message']);
      }
      
    ?>
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Bid List</h3>
             <div class="pull-right" style="background: green;color: white;padding: 3px 50px 3px 50px;">
              
              <p ><span id="mins"></span><span id="secs"></span></p>
              <h5 id="end"></h5>
              <script>
              
              var countDownDate = new Date("<?=date('M d, Y H:i:s',strtotime($bid_lists[0]['end_datetime']))?>").getTime();

              
              var myfunc = setInterval(function() {

              var now = new Date().getTime();
              var timeleft = countDownDate - now;
              
              var minutes = Math.floor((timeleft % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((timeleft % (1000 * 60)) / 1000);
              
              document.getElementById("mins").innerHTML = minutes + "m " 
              document.getElementById("secs").innerHTML = ": "+seconds + "s " 
              
              if (timeleft < 0) {
                  clearInterval(myfunc);
                  
                  document.getElementById("mins").innerHTML = ""
                  document.getElementById("secs").innerHTML = ""
                  document.getElementById("end").innerHTML = "TIME UP!!";
                  location.reload();
              }
              }, 1000);
              </script>
              
            </div> 
          </div>
   
          <div class="box-body">

            <table class="table DataTable table-hover">
              <thead>
                <tr>
                  <th>S.NO.</th>
                  <th>Bid Number</th>
                  <th>Created</th>
                  <th>End Time</th>
                  <th>Status</th>
                  <th>Color Result</th>
                  <th>Number Result</th>
                  
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                  if(!empty($bid_lists)){
                    foreach($bid_lists as $key => $bid){
                ?>
                      <tr>
                        <td><?=$key + 1;?></td>
                        <td><?=$bid['title'];?></td>
                        <td><?=date('M d, Y H:i:s',strtotime($bid['cdate']));?></td>
                        <td><?=date('M d, Y H:i:s',strtotime($bid['end_datetime']));?> </td>
                        <td>
                        <?php
                        if($bid['status']==0){
                          echo '<button type="button" class="btn btn-danger btn-sm">Opne</button>';
                        }else{
                          echo '<button type="button" class="btn btn-light btn-sm">Close</button>';
                        }
                        ?>
                        </td>
                        <td>
                        <?php
                         $allColor = explode(',',$bid['result_color']);
                         foreach ($allColor as $value) {
                             
                              
                              $result_color=$db->fetch_record('color','id='.$value);
                              $result_color=$result_color[0];
                              echo $result_color['color_name'].'<br>';
                         }
                         
                         
                        ?>
                         </td>
                        <td><?php
                        $result_number=$db->fetch_record('number_list','id='.$bid['result_number']);
                         $result_number=$result_number[0];
                         echo $result_number['number_name'];

                        ?></td>
                       
                        
                        <td>
                          <?php
                        if($bid['status']==0){
                          ?>
                           <button type="button"  data-toggle="modal" data-target="#editModal<?=$bid['id'];?>" class="btn btn-info btn-xs"><i class="fa fa-edit"></i></button>
                          <?php
                        }
                        ?>
                         
                          
                        </td>
                      </tr>
                      <div class="modal fade" id="editModal<?=$bid['id'];?>" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h3 class="modal-title" id="serviceModalLabel">Set Result</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form method="post"   id="editForm<?=$bid['id'];?>" onsubmit="set_result(event,<?=$bid['id'];?>);"  >
                            <div class="modal-body">
                              <div class="form-group">
                                <label for="first_name">Select Color</label>
                                <select class="form-control" name="color"  required>
                                  <?php
                                  $colors=$db->fetch_record('color');
                                  foreach ($colors as $key => $color) {
                                    echo '<option value="'.$color['id'].'">'.$color['color_name'].'</option>';
                                  }
                                  ?>
                                  
                                </select>
                              </div>

                              <div class="form-group">
                                <label for="first_name">Select Number</label>
                                <select class="form-control" name="number"  required>
                                  <?php
                                  $number_lists=$db->fetch_record('number_list');
                                  foreach ($number_lists as $key => $number_list) {
                                    echo '<option value="'.$number_list['id'].'">'.$number_list['number_name'].'</option>';
                                  }
                                  ?>
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="first_name">Total amount</label>
                                <input type="number" name="price" value="" class="form-control" required="">
                              </div>
                              
                              <input type="hidden" name="id" value="<?=$bid['id'];?>">
                              <div id="Error<?=$bid['id'];?>"></div>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary submitBtn">Update Number</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
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

<script>
 
  $("#Error").hide();

  function set_result(e,id){
    e.preventDefault();
   
    $.ajax({
      method: "POST",
      url:  "process/process.php?action=set_results",
      data: $("#editForm"+id).serialize(),
      dataType: "json",
      beforeSend: function() {
        $(".submitBtn").html('<i class="fa fa-spinner"></i> Processing...');
        $(".submitBtn").prop('disabled', true);
        $("#Error"+id).hide();
      }
    })
    .fail(function(response) {
      alert( "Try again later." );
    })
    .done(function(response) {

      if(response.status == 2){
        $("#Error"+id).html(response.message);
        $("#Error"+id).show();
      }
      if(response.status == 1) location.reload();
    })
    .always(function() {
      $(".submitBtn").html('Update');
      $(".submitBtn").prop('disabled', false);
    });
  }


</script>