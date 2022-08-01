<?php include_once('include/header.php'); ?>
<?php
  $social_link = $db->fetch_record_by_order('social_link', Null,'order by id asc');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Social Link<small>Management</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?=ADMIN_URL?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Social Link</li>
    </ol>
  </section>
  <!-- Main content -->  
  <section class="content">
    <?php if(isset($_SESSION['responseMessage'])){echo $_SESSION['responseMessage']; unset($_SESSION['responseMessage']);}?>
    <!-- Small boxes (Stat box) -->    
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Social Link</h3>
            <div class="pull-right">
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addAppModal" >Add Social Link</button>
            </div>
          </div>
          <div class="box-body">
            <table class="table DataTable table-hover">
              <thead>
                <tr>
                  <th>S.NO.</th>
                  <th>Name</th>
                  <th>Social Link</th>
                  <th>Icon</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if(!empty($social_link)){
                  foreach($social_link as $key => $link){
              ?>
                    <tr>
                      <td><?=$key + 1;?></td>
                      <td><?=$link['name'];?></td>
                      <td><?=$link['social_link'];?></td>
                      <td><?=$link['fa_icon'];?></td>
                      
                      <td>
                        <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#editAppModal_<?=$link['id'];?>" ><i class="fa fa-pencil"></i></button>
                        <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this link?')" href="<?=ADMIN_URL.'process/social_icon_process.php?action=delete_link&id='.$link['id']; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


<!-- Modal -->
<div id="editAppModal_<?=$link['id'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update</h4>
      </div>
      <form id="editAppForm_<?=$link['id'];?>" name="editAppForm_<?=$link['id'];?>" onsubmit="update_link(event, <?=$link['id'];?>);">
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input class="form-control" required type="text" name="name" placeholder="Name" value="<?=$link['name'];?>" >
            
          </div>
          <div class="form-group">
            <label>Social Link</label>
            <input class="form-control" required type="url" name="social_link" placeholder="Social Link" value="<?=$link['social_link'];?>" >
          </div>

           <div class="form-group">
            <label>Icon</label>
            <input class="form-control" required type="text" name="fa_icon" placeholder="Icon" value="<?=$link['fa_icon'];?>" >
            <input required type="hidden" name="id" value="<?=$link['id'];?>" >
          </div>
          
          <div id="editResponseMessage_<?=$link['id'];?>"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success submitBtn" >Update</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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


<!-- Modal -->
<div id="addAppModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Social Icon</h4>
      </div>
      <form id="addSocialForm" name="addSocialForm" onsubmit="add_link(event);">
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input class="form-control" required type="text" name="name" placeholder="Name" >
          </div>
          <div class="form-group">
            <label>Social Link</label>
            <input class="form-control" required type="url" name="social_link" placeholder="Social Link" >
          </div>
          <div class="form-group">
            <label>Icon</label>
            <input required type="text" name="fa_icon" placeholder="Icon" class="form-control"  >
            
          </div>
          <div id="responseMessage"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success submitBtn" >Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>



<?php include_once('include/footer.php'); ?>

<script>
  

  function add_link(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url:  "process/social_icon_process.php?action=add",
      data: new FormData($('#addSocialForm')[0]),
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function() {
        $(".submitBtn").html('<i class="fa fa-spinner"></i> Processing...');
        $(".submitBtn").prop('disabled', true);
        $("#responseMessage").hide();
      }
    })
    .fail(function(response) {
      alert( "Try again later." );
    })
    .done(function(response) {
      $("#responseMessage").html(response.responseMessage);
      // if(response.status == 1) 
      location.reload();
    })
    .always(function() {
      $(".submitBtn").html('Add');
      $(".submitBtn").prop('disabled', false);
    });
  }
  
  function update_link(e, form_index){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url:  "process/social_icon_process.php?action=update",
      data: new FormData($('#editAppForm_' + form_index)[0]),
      dataType: "json",
      processData: false,
      contentType: false,
      cache: false,
      beforeSend: function() {
        $(".submitBtn").html('<i class="fa fa-spinner"></i> Processing...');
        $(".submitBtn").prop('disabled', true);
        $("#editResponseMessage_" + form_index).hide();
      }
    })
    .fail(function(response) {
      alert( "Try again later." );
    })
    .done(function(response) {
      $("#editResponseMessage_" + form_index).html(response.responseMessage);
      location.reload();
    })
    .always(function() {
      $(".submitBtn").html('Update');
      $(".submitBtn").prop('disabled', false);
    });
  }
</script>