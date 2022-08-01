<?php include_once('include/header.php'); ?>
<?php
  $users = $db->fetch_record_by_order('home_page_contents', Null,'order by id desc');
?>
<div class="content-wrapper">
  <section class="content-header">
    <h1>Home Content<small>Management</small></h1>
    <ol class="breadcrumb">
      <li><a href="<?=ADMIN_URL?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Home Content</li>
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
            <h3 class="box-title">Home Content</h3>
            <div class="pull-right">
              <button type="button" class="btn btn-default" data-toggle="modal" data-target="#addAppModal" >Add Home Content</button>
            </div>
          </div>
          <div class="box-body">
            <table class="table DataTable table-hover">
              <thead>
                <tr>
                  <th>S.NO.</th>
                  <th>Heading</th>
                  <th>Sub Heading</th>
                  <th>Description</th>
                  <th>URL</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                if(!empty($users)){
                  foreach($users as $key => $user){
              ?>
                    <tr>
                      <td><?=$key + 1;?></td>
                      <td><?=$user['heading'];?></td>
                      <td><?=$user['sub_heading'];?></td>
                      <td><?=$user['description'];?></td>
                      <td><?=$user['url'];?></td>
                      <td>
                       
                          <img height="200" width="300" class="video-preview" src="<?=MAIN_URL .$user['video'];?>">
                      </td>
                      <td>
                        <button class="btn btn-info btn-xs" data-toggle="modal" data-target="#editAppModal_<?=$user['id'];?>" ><i class="fa fa-pencil"></i></button>
                        <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to delete this app url?')" href="<?=ADMIN_URL.'process/home_page_process.php?action=delete_app&id='.$user['id']; ?>"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>


<!-- Modal -->
<div id="editAppModal_<?=$user['id'];?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Content</h4>
      </div>
      <form id="editAppForm_<?=$user['id'];?>" name="editAppForm_<?=$user['id'];?>" onsubmit="update_app(event, <?=$user['id'];?>);">
        <div class="modal-body">
          <div class="form-group">
            <label>Heading</label>
            <input class="form-control" required type="text" name="heading" placeholder="Heading" value="<?=$user['heading'];?>"  >
            <input required type="hidden" name="home_content_id" value="<?=$user['id'];?>" >
          </div>
          <div class="form-group">
            <label>Sub Heading</label>
            <input class="form-control" type="text" name="sub_heading" placeholder="Sub Heading" value="<?=$user['sub_heading'];?>"  >
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" required name="description"><?=$user['description'];?></textarea>
          </div>
          <div class="form-group">
            <label>Button URL</label>
            <input class="form-control" type="url" name="url" placeholder="https://www.google.com/app" value="<?=$user['url'];?>"  >
          </div>
          <div class="form-group">
            <label>Image</label>
            <input type="file" name="video" accept="image/*" onchange="preview_video(this, 'previewVideo_<?=$user['id'];?>', 'previewVideoSection_<?=$user['id'];?>');" >
            <div id="previewVideoSection_<?=$user['id'];?>" class='video-prev' class="pull-right">
              <img height="200" width="300" id="previewVideo_<?=$user['id'];?>" class="video-preview" controls="controls" src="<?=MAIN_URL .$user['video'];?>" />
              
            </div>
            <input required type="hidden" name="old_image" value="<?=$user['video'];?>" >
          </div>
          <div id="editResponseMessage_<?=$user['id'];?>"></div>
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
        <h4 class="modal-title">Add Home Page Content</h4>
      </div>
      <form id="addAppForm" name="addAppForm" onsubmit="add_app(event);">
        <div class="modal-body">
          <div class="form-group">
            <label>Heading</label>
            <input class="form-control" type="text" name="heading" placeholder="Heading" >
          </div>
          <div class="form-group">
            <label>Sub Heading</label>
            <input class="form-control" type="text" name="sub_heading" placeholder="Sub Heading" >
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" required name="description"></textarea>
          </div>
          <div class="form-group">
            <label>Button URL</label>
            <input class="form-control" type="url" name="url" placeholder="https://www.google.com/app" >
          </div>
          <div class="form-group">
            <label>Image</label>
            <input required type="file" name="video" accept="image/*" onchange="preview_video(this, 'previewVideo', 'previewVideoSection');" >
            <div style="display: none;" id="previewVideoSection" class='video-prev' class="pull-right">
               <img height="200" width="300" id="previewVideo_<?=$user['id'];?>" class="video-preview" controls="controls" />
            </div>
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
  function preview_image(input, previewId) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#' + previewId).attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function preview_video(input, previewId, prevideSection){
    $('#' + previewId).attr('src', URL.createObjectURL(input.files[0]));
    $('#' + prevideSection).show();
  }

  function add_app(e){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url:  "process/home_page_process.php?action=add",
      data: new FormData($('#addAppForm')[0]),
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
  
  function update_app(e, form_index){
    e.preventDefault();
    $.ajax({
      method: "POST",
      url:  "process/home_page_process.php?action=update",
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