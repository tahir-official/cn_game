<?php 
  include_once('include/header.php');
  $page_content = $db->fetch_record('page_content', 'id=1');
  $page_content = $page_content[0];
?>

</style>
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Terms and conditions Page<small>Management</small></h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="terms_conditions_management.php">Terms and conditions Management</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];unset($_SESSION['message']);}?>
    <div class="row">
      <form role="form" method="post" id="terms_condition_content_form" action="<?=ADMIN_URL.'process/process.php?action=update_terms_condition_content'; ?>"   >
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <input type="hidden" name="id" value="<?=$page_content['id']; ?>">
              
             
              <div class="form-group">
                <label class=" form-control-label">Page content</label>
                <textarea name="terms_conditions_content" id="terms_conditions_content" class="form-control textarea"><?=$page_content['terms_conditions_content']; ?></textarea>
              </div>
            </div>
            <div class="box-footer text-center">
              <button type="submit" name="submit" class="btn btn-success submit-btn">Submit</button>
            </div>
          </div>
        </div>

      </form>
    </div>
  </section>
</div>
<?php include_once('include/footer.php'); ?>
