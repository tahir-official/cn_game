<?php
include_once('../include/function.php');
$db= new functions();
/*profile process start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'add'){
  $response['status'] = 0;
  $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again later.</div>';
  $name = $db->real_sring($_REQUEST['name']);
  $social_link = $db->real_sring($_REQUEST['social_link']);
  $fa_icon = $db->real_sring($_REQUEST['fa_icon']);
  
  $insertSql = 'INSERT INTO `social_link` SET
        `name` = "' .$name .'",
        `social_link` = "' .$social_link .'",
        `fa_icon` = "' .$fa_icon .'"
      ';
  if($db->query($insertSql)){
        $response['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Social Link added successfully.</div>';
  }  
  
  $_SESSION['responseMessage'] = $response['responseMessage'];
  // $_SESSION['responseMessage'] .= '<p>' .$insertSql .'</p>';
  echo json_encode($response);
}


else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_link'){
  $run = $db->query("select * from social_link where id = '".$_REQUEST['id']."'");
  if(mysqli_num_rows($run) > 0){
    $row = mysqli_fetch_assoc($run);
    $delete=$db->query("delete from social_link where id = '".$row['id']."'");
    if($delete){
      $_SESSION['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Social Link deleted successfully.</div>';
    }else{
      $_SESSION['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
    }
  }else{
    $_SESSION['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
  }
    $db->redirect('../social_management.php');
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update'){
  $response['status'] = 0;
  $response['responseMessage'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong, please try again later.</div>';
  $name = $db->real_sring($_REQUEST['name']);
  $social_link = $db->real_sring($_REQUEST['social_link']);
  $fa_icon = $db->real_sring($_REQUEST['fa_icon']);
  $id = $db->real_sring($_REQUEST['id']);

  $updateSql = 'UPDATE `social_link` SET
    `name` = "' .$name .'",
    `social_link` = "' .$social_link .'",
    `fa_icon` = "' .$fa_icon .'"
  ';
  
  $updateSql .= ' WHERE `id` = ' .$id;
  if($db->query($updateSql)){
    $response['responseMessage'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Social Link updated successfully.</div>';
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