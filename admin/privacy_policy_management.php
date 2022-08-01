<?php 
  include_once('include/header.php');
  $page_content = $db->fetch_record('page_content', 'id=1');
  $page_content = $page_content[0];
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Privacy Policy Page<small>Management</small></h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="privacy_policy_management.php">Privacy Policy Management</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];unset($_SESSION['message']);}?>
    <div class="row">
      <form role="form" method="post" id="privacy_policy_content_form"  action="<?=ADMIN_URL.'process/process.php?action=update_privacy_policy_content'; ?>">
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-body">
              <input type="hidden" name="id" value="<?=$page_content['id']; ?>">
             
              
              <div class="form-group">
                <label class=" form-control-label">Page Content</label>
                <textarea name="privacy_content" id="privacy_content" class="form-control textarea"><?=$page_content['privacy_content']; ?></textarea>
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
