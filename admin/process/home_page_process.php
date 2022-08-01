<?php
include_once('../include/function.php');
$db= new functions();
/*profile process start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
  $response['status'] = 0;
  $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again later.</div>';

  $heading = $db->real_sring($_REQUEST['heading']);
  $sub_heading = $db->real_sring($_REQUEST['sub_heading']);
  $description = $db->real_sring($_REQUEST['description']);
  $url = $db->real_sring($_REQUEST['url']);

  if($_FILES['video']['error'] == 0){
    $ext = explode(".", $_FILES['video']['name']);
    $extension = end($ext);
    $filename = 'app_store_' .time() .rand() .'.' .$extension;
    $uploadPath = 'assets/img/homepage/' .$filename;
    $path = '../../' .$uploadPath;
    $tmp_name = $_FILES['video']['tmp_name'];
    if(move_uploaded_file($tmp_name, $path)){
      $video = $uploadPath;
      $insertSql = 'INSERT INTO `home_page_contents` SET
        `heading` = "' .$heading .'",
        `sub_heading` = "' .$sub_heading .'",
        `description` = "' .$description .'",
        `url` = "' .$url .'",
        `video` = "' .$video .'"
      ';
      if($db->query($insertSql)){
        $response['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Content added successfully.</div>';
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
  $run = $db->query("select * from home_page_contents where id = '".$_REQUEST['id']."'");
  if(mysqli_num_rows($run) > 0){
    $row = mysqli_fetch_assoc($run);
    $delete=$db->query("delete from home_page_contents where id = '".$row['id']."'");
    if($delete){
      $_SESSION['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Content deleted successfully.</div>';
    }else{
      $_SESSION['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
    }
  }else{
    $_SESSION['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
  }
    $db->redirect('../home_page_management.php');
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
  $response['status'] = 0;
  $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again later.</div>';

  $heading = $db->real_sring($_REQUEST['heading']);
  $sub_heading = $db->real_sring($_REQUEST['sub_heading']);
  $description = $db->real_sring($_REQUEST['description']);
  $url = $db->real_sring($_REQUEST['url']);
  $app_id = $db->real_sring($_REQUEST['home_content_id']);

  $updateSql = 'UPDATE `home_page_contents` SET
    `heading` = "' .$heading .'",
    `sub_heading` = "' .$sub_heading .'",
    `description` = "' .$description .'",
    `url` = "' .$url .'"
  ';
  if($_FILES['video']['error'] == 0){
    $ext = explode(".", $_FILES['video']['name']);
    $extension = end($ext);
    $filename = 'home_content_' .time() .rand() .'.' .$extension;
    $uploadPath = 'assets/img/homepage/' .$filename;
    $path = '../../' .$uploadPath;
    $tmp_name = $_FILES['video']['tmp_name'];
    if(move_uploaded_file($tmp_name, $path)){
      $video = $uploadPath;
      $old_image = $db->real_sring($_REQUEST['old_image']);
      $oldFile = '../../' .$old_image;
      if(file_exists($oldFile)) unlink($oldFile);

      $image = $uploadPath;
      $updateSql .= '
        , `video` = "' .$image .'"
      ';
    }
  }
  $updateSql .= ' WHERE `id` = ' .$app_id;
  if($db->query($updateSql)){
    $response['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Content updated successfully.</div>';
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