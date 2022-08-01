<?php
include_once('../include/function.php');
$db= new functions();
/*profile process start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
  $response['status'] = 0;
  $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again later.</div>';
  $platform = $db->real_sring($_REQUEST['platform']);
  $app_url = $db->real_sring($_REQUEST['app_url']);
  if($_FILES['image']['error'] == 0){
    $ext = explode(".", $_FILES['image']['name']);
    $extension = end($ext);
    $filename = 'app_store_' .time() .rand() .'.' .$extension;
    $uploadPath = 'assets/img/homepage/' .$filename;
    $path = '../../' .$uploadPath;
    $tmp_name = $_FILES['image']['tmp_name'];
    if(move_uploaded_file($tmp_name, $path)){
      $image = $uploadPath;
      $insertSql = 'INSERT INTO `application_platforms` SET
        `platform` = "' .$platform .'",
        `app_url` = "' .$app_url .'",
        `image` = "' .$image .'"
      ';
      if($db->query($insertSql)){
        $response['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> App added successfully.</div>';
      }
    }
  }else{
    $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> There is an error with the image.</div>';
  }
  $_SESSION['responseMessage'] = $response['responseMessage'];
  // $_SESSION['responseMessage'] .= '<p>' .$insertSql .'</p>';
  echo json_encode($response);
}


else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_app'){
  $run = $db->query("select * from application_platforms where id = '".$_REQUEST['id']."'");
  if(mysqli_num_rows($run) > 0){
    $row = mysqli_fetch_assoc($run);
    $delete=$db->query("delete from application_platforms where id = '".$row['id']."'");
    if($delete){
      $_SESSION['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> App url deleted successfully.</div>';
    }else{
      $_SESSION['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
    }
  }else{
    $_SESSION['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
  }
    $db->redirect('../app_stores.php');
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
  $response['status'] = 0;
  $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again later.</div>';
  $platform = $db->real_sring($_REQUEST['platform']);
  $app_url = $db->real_sring($_REQUEST['app_url']);
  $app_id = $db->real_sring($_REQUEST['app_id']);

  $updateSql = 'UPDATE `application_platforms` SET
    `platform` = "' .$platform .'",
    `app_url` = "' .$app_url .'"
  ';
  if($_FILES['image']['error'] == 0){
    $ext = explode(".", $_FILES['image']['name']);
    $extension = end($ext);
    $filename = 'app_store_' .time() .rand() .'.' .$extension;
    $uploadPath = 'assets/img/homepage/' .$filename;
    $path = '../../' .$uploadPath;
    $tmp_name = $_FILES['image']['tmp_name'];
    if(move_uploaded_file($tmp_name, $path)){
      $old_image = $db->real_sring($_REQUEST['old_image']);
      $oldFile = '../../' .$old_image;
      if(file_exists($oldFile)) unlink($oldFile);

      $image = $uploadPath;
      $updateSql .= '
        , `image` = "' .$image .'"
      ';
      }
  }
  $updateSql .= ' WHERE `id` = ' .$app_id;
  if($db->query($updateSql)){
    $response['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> App updated successfully.</div>';
  }
  $_SESSION['responseMessage'] = $response['responseMessage'];
  //$_SESSION['responseMessage'] .= '<p>' .$updateSql .'</p>';
  echo json_encode($response);
}

else
{
  echo '<pre>';
  // print_r($_REQUEST);
  // print_r($_FILES);
  echo '<h1>Your Action Is Wrong</h1>';
}
?>