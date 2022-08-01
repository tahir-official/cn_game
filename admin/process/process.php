<?php
include_once('../include/function.php');
$db= new functions();
/*profile process start*/
if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'login')
{
	$sql = "select * from admin where admin_email='".$_REQUEST['email']."' and admin_pass = '".$_REQUEST['password']."'";
	$run = $db->query($sql);
	if(mysqli_num_rows($run) > 0)
	{
		$row = mysqli_fetch_assoc($run);
		$_SESSION['is_admin_logged_id'] = true;
		$_SESSION['admin_id'] = $row['admin_id'];
		$_SESSION['admin_email'] = $row['admin_email'];
		$db->query("update admin set last_login = '".date('Y-m-d')."' where admin_id = '".$row['admin_id']."'");
		
		$_SESSION['success'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Welcome '.$row['admin_email'].'.</div>';
		$db->redirect('../index.php');
	}
	else
	{
		$_SESSION['error'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Login-Id or Password in correct.</div>';
		$db->redirect('../login.php');	
	}
}


else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_profile')
{
	$sql = "update admin set admin_name = '".$_REQUEST['name']."', admin_email = '".$_REQUEST['email']."' where admin_id = '".$_REQUEST['id']."'";
	$run = $db->query($sql);
	if($run)
	{
		$_SESSION['success'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Your Profile is updated Successfully.</div>';
		$db->redirect('../profile.php');
	}
	else
	{
		$_SESSION['error'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Please try again.</div>';
		$db->redirect('../profile.php');	
	}
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'change_password')
{
	$sql = "select * from admin where admin_id = '".$_REQUEST['id']."'";
	$run = $db->query($sql);
	$row = mysqli_fetch_assoc($run);
	if($row['admin_pass'] == $_REQUEST['Current_Password'])
	{
		$sql = "update admin set admin_pass = '".$_REQUEST['New_Password']."' where admin_id = '".$_REQUEST['id']."'";
		$run = $db->query($sql);
		echo 1;
	}
	else
	{
		echo 0;
	}
}
/*profile process end*/

/*user process start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'change_user_status'){
	$run = $db->query("select * from users where id = '".$_REQUEST['id']."'");
	if(mysqli_num_rows($run) > 0){
		$row = mysqli_fetch_assoc($run);
		$update=$db->query("update users set status = '".$_REQUEST['act']."' where id = '".$row['id']."'");
		if($update){
		if($_REQUEST['act']==0){$status='Activated';}else{$status='Deactivated';}
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> User account has been '.$status.' Successfully.</div>';
		}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
			
	}
    $db->redirect('../user_management.php');
}
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_user'){
	$run = $db->query("select * from users where id = '".$_REQUEST['id']."'");
	if(mysqli_num_rows($run) > 0){
		$row = mysqli_fetch_assoc($run);
		$delete=$db->query("delete from users  where id = '".$row['id']."'");
		if($delete){
			$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> User Deleted Successfully.</div>';
		}else{
			$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
			
	}
    $db->redirect('../user_management.php');
}
/*user process end*/

/*user contact request process start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete_contact_request'){
	$run = $db->query("select * from contact_requests where id = '".$_REQUEST['id']."'");
	if(mysqli_num_rows($run) > 0){
		$row = mysqli_fetch_assoc($run);
		$delete=$db->query("delete from contact_requests  where id = '".$row['id']."'");
		if($delete){
			$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> User Contact Request Deleted Successfully.</div>';
		}else{
			$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
			
	}
    $db->redirect('../contact_management.php');
}
/*user contact request process end*/

/*page content process start*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_about_content'){
	
		$update=$db->query("update page_content set about_content = '".htmlentities($_REQUEST['about_content'],ENT_QUOTES)."' where id = '1'");
		if($update){
		
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> About Page content Updated Successfully.</div>';
		}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	
    $db->redirect('../about_us_management.php');
}
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_terms_condition_content'){
	
		$update=$db->query("update page_content set terms_conditions_content = '".htmlentities($_REQUEST['terms_conditions_content'],ENT_QUOTES)."' where id = '1'");
		if($update){
		
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Terms and Condition Page content Updated Successfully.</div>';
		}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	
    $db->redirect('../terms_conditions_management.php');
}
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_privacy_policy_content'){
	
		$update=$db->query("update page_content set privacy_content = '".htmlentities($_REQUEST['privacy_content'],ENT_QUOTES)."' where id = '1'");
		if($update){
		
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Privacy Policy Page content Updated Successfully.</div>';
		}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	
    $db->redirect('../privacy_policy_management.php');
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_other_content'){
	
		$update=$db->query("update other_content set upper_footer_section = '".htmlentities($_REQUEST['upper_footer_section'],ENT_QUOTES)."',address = '".htmlentities($_REQUEST['address'],ENT_QUOTES)."',call_detail = '".htmlentities($_REQUEST['call_detail'],ENT_QUOTES)."',social_network_section = '".htmlentities($_REQUEST['social_network_section'],ENT_QUOTES)."',Copyright_text = '".htmlentities($_REQUEST['Copyright_text'],ENT_QUOTES)."' where id = '1'");
		if($update){
		
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Other Page content Updated Successfully.</div>';
		}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	
    $db->redirect('../other_content.php');
}

else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'update_some_content'){
	
		$update=$db->query("update other_content set maximum_amount = '".$_REQUEST['maximum_amount']."',minimum_amount = '".$_REQUEST['minimum_amount']."',amount_first = '".$_REQUEST['amount_first']."',fee_first = '".$_REQUEST['fee_first']."',fee_second = '".$_REQUEST['fee_second']."' where id = '1'");
		if($update){
		
		$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Config Setting  Updated Successfully.</div>';
		}else{
		$_SESSION['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
		}
		
		
	
    $db->redirect('../other_content.php');
}

/*page content process end*/

/*bid  process start*/
/*else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'create_bid'){
		
		$current=date('Y-m-d H:i:s');
		$endtime = date('Y-m-d H:i:s',strtotime('+10 minutes',strtotime($current)));
		$insertSql="insert into bid set cdate='".$current."',end_datetime='".$endtime."' ";
		$insertQuery=$db->query($insertSql);
		$last_id=$db->insert_id();

		$updateSql="UPDATE bid SET title='".date('dmY').$last_id."' where id='".$last_id."'";
		$updateRun=$db->query($updateSql);
		echo 'done';
}
*/
else if(isset($_REQUEST['action']) && $_REQUEST['action'] == 'set_results'){
	    $current=date('Y-m-d H:i:s');
		$selectBidSql="select * from bid_result where bid_id='".$_REQUEST['id']."' ";
	    $selectBidQuery=$db->query($selectBidSql);
	    $countBid=mysqli_num_rows($selectBidQuery);
	    if($countBid==0){

	    	$insert=$db->query("insert into bid_result set bid_id = '".$_REQUEST['id']."',color = '".$_REQUEST['color']."',number = '".$_REQUEST['number']."',price = '".$_REQUEST['price']."',created = '".$current."'");
			if($insert){
			$update=$db->query("update bid set result_color = '".$_REQUEST['color']."',result_number = '".$_REQUEST['number']."',status = '1' where id = '".$_REQUEST['id']."'");

			$final_color=$_REQUEST['color'];
			$final_number=$_REQUEST['number'];
			if ($final_color == 1 || $final_color == 2) {
            			
            			$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$final_color."' AND bid_id='".$_REQUEST['id']."'";
            			$selectQueryFinalColor=$db->query($selectSqlFinalColor);

					    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
						{
						 
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
            			$selectQueryUser=$db->query($selectSqlUser);
						$rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			$wallet = $rowUser['wallet'];
            			$winAmount = $row_data['bid_real_amount'] * 2;
            			

            			$newWalletAmount = $winAmount + $wallet;

            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
            			$updateUserRun=$db->query($updateSqlUser);
            			
						$updateSqlWinStatus="update apply_bid set result_status = 1 where id='".$row_data['id']."'";
            			$updateWinStatus=$db->query($updateSqlWinStatus);
            			
						} 

					
            		} else {
	            			$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = 3 AND bid_id='".$_REQUEST['id']."'";
	            			$selectQueryFinalColor=$db->query($selectSqlFinalColor);

						    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
							{
							 
							 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
	            			$selectQueryUser=$db->query($selectSqlUser);
							$rowUser=mysqli_fetch_array($selectQueryUser); 
	            			
	            			$wallet = $rowUser['wallet'];
	            			$winAmount = $row_data['bid_real_amount'] * 1.5;
	            			

	            			$newWalletAmount = $winAmount + $wallet;

	            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
	            			$updateUserRun=$db->query($updateSqlUser);
	            			
							$updateSqlWinStatus="update apply_bid set result_status = 1 where id='".$row_data['id']."'";
	            			$updateWinStatus=$db->query($updateSqlWinStatus);
	            			
							} 
						}

						$selectSqlFinalNumber = "SELECT * FROM apply_bid  WHERE bid_type = 1 AND bid_number = '".$final_number." AND bid_id='".$_REQUEST['id']."''";
            			$selectQueryFinalNumber=$db->query($selectSqlFinalNumber);

					    while($row_data2 = mysqli_fetch_array($selectQueryFinalNumber))
						{
						 
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data2['user_id']."' ";
            			$selectQueryUser=$db->query($selectSqlUser);
						$rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			$wallet = $rowUser['wallet'];
            			$winAmount = $row_data2['bid_real_amount'] * 9;
            			

            			$newWalletAmount = $winAmount + $wallet;

            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data2['user_id']."'";
            			$updateUserRun=$db->query($updateSqlUser);
            			
						$updateSqlWinStatus="update apply_bid set result_status = 1 where id='".$row_data2['id']."'";
            			$updateWinStatus=$db->query($updateSqlWinStatus);
            			
						}

						$updateSqlNumberData="update number_list set apply_amount ='0'";
            			$updateNumburRun=$db->query($updateSqlNumberData);

            			$updateSqlColorData="update color set apply_amount ='0'";
            			$updateColorRun=$db->query($updateSqlColorData);

			
			$_SESSION['message'] = '<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Success!</strong> Result set Successfully.</div>';
			$response['status']=1;
			
			}else{
			$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Something went wrong.</div>';
			$response['status']=2;
			}

	    }else{
	    	$response['message'] = '<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Error!</strong> Result already generate.</div>';
	    	$response['status']=2;
	    }
		
		
		echo json_encode($response);
	
	
   
}
/*bid  process end*/

else
{
	echo '<pre>';
	print_r($_REQUEST);
	print_r($_FILES);
	echo '<h1>Your Action Is Wrong</h1>';
}
?>