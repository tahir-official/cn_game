<?php 
  include_once('include/header.php');
  $other_content = $db->fetch_record('other_content', 'id=1');
  $other_content = $other_content[0];
?>

<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>Other Home Page<small>Management</small></h1>
    <ol class="breadcrumb">
      <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"><a href="privacy_policy_management.php">Other Home Page Management</a></li>
    </ol>
  </section>
  <!-- Main content -->
  <section class="content">
    <?php if(isset($_SESSION['message'])){ echo $_SESSION['message'];unset($_SESSION['message']);}?>
    <div class="row">
      <form role="form" method="post"   action="<?=ADMIN_URL.'process/process.php?action=update_other_content'; ?>">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-body">
              <input type="hidden"  value="<?=$other_content['id']; ?>">
             
              
              <div class="form-group">
                <label class=" form-control-label">Upper Footer Section</label>
                <textarea name="upper_footer_section" id="upper_footer_section" class="form-control"><?=$other_content['upper_footer_section']; ?></textarea>
              </div>

              <div class="form-group">
                <label class=" form-control-label">Address</label>
                <textarea name="address" id="address" class="form-control"><?=$other_content['address']; ?></textarea>
              </div>

              <div class="form-group">
                <label class=" form-control-label">Call Detail</label>
                <textarea name="call_detail" id="call_detail" class="form-control"><?=$other_content['call_detail']; ?></textarea>
              </div>

               <div class="form-group">
                <label class=" form-control-label">Social Network Section</label>
                <textarea name="social_network_section" id="social_network_section" class="form-control"><?=$other_content['social_network_section']; ?></textarea>
              </div>

              <div class="form-group">
                <label class=" form-control-label">Copyright Text</label>
                <textarea name="Copyright_text" id="Copyright_text" class="form-control"><?=$other_content['Copyright_text']; ?></textarea>
              </div>

            </div>
            <div class="box-footer">
              <button type="submit" name="submit" class="btn btn-success submit-btn">Submit</button>
            </div>
          </div>
        </div>

      </form>
      
      <form role="form" method="post"   action="<?=ADMIN_URL.'process/process.php?action=update_some_content'; ?>">
        <div class="col-md-6">
          <div class="box box-primary">
            <div class="box-body">
              <input type="hidden"  value="<?=$other_content['id']; ?>">
             
              
              <div class="form-group">
                <label class=" form-control-label">Withdraw maximum amount</label>
                
                <input name="maximum_amount" id="maximum_amount" class="form-control" value="<?=$other_content['maximum_amount']; ?>" >
              </div>

              <div class="form-group">
                <label class=" form-control-label">Withdraw minimum amount</label>
                <input name="minimum_amount" id="minimum_amount" class="form-control" value="<?=$other_content['minimum_amount']; ?>" >
              </div>

              <div class="form-group">
                <label class=" form-control-label">Amount</label>
               <input name="amount_first" id="amount_first" class="form-control" value="<?=$other_content['amount_first']; ?>" >
              </div>

               <div class="form-group">
                <label class=" form-control-label">Fee befor in RS</label>
                <input name="fee_first" id="fee_first" class="form-control" value="<?=$other_content['fee_first']; ?>" >
              </div>

              <div class="form-group">
                <label class=" form-control-label">Fee after in Percent</label>
                 <input name="fee_second" id="fee_second" class="form-control" value="<?=$other_content['fee_second']; ?>" >
              </div>

            </div>
            <div class="box-footer">
              <button type="submit" name="submit" class="btn btn-success submit-btn">Submit</button>
            </div>
          </div>
        </div>

      </form>
    </div>
  </section>
</div>
<?php include_once('include/footer.php'); ?>
