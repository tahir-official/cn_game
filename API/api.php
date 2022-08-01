<?php
error_reporting(E_ALL);
header("Access-Control-Allow-Origin: *");
header('Content-type:application/json');
date_default_timezone_set("Asia/Calcutta");
include 'config.php';
$action= isset($_REQUEST['action'])? strtolower($_REQUEST['action']):'';
extract($_REQUEST);
switch($action)
{
    case 'Login':
	$arr_res=Login($_REQUEST);
	break;

	case 'Signup':
	$arr_res=Signup($_REQUEST);
	break;

	case 'Forget_password':
	$arr_res=Forget_password($_REQUEST);
	break;

	case 'updateDeviceId':
	$arr_res=updateDeviceId($_REQUEST);
	break;

	case 'changePassword':
	$arr_res=changePassword($_REQUEST);
	break;

    case 'getUserDetail':
	$arr_res=getUserDetail($_REQUEST);
	break;

	case 'getBankDetail':
	$arr_res=getBankDetail($_REQUEST);
	break;

	case 'updateBankDetail':
	$arr_res=updateBankDetail($_REQUEST);
	break;

	case 'updateProfile':
	$arr_res=updateProfile($_REQUEST);
	break;

	case 'contactUs':
	$arr_res=contactUs($_REQUEST);
	break;

	case 'getAllpage':
	$arr_res=getAllpage($_REQUEST);
	break;

	case 'Verifyotp':
	$arr_res=Verifyotp($_REQUEST);
	break;

	case 'Resendotp':
	$arr_res=Resendotp($_REQUEST);
	break;

	case 'createBid':
	$arr_res=createBid($_REQUEST);
	break;

	case 'getOpenBid':
	$arr_res=getOpenBid($_REQUEST);
	break;

	case 'setBidresult':
	$arr_res=setBidresult($_REQUEST);
	break;

	case 'setBidresult2':
	$arr_res=setBidresult2($_REQUEST);
	break;

	case 'rechargeWallet':
	$arr_res=rechargeWallet($_REQUEST);
	break;

	case 'getRechargeHistory':
	$arr_res=getRechargeHistory($_REQUEST);
	break;

	case 'applyBid':
	$arr_res=applyBid($_REQUEST);
	break;

	case 'configSetting':
	$arr_res=configSetting($_REQUEST);
	break;

	case 'getReferralRecord':
	$arr_res=getReferralRecord($_REQUEST);
	break;

	case 'getCountries':
	$arr_res=getCountries($_REQUEST);
	break;

	case 'getStates':
	$arr_res=getStates($_REQUEST);
	break;

	case 'getCities':
	$arr_res=getCities($_REQUEST);
	break;

    case 'withdrawalRequst':
	$arr_res=withdrawalRequst($_REQUEST);
	break;

	case 'getwithdrawalHistory':
	$arr_res=getwithdrawalHistory($_REQUEST);
	break;


    case 'deleteRecord':
	$arr_res=deleteRecord($_REQUEST);
	break;

	case 'getBidHistory':
	$arr_res=getBidHistory($_REQUEST);
	break;

	case 'sends':
	$arr_res=sends($_REQUEST);
	break;

    default:
	$arr_res=array('success'=>0,'msg'=>'No web service Found.');
}

$output = json_encode($arr_res);
print_r($output);
/***********
basic function start
***********/
function query($q)
{	global $conns;
	$sqlquery = mysqli_query($conns,$q);
	return $sqlquery;
}
function insert_id()
{	global $conns;
	$id = mysqli_insert_id($conns);
	return $id;
}
function real_sring($q)
{	global $conns;
	$string = mysqli_real_escape_string($conns, $q);
	return $string;
}
function redirect($location)
{ 
	echo '<script>window.location.href="'.$location.'"</script>';
	die(); 
}
function Get_admin_data($id)
{
	global $conns;
	$data = false;
	$sql = "select * from admin where admin_id = '".$id."'";
	$run = query($sql);
	if(mysqli_num_rows($run) > 0)
	{
		$data = mysqli_fetch_assoc($run);
	}
	return $data;
}
function rand_string($length) {

    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    return substr(str_shuffle($chars),0,$length);

}
 function send_sms($msg, $tonumber){
    $body = trim($msg);
    $data='curl -X POST https://api.twilio.com/2010-04-01/Accounts/ACd1b9e6ae43e4f374c385c0ccdf55820b/Messages.json \
    --data-urlencode "From=+12183094386" \
    --data-urlencode "Body='.$body.'" \
    --data-urlencode "To='.$tonumber.'" \
    -u ACd1b9e6ae43e4f374c385c0ccdf55820b:58f70730364b997e29bd8a77fe71f820';
    $v=exec($data,$result);
    fclose($handle);
    return 1;
}
function get_users_basic_details($id=null){

		$selectSql="select * from  users where id='".real_sring($id)."'";
		$selectRun=query($selectSql);
		$count=mysqli_num_rows($selectRun);
		if($count){
			$row=mysqli_fetch_array($selectRun); 
			$result['id']=$row['id'];
			$result['id_number']=$row['u_id'];
			$result['name']=$row['name'];
			$result['email']=$row['email'];
			$result['mobile_number']=$row['mobile_number'];
			$result['status']=$row['status'];
			$result['is_active']=$row['is_active'];
	        
			$result['referral_code']=$row['referral_code'];
			$result['referral_by']=$row['referral_by'];
			$result['wallet']=$row['wallet'];	
			$result['device_id']=$row['device_id'];

			$result['city_id']=$row['city_id'];
			if($row['city_id']){
				$selectSqlCities="select * from  cities where id='".$row['city_id']."'";
		        $selectRunCities=query($selectSqlCities);
		        $rowCities=mysqli_fetch_array($selectRunCities); 
		        $result['city_name']=$rowCities['name'];
			}else{
				$result['city_name']='';
			}

			$result['state_id']=$row['state_id'];
			if($row['state_id']){
				$selectSqlStates="select * from  states where id='".$row['state_id']."'";
		        $selectRunStates=query($selectSqlStates);
		        $rowStates=mysqli_fetch_array($selectRunStates); 
		        $result['state_name']=$rowStates['name'];
			}else{
				$result['state_name']='';
			}

			$result['country_id']=$row['country_id'];
			if($row['country_id']){
				$selectSqlCountries="select * from  countries where id='".$row['country_id']."'";
		        $selectRunCountries=query($selectSqlCountries);
		        $rowCountries=mysqli_fetch_array($selectRunCountries); 
		        $result['country_name']=$rowCountries['name'];
			}else{
				$result['country_name']='';
			}

			$result['postcode']=$row['postcode'];

			if($row['profile_image']!=''){
				$result['profile_image']=ADMIN_URL.'img/profile_image/'.$row['profile_image'];
			} else {
				$result['profile_image']=ADMIN_URL.'img/user.png';
			}
			$result['cdate']=change_date_view($row['cdate']);
			
			$output = $result;

		}else {
			$output['status'] = 0;
			$output['message'] = 'Something went wrong !!';
		}
		
		
		return $output;
}
function change_date_view($date=null){
	return $newDate = date("d M Y h:i a", strtotime($date)); 
}
 
/***********
basic function end
***********/


/***********
profile api start
***********/

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=configSetting&user_id=23
function configSetting($data)
{
	if($data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}else{
		$selectSql="select * from  users where id='".real_sring($data['user_id'])."' ";
		$selectRun=query($selectSql);
		$count=mysqli_num_rows($selectRun);
		if($count){
			 $row=mysqli_fetch_array($selectRun); 
			 $result['wallet']=$row['wallet'];
			 $result['Project']=Project;
			 $result['currency']=CURRENCY;

			 $selectSqlColor="select * from color";
			 $selectQueryColor=query($selectSqlColor);
			 $record_color = array();
		     $i = 0;
		     while($row_data_color = mysqli_fetch_array($selectQueryColor))
			 {
			  

		     $record_color[$i]['id'] = $row_data_color['id'];
			 $record_color[$i]['color_name'] = $row_data_color['color_name'];
			 $record_color[$i]['color_code'] = $row_data_color['color_code'];	
			 	
			 
			 $i++;
			 }

			 $result['color_list'] = $record_color;


			 $selectSqlNumber="select * from number_list";
			 $selectQueryNumber=query($selectSqlNumber);
			 $record_number = array();
		     $i = 0;
		     while($row_data_number = mysqli_fetch_array($selectQueryNumber))
			 {
			  

		     $record_number[$i]['id'] = $row_data_number['id'];
			 $record_number[$i]['number'] = $row_data_number['number_name'];
			 	
			 $i++;
			 }

			 $result['number_list'] = $record_number;

			 $selectSqlContent="select * from  other_content where id='1' ";
		     $selectRunContent=query($selectSqlContent);
		     $rowContent=mysqli_fetch_array($selectRunContent); 

			 $result['fee_charge'] = array('fee_first'=>$rowContent['amount_first'].'≥Amount≥'.$rowContent['minimum_amount'].' Rs, fee '.CURRENCY.$rowContent['fee_first'],'fee_second'=>$rowContent['maximum_amount'].'≥Amount>'.$rowContent['amount_first'].' Rs, fee '.$rowContent['fee_second'].'%');

			 $result['single_withdraw_limit'] = array('maximum_amount'=>$rowContent['maximum_amount'],'minimum_amount'=>$rowContent['minimum_amount']);

			 $result['services_time'] = array('monday'=>'Monday:10:00-17:00;','tuesday'=>'Tuesday:10:00-17:00;','wednesday'=>'Wednesday:10:00-17:00;','thursday'=>'Thursday:10:00-17:00;','friday'=>'Friday:10:00-17:00;','saturday'=>'Saturday:10:00-17:00;');

			 $result['invite_url'] ='http://mokiaclub.com/';
			 //$result['razorpay_api'] ='rzp_test_pdrNivCFliAPJm';
			 $result['razorpay_api'] ='rzp_test_bam4K5Li0giTUb';
			 
			 $result['whatapp_url'] ='http://mokiaclub.com/';
			 $result['telegram_url'] ='http://mokiaclub.com/';

			 $output['page_content']=$result;
			 $output['success'] = 1;
			 $output['msg'] = "Fetch Config Detail successfully !!";
			 return $output;

		}else{
			 $output['success'] = 0;
			 $output['msg'] = "Invalid User ID !!";
			 return $output;
		 }
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=Login&email=tahir@mailinator.com&password=123456
function Login($data)
{
	if($data['email']==Null || $data['password']==Null )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		 $selectSql="select * from  users where email='".real_sring($data['email'])."' and password='".real_sring(md5($data['password']))."'";
		 $selectRun=query($selectSql);
		 $count=mysqli_num_rows($selectRun);
		 if($count)
		 {
			$row=mysqli_fetch_array($selectRun); 
			if($row['is_active']!=1){
				if($row['status']==0)
				{
					

					$userData=get_users_basic_details($row['id']);
					
					$updateSql="UPDATE users SET login_date='".date('Y-m-d H:i:s')."' where id='".$row['id']."'";
			        $updateRun=query($updateSql);
					
					$output['user_detail']=$userData;
					$output['success'] = 1;
					$output['msg'] = "Login successfully !!";
					return $output;
				}
				else 
				{
					$output['success'] = 0;
					$output['msg'] = "Error! Your account is deactivated !!";
					return $output;
				}

			}else{

				   $userData=get_users_basic_details($row['id']);
				   $output['user_detail']=$userData;
				   $output['success'] = 1;
				   $output['msg'] = "Error! Please verify your account !!";
				   return $output;
			}
			
		 }
		 else 
		 {
			 $output['success'] = 0;
			 $output['msg'] = "Invalid Login detail !!";
			 return $output;
		 }
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=Signup&name=price&email=tahir@mailinator.com&mobile_number=78545487874&password=123456
function Signup($data)
{
	if($data['name']==Null || $data['email']==Null || $data['mobile_number']==Null || $data['password']==Null )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where email='".$data['email']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$output['success'] = 0;
			$output['msg'] = "This email address already exists !!";
			return $output;
		}
		else 
		{
			
            $selectSqlphone="select * from users where mobile_number='".$data['mobile_number']."' ";
		    $selectQueryphone=query($selectSqlphone);
		    $countphone=mysqli_num_rows($selectQueryphone);
		    if($countphone > 0)
			{
				$output['success'] = 0;
				$output['msg'] = "This phone number already exists !!";
				return $output;
			}else{
				$code=rand(100000,999999);
				$referral_code=rand_string(6);
				$referral_by='';
				$level_one=0;
				$level_two=0;
				if($data['referral_by']!=''){
					$referral_by=$data['referral_by'];
					$selectSqllevelOne="select * from users where referral_code='".$data['referral_by']."' ";
		            $selectQuerylevelOne=query($selectSqllevelOne);
		            $countlevelOne=mysqli_num_rows($selectQuerylevelOne);
		            if($countlevelOne){
		            	$rowlevelOne=mysqli_fetch_array($selectQuerylevelOne); 
		            	$level_one=$rowlevelOne['id'];

		            	$selectSqllevelTwo="select * from users where referral_code='".$rowlevelOne['referral_by']."' ";
		                $selectQuerylevelTwo=query($selectSqllevelTwo);
		                $countlevelTwo=mysqli_num_rows($selectQuerylevelTwo);
		                if($countlevelTwo){
		                	$rowlevelTwo=mysqli_fetch_array($selectQuerylevelTwo); 
		                	$level_two=$rowlevelTwo['id'];
		                }


		            }



				}
				$insertSql="insert into users set name='".$data['name']."', email='".real_sring($data['email'])."',mobile_number='".$data['mobile_number']."',password='".real_sring(md5($data['password']))."', otp='".$code."', is_active='1', cdate='".date('Y-m-d H:i:s')."',referral_code='".$referral_code."',referral_by='".$referral_by."',level_one='".$level_one."',level_two='".$level_two."'";
				$insertQuery=query($insertSql);
				$last_id=insert_id();

				$updateSql="UPDATE users SET u_id='".$last_id.date('dmY')."' where id='".$last_id."'";
				$updateRun=query($updateSql);

			    
	            $to = $data['email'];
		        $subject = 'Account Confirmation !!';
		        $contant = 'Hello, '.$data['name'].'! <br><br>';
				$contant.='<p>Your Account has been created successfully.Please varify your account using this OTP:'.$code.'</p>'; 

			    Send_mail($to,$subject,$contant);
			    $number='+91'.$data['mobile_number'];
			    $msg='your verification OTP is: '.$code;
			    send_sms($msg,$number);

			    $userData=get_users_basic_details($last_id);
			    $output['user_detail']=$userData;
				$output['success'] = "1";
				$output['msg'] = "Your account created successfully !!";
				return $output;
			}

			
		}
		
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=Verifyotp&otp=641509&user_id=10
function Verifyotp($data)
{
	if($data['otp']==Null || $data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{ 

		$selectSql="select * from users where id='".$data['user_id']."' and otp='".$data['otp']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$updateSql="UPDATE users SET otp='',is_active='0' where id='".$data['user_id']."'";
		    $updateRun=query($updateSql);
			$output['success'] = 1;
			$output['msg'] = "Your account verified successfully !!";
			return $output;
		}
		else 
		{
			
            $output['success'] = 0;
			$output['msg'] = "OTP is invalid !!";
			return $output;
		}
		
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=Resendotp&number=9755563888
function Resendotp($data)
{
	if($data['number']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{ 

		$selectSql="select * from users where mobile_number='".$data['number']."'  ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{	
			$code=rand(100000,999999);
			$row=mysqli_fetch_array($selectQuery); 
			$updateSql="UPDATE users SET otp='".$code."' where id='".$row['id']."'";
		    $updateRun=query($updateSql);

		    $number='+91'.$row['mobile_number'];
		    $msg='your verification OTP is: '.$code;
		    send_sms($msg,$number);


		     $to = $row['email'];
		     $subject = 'Account Confirmation !!';
		     $contant = 'Hello, '.$row['name'].'! <br><br>';
		     $contant.='<p>Your Account has been created successfully.Please varify your account using this OTP:'.$code.'</p>'; 

			 Send_mail($to,$subject,$contant);

		    $output['user_id']=$row['id'];
			$output['success'] = 1;
			$output['msg'] = "Your OTP send successfully !!";
			return $output;
		}
		else 
		{
			
            $output['success'] = 0;
			$output['msg'] = "Number is not register !!";
			return $output;
		}
		
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=Forget_password&email=tahir@mailinator.com
function Forget_password($data)
{
	if($data['email']==Null )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where email='".$data['email']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$row=mysqli_fetch_array($selectQuery); 
			$password=rand_string(6);

			$updateSql="update users set password='".md5($password)."' where id='".$row['id']."'";
			$updateQuery=query($updateSql);

			$to = $row['email'];
	        $subject = 'New Password !!';
	        $contant = 'Hello, '.$row['name'].'! <br><br>';
			$contant.='<p>You have recived new password successfully.</p>'; 
			$contant.='<p><b>Password:<b> '.$password.'</p>'; 
            Send_mail($to,$subject,$contant);
            $output['success'] = "1";
			$output['msg'] = "New password sended in your email address !!";
			return $output;
		}
		else 
		{
			$output['success'] = 0;
			$output['msg'] = "This email address not exists !!";
			return $output;
		}
		
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=updateDeviceId&device_id=abc&user_id=2
function updateDeviceId($data)
{
	if($data['device_id']==Null || $data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where id='".$data['user_id']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$updateSql="update  users set device_id='".$data['device_id']."' where id='".$data['user_id']."'";
			$updateQuery=query($updateSql);
			$output['success'] = "1";
			$output['msg'] = "Device Id updated successfully !!";
			return $output;
		}else{
			$output['success'] = 0;
			$output['msg'] = "This user id not exists !!";
			return $output;
		}
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=changePassword&current_password=123456&new_password=1234567&user_id=2
function changePassword($data)
{
	if($data['current_password']==Null || $data['new_password']==Null || $data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where id='".$data['user_id']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$row=mysqli_fetch_array($selectQuery); 
			if(md5($data['current_password'])==$row['password']){

				$updateSql="update  users set password='".md5($data['new_password'])."' where id='".$data['user_id']."'";
				$updateQuery=query($updateSql);
				$output['success'] = "1";
				$output['msg'] = "Password changed successfully !!";
				return $output;
			}else{
				$output['success'] = 0;
				$output['msg'] = "Your Current password is incorrect !!";
				return $output;
			}
			
		}else{
			$output['success'] = 0;
			$output['msg'] = "This user id not exists !!";
			return $output;
		}
	}
}
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getUserDetail&user_id=1
function getUserDetail($data)
{
	if($data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where id='".$data['user_id']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			
			$userData=get_users_basic_details($data['user_id']);
			$output['user_detail']=$userData;
			$output['success'] = 1;
			$output['msg'] = "User detail found successfully !!";
			return $output;

		}else{
			$output['success'] = 0;
			$output['msg'] = "User Data not Found !!";
			return $output;
		}
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=updateProfile&name=tahir&mobile_number=1234567&user_id=1&city_id=20&state_id=2&country_id=101&postcode=460300
function updateProfile($data)
{
	if($data['name']==Null || $data['mobile_number']==Null ||  $data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where id='".$data['user_id']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$temp = explode(".", $_FILES["profile_image"]["name"]);
			$newfilename = round(microtime(true)) . '.' . end($temp);
			$newfile='../admin/img/profile_image/'.$newfilename;
			if(move_uploaded_file($_FILES["profile_image"]["tmp_name"], $newfile)) 
			{
				$file=$newfilename;
				$filed=", `profile_image`='$file'";
				
			} 
			$updateSql="update  users set name='".$data['name']."',mobile_number='".$data['mobile_number']."',city_id='".$data['city_id']."',state_id='".$data['state_id']."',country_id='".$data['country_id']."',postcode='".$data['postcode']."' $filed where id='".$data['user_id']."'";
			$updateQuery=query($updateSql);
			$output['success'] = "1";
			$output['msg'] = "User detail updated successfully !!";
			return $output;
			
			
		}else{
			$output['success'] = 0;
			$output['msg'] = "This user id not exists !!";
			return $output;
		}
	}
}
/***********
profile api end
***********/



/***********
bank upi api start
***********/
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getBankDetail&user_id=1
function getBankDetail($data)
{
	if($data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where id='".$data['user_id']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$row=mysqli_fetch_array($selectQuery); 
			$result['user_id']=$row['id'];
			$result['bank_upi']=$row['bank_upi'];
			$result['bank_name']=$row['bank_name'];
			$result['account_number']=$row['account_number'];
			$result['holder_name']=$row['holder_name'];
			$result['ifsc_code']=$row['ifsc_code'];
			$result['upi']=$row['upi'];
			
			
			$output['user_detail']=$result;
			$output['success'] = 1;
			$output['msg'] = "User Bank detail found successfully !!";
			return $output;

		}else{
			$output['success'] = 0;
			$output['msg'] = "User Bank Data not Found !!";
			return $output;
		}
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=updateBankDetail&bank_name=bank of india&account_number=1234567&holder_name=tahir&ifsc_code&user_id=1
function updateBankDetail($data)
{
	if($data['user_id']==Null)
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from users where id='".$data['user_id']."' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			
			if($data['bank_upi']==0){
				$updateSql="update  users set bank_name='".$data['bank_name']."',account_number='".$data['account_number']."',holder_name='".$data['holder_name']."',ifsc_code='".$data['ifsc_code']."',bank_upi='".$data['bank_upi']."' where id='".$data['user_id']."'";
			}else{
				$updateSql="update  users set upi='".$data['upi']."',bank_upi='".$data['bank_upi']."' where id='".$data['user_id']."'";
			}
			


			$updateQuery=query($updateSql);
			$output['success'] = "1";
			$output['msg'] = "Bank detail updated successfully !!";
			return $output;
			
			
		}else{
			$output['success'] = 0;
			$output['msg'] = "This user id not exists !!";
			return $output;
		}
	}
}
/***********
bank upi api end
***********/



/***********
contact form api start
***********/
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=contactUs&name=price&email=tahir@mailinator.com&phone=78545487874&message=hello
function contactUs($data)
{
	if($data['name']==Null || $data['email']==Null || $data['phone']==Null || $data['message']==Null )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		
			$insertSql="insert into contact_requests set name='".$data['name']."', email='".real_sring($data['email'])."',phone='".$data['phone']."',query='".$data['message']."', created='".date('Y-m-d H:i:s')."'";
			$insertQuery=query($insertSql);

			$dataAdmin=Get_admin_data(1);
			$to = $dataAdmin['email'];
	        $subject = 'New Contact Request Notification !!';
	        $contant = 'Hello admin, ! <br><br>';
			$contant.='<p>You have recived new contact request.</p>'; 

		    Send_mail($to,$subject,$contant);

			$output['success'] = "1";
			$output['msg'] = "Your Contact request sended successfully !!";
			return $output;
		
		
	}
}
/***********
contact form api end
***********/


/***********
all pages api start
***********/
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getAllpage
function getAllpage($data)
{
	
		$selectSql="select * from page_content where id='1' ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$row=mysqli_fetch_array($selectQuery); 
			$result['about_content']=html_entity_decode($row['about_content'],ENT_QUOTES );
			$result['terms_conditions_content']=html_entity_decode($row['terms_conditions_content'],ENT_QUOTES );
			$result['privacy_content']=html_entity_decode($row['privacy_content'],ENT_QUOTES );
			$result['currency']=CURRENCY;
			$output['page_content']=$result;
			$output['success'] = 1;
			$output['msg'] = "page content found successfully !!";
			return $output;

		}else{
			$output['success'] = 0;
			$output['msg'] = "page content not Found !!";
			return $output;
		}
	
}
/***********
all pages api end
***********/


/***********
recharge api start
***********/
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=rechargeWallet&user_id=23&amount=100&payment_id=sdfsdf&status=1
function rechargeWallet($data)
{
	
	$current=date('Y-m-d H:i:s');
	$selectSql="select * from users where id='".$data['user_id']."' ";
	$selectQuery=query($selectSql);
	$count=mysqli_num_rows($selectQuery);
	if($count > 0)
	{
		if($data['status']==1){

			$row=mysqli_fetch_array($selectQuery); 
			$lastamount=$row['wallet'];
			$newamount=$data['amount']+$lastamount;

			 $updateSql="update users set wallet='".$newamount."' where id='".$row['id']."'";
	         $updateRun=query($updateSql);
	         if($updateRun){

	         	$insertSql="insert into recharge_history set user_id='".$data['user_id']."',amount='".$data['amount']."',status='".$data['status']."',payment_method='razorpay',payment_id='".$data['payment_id']."',cdate='".$current."' ";
		        $insertQuery=query($insertSql);

		        if($insertQuery){
		        	$output['wallet'] = $newamount;
		        	$output['success'] = 1;
				    $output['msg'] = "wallet Recharge successfully !!";
				    return $output;

		        }else{
		        	$output['success'] = 0;
				    $output['msg'] = "Something went wrong !!";
				    return $output;
		        }


	         }else{
	         	$output['success'] = 0;
			    $output['msg'] = "Something went wrong !!";
			    return $output;
	         }

		}else{
			    $insertSql="insert into recharge_history set user_id='".$data['user_id']."',amount='".$data['amount']."',status='".$data['status']."',payment_method='razorpay',payment_id='".$data['payment_id']."',cdate='".$current."' ";
		        $insertQuery=query($insertSql);

		        if($insertQuery){
		        	$output['success'] = 1;
				    $output['msg'] = "wallet Recharge fail !!";
				    return $output;

		        }else{
		        	$output['success'] = 0;
				    $output['msg'] = "Something went wrong !!";
				    return $output;
		        }
		}
		

		

	}else{
		$output['success'] = 0;
		$output['msg'] = "User Not Found !!";
		return $output;
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getRechargeHistory&user_id=23
function getRechargeHistory($data)
{
	
	if($data['user_id']==Null  )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}else{
		$selectSql="select * from recharge_history where user_id='".$data['user_id']."' order by id desc  ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$record = array();
		    $i = 0;
		    while($row_data = mysqli_fetch_array($selectQuery))
			{
			  

		     $record[$i]['id'] = $row_data['id'];
			 $record[$i]['amount'] = $row_data['amount'];	
			 $record[$i]['status'] = $row_data['status'];
			 $record[$i]['cdate'] =change_date_view($row_data['cdate']);	
			 
			 $i++;
			}

			$output['recharge_history'] = $record;
			$output['success'] = 1;
			$output['msg'] = "Recharge History Fetch successfully !!";
			return $output;
			
		}else{
			$output['success'] = 0;
			$output['msg'] = "Recharge History Not Found !!";
			return $output;
		}
	}
	
}
/***********
recharge api end 
***********/

/***********
bid api start 
***********/
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=createBid
function createBid($data)
{
	$current=date('Y-m-d H:i:s');
	$endtime = date('Y-m-d H:i:s',strtotime('+2 minutes',strtotime($current)));
	$result_time = date('Y-m-d H:i:s',strtotime('+1 minutes +30 seconds',strtotime($current)));
	$insertSql="insert into bid set cdate='".$current."',end_datetime='".$endtime."',result_time='".$result_time."' ";
	$insertQuery=query($insertSql);
	$last_id=insert_id();

	$updateSql="UPDATE bid SET title='".date('dmY').$last_id."' where id='".$last_id."'";
	$updateRun=query($updateSql);
	if($updateRun){
		$output['success'] = 1;
		$output['msg'] = "Bid created successfully !!";
		return $output;

	}else{
		$output['success'] = 0;
		$output['msg'] = "Bid Not created !!";
		return $output;
	}


	
}


//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getOpenBid&user_id=45
function getOpenBid($data)
{
	if($data['user_id']==Null )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
	    $selectSql="select * from bid where status='0' ORDER by id DESC LIMIT 1";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$row=mysqli_fetch_array($selectQuery); 
			$result['id']=$row['id'];
			$result['title']=$row['title'];
			$result['cdate']=$row['cdate'];
			$result['end_datetime']=$row['end_datetime'];

			$diff=strtotime($row['end_datetime'])-strtotime(date('Y-m-d H:i:s')); 

			$result['difference_time']=$diff;

			if($data['other_page']==1){
				$selectSqlRecord="select * from bid_result order by id desc";
			}else{
				$selectSqlRecord="select * from bid_result order by id desc limit 10";
			}
			
		    $selectQueryRecord=query($selectSqlRecord);
		    $record = array();
		    $i = 0;
		    while($row_data = mysqli_fetch_array($selectQueryRecord))
			{
			 $selectSqlBid="select * from bid where id='".$row_data['bid_id']."' ";
		     $selectQueryBid=query($selectSqlBid);
		     $bidData=mysqli_fetch_array($selectQueryBid); 

		     $record[$i]['bid_title'] = $bidData['title'];
			 $record[$i]['price'] = $row_data['price'];	
			 
			 $selectSqlNumber="select * from number_list where id='".$row_data['number']."' ";
		     $selectQueryNumber=query($selectSqlNumber);
		     $numberData=mysqli_fetch_array($selectQueryNumber);
			 
			 $record[$i]['result_number'] = $numberData['number_name'];	
			 
			 $allColor = explode(",",$row_data['color']);
			 
			 $abccolor = array();
			 $j = 0;
			 foreach($allColor as $color){
			     
			   $selectSqlColor="select * from color where id='".$color."' ";
		       $selectQueryColor=query($selectSqlColor);
		       $colorData=mysqli_fetch_array($selectQueryColor);
		       $abccolor[$j]['mycolor']=$colorData['color_code'];
		       $j++;
			 }
			
			 
		     
			 $record[$i]['result_color'] = $abccolor;	
			 $i++;
			}

			
			$success=1;
			$msg="Bid found successfully !!";

		}else{
			$result='';
			$success=0;
			$msg = "Bid Not Found !!";
			
		} 
		$selectSqlUser="select * from  users where id='".real_sring($data['user_id'])."' ";
		$selectRunUser=query($selectSqlUser);
		$countUser=mysqli_num_rows($selectRunUser);
		if($countUser){
			 $rowUser=mysqli_fetch_array($selectRunUser); 
			 $output['wallet']=$rowUser['wallet'];
		}else{
			$output['wallet']='0.00';
		}

		$output['bid_content']=$result;
		$output['record_content']=$record;
		$output['success'] = $success;
		$output['msg'] = $msg;
		return $output;
	}
	
}
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=applyBid&user_id=23&bid_amount=50&bid_id=5&bid_type=0&bid_color=#00c41a&bid_number=
function applyBid($data)
{

    if($data['user_id']==Null || $data['bid_amount']==Null || $data['bid_id']==Null )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{  
		
		$current=date('Y-m-d H:i:s');
		$selectSql="select * from users where id='".$data['user_id']."' ";
        $selectQuery=query($selectSql);
        $count=mysqli_num_rows($selectQuery);
        if($count){
        	$row=mysqli_fetch_array($selectQuery);
        	
        	if($row['wallet'] >= $data['bid_amount']){
        		$bid_color='';
                if($data['bid_color']){ 
                	$bid_color=$data['bid_color'];
                }
                if($data['bid_amount'] < 100){
                	$cupoan_amount=($data['bid_amount'] * (10 / 100));

                }else{
                	$cupoan_amount=($data['bid_amount'] * (2 / 100));

                }
                $bid_real_amount=$data['bid_amount']-$cupoan_amount;
        		$insertSql="insert into apply_bid set user_id='".$data['user_id']."',bid_id='".$data['bid_id']."',bid_amount='".$data['bid_amount']."',bid_real_amount='".$bid_real_amount."',bid_type='".$data['bid_type']."',bid_color='".$bid_color."',bid_number='".$data['bid_number']."',apply_date='".$current."' ";
	            $insertQuery=query($insertSql);
	            $last_id=insert_id();


	            $newwallet=$row['wallet']-$data['bid_amount'];
	            $updateSql="update users set wallet='".$newwallet."' where id='".$data['user_id']."'";
                $updateRun=query($updateSql);

                /*if($data['bid_type']==0){
					$selectSqlColor="select * from color where id='".$data['bid_color']."' ";
				    $selectQueryColor=query($selectSqlColor);
				    $rowColor=mysqli_fetch_array($selectQueryColor); 
				    $updateColorAmount=$rowColor['apply_amount']+$data['bid_amount'];
				    $updateSqlColor="update color set apply_amount='".$updateColorAmount."' where id='".$data['bid_color']."'";
		            $updateRunColor=query($updateSqlColor);

				}else{
					$selectSqlNumber="select * from number_list where  id='".$data['bid_number']."' ";
				    $selectQueryNumber=query($selectSqlNumber);
				    $rowNumber=mysqli_fetch_array($selectQueryNumber); 
				    $updateNumberAmount=$rowNumber['apply_amount']+$data['bid_amount'];
				    $updateSqlNumber="update number_list set apply_amount='".$updateNumberAmount."' where id='".$data['bid_number']."'";
		            $updateRunNumber=query($updateSqlNumber);
				}*/

                $level_one=$row['level_one'];
                $level_two=$row['level_two'];

                $selectSqlPageContent="select * from page_content where id='1' ";
		        $selectQueryPageContent=query($selectSqlPageContent);
		        $rowPageContent=mysqli_fetch_array($selectQueryPageContent); 

		        if($level_one!=0){
		        	$level_one_amount =($rowPageContent['level_one_parcent'] / 100) * $bid_real_amount ;

		        	$selectSqllevel_one="select * from users where id='".$level_one."' ";
			        $selectQuerylevel_one=query($selectSqllevel_one);
			        $countlevel_one=mysqli_num_rows($selectQuerylevel_one);
			        if($countlevel_one){
			        	$rowlevel_one=mysqli_fetch_array($selectQuerylevel_one);

			        	$level_one_wallet=$rowlevel_one['wallet']+$level_one_amount;
			        	$updateSqllevel_one="update users set wallet='".$level_one_wallet."' where id='".$level_one."'";
                        $updateRunlevel_one=query($updateSqllevel_one);

                        $insertSqllevel_one="insert into referral_bid_record set bid_by='".$data['user_id']."', user_level_one='".$level_one."'	,amount='".$level_one_amount."',cdate='".$current."',bid_id='".$data['bid_id']."',apply_id='".$last_id."' ";
	                    $insertQuerylevel_one=query($insertSqllevel_one);


			        }

		        }

		        if($level_two!=0){
		        	$level_two_amount = ($rowPageContent['level_two_parcent'] / 100) * $bid_real_amount ;

		        	$selectSqllevel_two="select * from users where id='".$level_two."' ";
			        $selectQuerylevel_two=query($selectSqllevel_two);
			        $countlevel_two=mysqli_num_rows($selectQuerylevel_two);
			        if($countlevel_two){
			        	$rowlevel_two=mysqli_fetch_array($selectQuerylevel_two);

			        	$level_two_wallet=$rowlevel_two['wallet']+$level_two_amount;
			        	$updateSqllevel_two="update users set wallet='".$level_two_wallet."' where id='".$level_two."'";
                        $updateRunlevel_two=query($updateSqllevel_two);



                        $insertSqllevel_two="insert into referral_bid_record set bid_by='".$data['user_id']."', user_level_two='".$level_two."'	,amount='".$level_two_amount."',cdate='".$current."',bid_id='".$data['bid_id']."',apply_id='".$last_id."' ";
	                    $insertQuerylevel_two=query($insertSqllevel_two);

			        }
		        }
		        
		        

		        $output['success'] = 1;
		        $output['wallet'] = $newwallet;
				$output['msg'] = "Apply Bid successfully !!";
				return $output;

		       }else{
        		$output['success'] = 0;
				$output['msg'] = "Your wallet amount not sufficient !!";
				return $output;
        	}
        }else{
          $output['success'] = 0;
		  $output['msg'] = "User Not Found !!";
		  return $output;
        }

	}
  

}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=setBidresult
function setBidresult2($data)
{
	
	
	$current=date('Y-m-d H:i:s');
	$selectSql="select * from bid where status='0' and result_time < '".$current."' ORDER by id DESC LIMIT 1";
	$selectQuery=query($selectSql);
	$count=mysqli_num_rows($selectQuery);
	if($count > 0)
	{
		$row=mysqli_fetch_array($selectQuery); 

		$selectBidResultSql="select * from bid_result where bid_id='".$row['id']."' ";
	    $selectBidResultQuery=query($selectBidResultSql);
	    $countBidResult=mysqli_num_rows($selectBidResultQuery);
	    if($countBidResult==0){
	    	        $check=true;
			    	$selectSqlApplyBid="select * from apply_bid where bid_id='".$row['id']."'";
				    $selectQueryApplyBid=query($selectSqlApplyBid);
				    $countApplyBid=mysqli_num_rows($selectQueryApplyBid);
				    if($countApplyBid > 0){
				    	
						 $selectSqlNumberGreen="SELECT SUM(apply_amount) as total_amount FROM number_list  WHERE FIND_IN_SET('1', assign_color)";
				         $selectQueryNumberGreen=query($selectSqlNumberGreen);
				         $rowNumberGreen=mysqli_fetch_array($selectQueryNumberGreen); 
				         

				         $selectSqlNumberRed="SELECT SUM(apply_amount) as total_amount FROM number_list  WHERE FIND_IN_SET('2', assign_color)";
				         $selectQueryNumberRed=query($selectSqlNumberRed);
				         $rowNumberRed=mysqli_fetch_array($selectQueryNumberRed); 
				         

				         $selectSqlNumberVoilet="SELECT SUM(apply_amount) as total_amount FROM number_list  WHERE FIND_IN_SET('3', assign_color)";
				         $selectQueryNumberVoilet=query($selectSqlNumberVoilet);
				         $rowNumberVoilet=mysqli_fetch_array($selectQueryNumberVoilet); 
				         

		         		 $selectSqlColorGreen="SELECT *  FROM `color` where id='1' ";
			             $selectQueryColorGreen=query($selectSqlColorGreen);
			             $rowColorGreen=mysqli_fetch_array($selectQueryColorGreen); 
			             

			             $selectSqlColorRed="SELECT *  FROM `color` where id='2' ";
			             $selectQueryColorRed=query($selectSqlColorRed);
			             $rowColorRed=mysqli_fetch_array($selectQueryColorRed); 
			             

			             $selectSqlColorVoilet="SELECT *  FROM `color` where id='3' ";
			             $selectQueryColorVoilet=query($selectSqlColorVoilet);
			             $rowColorVoilet=mysqli_fetch_array($selectQueryColorVoilet); 
					             

					            $total_green = $rowNumberGreen['total_amount'] + $rowColorGreen['apply_amount'] ;
					            $total_red = $rowNumberRed['total_amount'] + $rowColorRed['apply_amount'] ;
								$total_voilet = $rowNumberVoilet['total_amount'] + $rowColorVoilet['apply_amount'] ;
								$array = array('1' => $total_green, '2' => $total_red, '3' => $total_voilet );
								
								$key = array_search(min($array), $array);
								
								if ($key == 3) {
									# code...

							        $array2 = array('1' => $total_green, '2' => $total_red);
							        $key2 = array_search(min($array2), $array2);
							        $final_color=$key2.','.$key;
							        $selectSqlFinalNumber="SELECT * FROM `number_list` where assign_color = '".$final_color."' ";
									$selectQueryFinalNumber=query($selectSqlFinalNumber);
				         			$rowFinalNumber=mysqli_fetch_array($selectQueryFinalNumber); 
									
									$final_number=$rowFinalNumber['id'];
								   // $bid_price= min($array2);


								}else{
									$final_color=$key;
									$selectSqlFinalNumber="SELECT * FROM `number_list` where apply_amount =  ( SELECT MIN(apply_amount) FROM number_list ) AND FIND_IN_SET('".$key."', assign_color) ";
									$selectQueryFinalNumber=query($selectSqlFinalNumber);
				         			$rowFinalNumber=mysqli_fetch_array($selectQueryFinalNumber); 
									
									$final_number=$rowFinalNumber['id'];
									//$bid_price= min($array);
								
				         		
								}
								
								

				    }else{
				    	
				    	 $check=fasle;
				    	 $selectSqlNumber="SELECT * FROM number_list  ORDER BY RAND() LIMIT 1";
				         $selectQueryNumber=query($selectSqlNumber);
				         $rowNumber=mysqli_fetch_array($selectQueryNumber); 

				         $final_color=$rowNumber['assign_color'];
                         $final_number=$rowNumber['id'];
                         

				    }
				    $selectSqlNumber_n="select * from number_list where id='".$final_number."' ";
				    $selectQueryNumber_n=query($selectSqlNumber_n);
				    $numberData_n=mysqli_fetch_array($selectQueryNumber_n);

				    $bid_price= '205'.rand(10,100).$numberData_n['number_name'];
					 
						

				    //add result
			        $insertSql="insert into bid_result set bid_id='".$row['id']."',price='".$bid_price."',number='".$final_number."',color='".$final_color."',created='".$current."' ";
	        		$insertQuery=query($insertSql);

	        		$updateSql="update bid set status='1',result_color='".$final_color."',result_number='".$final_number."' where id='".$row['id']."'";
            		$updateRun=query($updateSql);
            		
            		

            		if ($final_color == '1' || $final_color == '2') {
            			
            			$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$final_color."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalColor=query($selectSqlFinalColor);

            			$whilefirst='';
					    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
						{
						 $whilefirst=$row_data['id'].',';
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
            			 $selectQueryUser=query($selectSqlUser);
						 $rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			 $wallet = $rowUser['wallet'];
            			 $winAmount = $row_data['bid_real_amount'] * 2;
            			

            			 $newWalletAmount = $winAmount + $wallet;

            			 $updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
            			 $updateUserRun=query($updateSqlUser);
            			
						 $updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data['id']."' and bid_id='".$row['id']."'";
            			 $updateWinStatus=query($updateSqlWinStatus);
            			
						} 
						$whilefirst=rtrim($whilefirst, ',');
						$updateSqlfirst="update apply_bid set result_status = 0 where id NOT IN ('".$whilefirst."')  and bid_id='".$row['id']."' and result_status =''";
            			$updatefirst=query($updateSqlfirst);

						

					
            		} else {

	            			$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = 3 AND bid_id='".$row['id']."'";
	            			$selectQueryFinalColor=query($selectSqlFinalColor);
	            			$whilefirst='';
						    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
							{
								
							 $whilefirst=$row_data['id'].',';

							 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
	            			$selectQueryUser=query($selectSqlUser);
							$rowUser=mysqli_fetch_array($selectQueryUser); 
	            			
	            			$wallet = $rowUser['wallet'];
	            			$winAmount = $row_data['bid_real_amount'] * 4;
	            			

	            			$newWalletAmount = $winAmount + $wallet;

	            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
	            			$updateUserRun=query($updateSqlUser);
	            			
							$updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data['id']."' and bid_id='".$row['id']."'";
	            			$updateWinStatus=query($updateSqlWinStatus);
	            			
							} 
							$whilefirst=rtrim($whilefirst, ',');

							$updateSqlfirst="update apply_bid set result_status = 0 where id NOT IN ('".$whilefirst."')  and bid_id='".$row['id']."' and result_status =''";
            			    $updatefirst=query($updateSqlfirst);

							$second_color=explode(",",$final_color);


							$selectSqlFinalColor_second = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$second_color[0]."' AND bid_id='".$row['id']."'";
	            			$selectQueryFinalColor_second=query($selectSqlFinalColor_second);

	            			$whilesecond='';

						    while($row_data_second = mysqli_fetch_array($selectQueryFinalColor_second))
							{
								
							 $whilesecond=$row_data_second['id'].',';
							$selectSqlUser_second = "SELECT * FROM users  WHERE id = '".$row_data_second['user_id']."' ";
	            			$selectQueryUser_second=query($selectSqlUser_second);
							$rowUser_second=mysqli_fetch_array($selectQueryUser_second); 
	            			
	            			$wallet_second = $rowUser_second['wallet'];
	            			$winAmount_second = $row_data_second['bid_real_amount'] * 1.5;
	            			

	            			 $newWalletAmount_second = $winAmount_second + $wallet_second;

	            			$updateSqlUser_second="update users set wallet ='".$newWalletAmount_second."' where id='".$row_data_second['user_id']."'";
	            			$updateUserRun_second=query($updateSqlUser_second);
	            			
							$updateSqlWinStatus_second="update apply_bid set result_status = 1,win_amount='".$winAmount_second."' where id='".$row_data_second['id']."' and bid_id='".$row['id']."'";
	            			$updateWinStatus_second=query($updateSqlWinStatus_second);
	            			
							} 
							$whilesecond=rtrim($whilesecond, ',');
							$updateSqlsecond="update apply_bid set result_status = 0 where id NOT IN ('".$whilesecond."')  and bid_id='".$row['id']."' and result_status =''";
            			    $updatesecond=query($updateSqlsecond);

							

						}

						$selectSqlFinalNumber = "SELECT * FROM apply_bid  WHERE bid_type = 1 AND bid_number = '".$final_number." AND bid_id='".$row['id']."''";
            			$selectQueryFinalNumber=query($selectSqlFinalNumber);

            			$whilethree='';

					    while($row_data2 = mysqli_fetch_array($selectQueryFinalNumber))
						{
						 	
						$whilethree=$row_data2['id'].',';
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data2['user_id']."' ";
            			$selectQueryUser=query($selectSqlUser);
						$rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			$wallet = $rowUser['wallet'];
            			$winAmount = $row_data2['bid_real_amount'] * 9;
            			

            			$newWalletAmount = $winAmount + $wallet;

            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data2['user_id']."'";
            			$updateUserRun=query($updateSqlUser);
            			
						$updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data2['id']."' and bid_id='".$row['id']."'";
            			$updateWinStatus=query($updateSqlWinStatus);
            			
						}
						$whilethree=rtrim($whilethree, ',');
						$updateSqlthree="update apply_bid set result_status = 0 where id NOT IN ('".$whilethree."')  and bid_id='".$row['id']."' and result_status =''";
            			$updatethree=query($updateSqlthree);

						$updateSqlNumberData="update number_list set apply_amount ='0'";
            			$updateNumburRun=query($updateSqlNumberData);

            			$updateSqlColorData="update color set apply_amount ='0'";
            			$updateColorRun=query($updateSqlColorData);



	        		$output['success'] = 1;
		    		$output['msg'] = "Result generated successfully !!";
		    		return $output;

	    }else{
	    	$output['success'] = 0;
		    $output['msg'] = "Result already generated !!";
		    return $output;
	    }

		

	}else{
		$output['success'] = 0;
		$output['msg'] = "Bid Not Found !!";
		return $output;
	}
}

function setBidresult($data){
	$current=date('Y-m-d H:i:s');
	$selectSql="select * from bid where status='0' and result_time < '".$current."' ORDER by id DESC LIMIT 1";
	$selectQuery=query($selectSql);
	$count=mysqli_num_rows($selectQuery);
	if($count > 0)
	{
		$row=mysqli_fetch_array($selectQuery); 
		$selectBidResultSql="select * from bid_result where bid_id='".$row['id']."' ";
	    $selectBidResultQuery=query($selectBidResultSql);
	    $countBidResult=mysqli_num_rows($selectBidResultQuery);
	    if($countBidResult==0){

	    	$selectSqlApplyBid="select * from apply_bid where bid_id='".$row['id']."'";
		    $selectQueryApplyBid=query($selectSqlApplyBid);
		    $countApplyBid=mysqli_num_rows($selectQueryApplyBid);
		    if($countApplyBid > 0){
		    	    //Green
		    		$selectSqlGreen="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_color='1'";
				    $selectQueryGreen=query($selectSqlGreen);
				    $rowGreen=mysqli_fetch_array($selectQueryGreen);
				    if($rowGreen['total_amount'] > 0){
				    	 $bitGreenAmount=$rowGreen['total_amount'];
				         $bitGreenAllAmount=$rowGreen['total_amount']*2;
				        
				    }else{
				    	 $bitGreenAmount=0;
				         $bitGreenAllAmount=0;
				    }

				    //Red
		    		$selectSqlRed="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_color='2'";
				    $selectQueryRed=query($selectSqlRed);
				    $rowRed=mysqli_fetch_array($selectQueryRed);
				    if($rowRed['total_amount'] > 0){
				    	 $bitRedAmount=$rowRed['total_amount'];
				         $bitRedAllAmount=$rowRed['total_amount']*2;
				        
				    }else{
				    	 $bitRedAmount=0;
				         $bitRedAllAmount=0;
				    }

				    //Violet
		    		$selectSqlViolet="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_color='3'";
				    $selectQueryViolet=query($selectSqlViolet);
				    $rowViolet=mysqli_fetch_array($selectQueryViolet);
				    if($rowViolet['total_amount'] > 0){
				    	 $bitVioletAmount=$rowViolet['total_amount'];
				         $bitVioletAllAmount=$rowViolet['total_amount']*4.5;
				        
				    }else{
				    	 $bitVioletAmount=0;
				         $bitVioletAllAmount=0;
				    }


				    //zero
		    		$selectSqlZero="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='1'";
				    $selectQueryZero=query($selectSqlZero);
				    $rowZero=mysqli_fetch_array($selectQueryZero);
				    if($rowZero['total_amount'] > 0){
				    	 $bitZeroAmount=$rowZero['total_amount'];
				         $bitZeroAllAmount=$rowZero['total_amount']*9;
				        
				    }else{
				    	 $bitZeroAmount=0;
				         $bitZeroAllAmount=0;
				    }

				    //One
		    		$selectSqlOne="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='2'";
				    $selectQueryOne=query($selectSqlOne);
				    $rowOne=mysqli_fetch_array($selectQueryOne);
				    if($rowOne['total_amount'] > 0){
				    	 $bitOneAmount=$rowOne['total_amount'];
				         $bitOneAllAmount=$rowOne['total_amount']*9;
				        
				    }else{
				    	 $bitOneAmount=0;
				         $bitOneAllAmount=0;
				    }

				    //Two
		    		$selectSqlTwo="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='3'";
				    $selectQueryTwo=query($selectSqlTwo);
				    $rowTwo=mysqli_fetch_array($selectQueryTwo);
				    if($rowTwo['total_amount'] > 0){
				    	 $bitTwoAmount=$rowTwo['total_amount'];
				         $bitTwoAllAmount=$rowTwo['total_amount']*9;
				        
				    }else{
				    	 $bitTwoAmount=0;
				         $bitTwoAllAmount=0;
				    }

				     //Three
		    		$selectSqlThree="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='4'";
				    $selectQueryThree=query($selectSqlThree);
				    $rowThree=mysqli_fetch_array($selectQueryThree);
				    if($rowThree['total_amount'] > 0){
				    	 $bitThreeAmount=$rowThree['total_amount'];
				         $bitThreeAllAmount=$rowThree['total_amount']*9;
				        
				    }else{
				    	 $bitThreeAmount=0;
				         $bitThreeAllAmount=0;
				    }


				     //Four
		    		$selectSqlFour="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='5'";
				    $selectQueryFour=query($selectSqlFour);
				    $rowFour=mysqli_fetch_array($selectQueryFour);
				    if($rowFour['total_amount'] > 0){
				    	 $bitFourAmount=$rowFour['total_amount'];
				         $bitFourAllAmount=$rowFour['total_amount']*9;
				        
				    }else{
				    	 $bitFourAmount=0;
				         $bitFourAllAmount=0;
				    }

				    //Five
		    		$selectSqlFive="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='6'";
				    $selectQueryFive=query($selectSqlFive);
				    $rowFive=mysqli_fetch_array($selectQueryFive);
				    if($rowFive['total_amount'] > 0){
				    	 $bitFiveAmount=$rowFive['total_amount'];
				         $bitFiveAllAmount=$rowFive['total_amount']*9;
				        
				    }else{
				    	 $bitFiveAmount=0;
				         $bitFiveAllAmount=0;
				    }

				    //Six
		    		$selectSqlSix="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='7'";
				    $selectQuerySix=query($selectSqlSix);
				    $rowSix=mysqli_fetch_array($selectQuerySix);
				    if($rowSix['total_amount'] > 0){
				    	 $bitSixAmount=$rowSix['total_amount'];
				         $bitSixAllAmount=$rowSix['total_amount']*9;
				        
				    }else{
				    	 $bitSixAmount=0;
				         $bitSixAllAmount=0;
				    }

				    //Seven
		    		$selectSqlSeven="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='8'";
				    $selectQuerySeven=query($selectSqlSeven);
				    $rowSeven=mysqli_fetch_array($selectQuerySeven);
				    if($rowSeven['total_amount'] > 0){
				    	 $bitSevenAmount=$rowSeven['total_amount'];
				         $bitSevenAllAmount=$rowSeven['total_amount']*9;
				        
				    }else{
				    	 $bitSevenAmount=0;
				         $bitSevenAllAmount=0;
				    }

				    //Eight
		    		$selectSqlEight="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='9'";
				    $selectQueryEight=query($selectSqlEight);
				    $rowEight=mysqli_fetch_array($selectQueryEight);
				    if($rowEight['total_amount'] > 0){
				    	 $bitEightAmount=$rowEight['total_amount'];
				         $bitEightAllAmount=$rowEight['total_amount']*9;
				        
				    }else{
				    	 $bitEightAmount=0;
				         $bitEightAllAmount=0;
				    }

				    //Nine
		    		$selectSqlNine="SELECT SUM(bid_real_amount) as total_amount FROM apply_bid  WHERE bid_id='".$row['id']."' and  bid_number='10'";
				    $selectQueryNine=query($selectSqlNine);
				    $rowNine=mysqli_fetch_array($selectQueryNine);
				    if($rowNine['total_amount'] > 0){
				    	 $bitNineAmount=$rowNine['total_amount'];
				         $bitNineAllAmount=$rowNine['total_amount']*9;
				        
				    }else{
				    	 $bitNineAmount=0;
				         $bitNineAllAmount=0;
				    }
				    $totalnumberAmount=$bitZeroAllAmount+$bitOneAllAmount+$bitTwoAllAmount+$bitThreeAllAmount+$bitFourAllAmount+$bitFiveAllAmount+$bitSixAllAmount+$bitSevenAllAmount+$bitEightAllAmount+$bitNineAllAmount;

				    $totalcolorAmount=$bitGreenAllAmount+$bitRedAllAmount+$bitVioletAllAmount;

				    /*if($totalnumberAmount==0){
				    	$greenNumberArray=array('2'=>$bitOneAllAmount,'4'=>$bitThreeAllAmount,'8'=>$bitSevenAllAmount,'10'=>$bitNineAllAmount);
				        $redNumberArray=array('3'=>$bitTwoAllAmount,'5'=>$bitFourAllAmount,'7'=>$bitSixAllAmount,'9'=>$bitEightAllAmount);

				    }else{

				    	if($totalcolorAmount==0){
                            $greenNumberArray=array('2'=>$bitOneAllAmount,'4'=>$bitThreeAllAmount,'8'=>$bitSevenAllAmount,'10'=>$bitNineAllAmount);
				            $redNumberArray=array('3'=>$bitTwoAllAmount,'5'=>$bitFourAllAmount,'7'=>$bitSixAllAmount,'9'=>$bitEightAllAmount);
				    	}else{
				    		$greenNumberArray=array('2'=>$bitOneAllAmount,'4'=>$bitThreeAllAmount,'6'=>$bitFiveAllAmount,'8'=>$bitSevenAllAmount,'10'=>$bitNineAllAmount);
				            $redNumberArray=array('1'=>$bitZeroAllAmount,'3'=>$bitTwoAllAmount,'5'=>$bitFourAllAmount,'7'=>$bitSixAllAmount,'9'=>$bitEightAllAmount);
				    	}
				    	
				    }*/
				    $greenNumberArray=array('2'=>$bitOneAllAmount,'4'=>$bitThreeAllAmount,'8'=>$bitSevenAllAmount,'10'=>$bitNineAllAmount);
				        $redNumberArray=array('3'=>$bitTwoAllAmount,'5'=>$bitFourAllAmount,'7'=>$bitSixAllAmount,'9'=>$bitEightAllAmount);


				    
				    $minGreenNumberAmount=  min($greenNumberArray);
				    $totalGreenNumberAmount= $bitGreenAllAmount+$minGreenNumberAmount;
                   $greenNumber=array_keys($greenNumberArray, min($greenNumberArray));
				    $greenNumberKey=$greenNumber[0];

				    
				    
				    
				    $minRedNumberAmount= min($redNumberArray);
				    $totalRedNumberAmount= $bitRedAllAmount+$minRedNumberAmount;

				    $redNumber=array_keys($redNumberArray, min($redNumberArray));
				    $redNumberKey=$redNumber[0];

				    $forvoiletgreen=($bitGreenAmount*1.5)+$bitFiveAllAmount;
				    $forvoiletred=($$bitRedAmount*1.5)+$bitZeroAllAmount;
				    $voiletColorArray=array('1'=>$forvoiletgreen,'2'=>$forvoiletred);
				   
				    $secondColor=array_keys($voiletColorArray, min($voiletColorArray));
				    $secondColorKey=$secondColor[0];
				    if($secondColorKey==1){
				    	$minvoiletNumberAmount=$bitFiveAllAmount;
				    	$secondColorAmount=$bitGreenAmount*1.5;
				    	$voiletNumberKey='6';
				    }else{
				    	$minvoiletNumberAmount=$bitZeroAllAmount;
				    	$secondColorAmount=$bitRedAmount*1.5;
				    	$voiletNumberKey='1';
				    }

				    $totalvoiletOtherNumberAmount= $bitVioletAllAmount+$minvoiletNumberAmount+$secondColorAmount;

				    


				    $priceCombinationArray=array('1'=>$totalGreenNumberAmount,'2'=>$totalRedNumberAmount,'3'=>$totalvoiletOtherNumberAmount);
				    $priceCombination=array_keys($priceCombinationArray, min($priceCombinationArray));
				    $priceCombinationKey=$priceCombination[0];
				    /*$priceCombinationKey=3;*/
				    
				    if($priceCombinationKey==1){
				    	$real_price=$totalGreenNumberAmount;
				    	$final_color=1;
				    	$final_number=$greenNumberKey;

				    	//color
				    	$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$final_color."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalColor=query($selectSqlFinalColor);

            			$whilefirst='';
					    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
						{
						 $whilefirst .=$row_data['id'].',';
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
            			 $selectQueryUser=query($selectSqlUser);
						 $rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			 $wallet = $rowUser['wallet'];
            			 $winAmount = $row_data['bid_real_amount'] * 2;
            			

            			 $newWalletAmount = $winAmount + $wallet;

            			 $updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
            			 $updateUserRun=query($updateSqlUser);
            			
						 $updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data['id']."' and bid_id='".$row['id']."'";
            			 $updateWinStatus=query($updateSqlWinStatus);
            			
						} 
						$whilefirst=rtrim($whilefirst, ',');
						 
						$updateSqlfirst="update apply_bid set result_status = 0 where id NOT IN ('".$whilefirst."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=0";
            			$updatefirst=query($updateSqlfirst);


            			//number
            			$selectSqlFinalNumber = "SELECT * FROM apply_bid  WHERE bid_type = 1 AND bid_number = '".$final_number."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalNumber=query($selectSqlFinalNumber);

            			$whilesecond='';

					    while($row_data2 = mysqli_fetch_array($selectQueryFinalNumber))
						{
						 	
						$whilesecond .=$row_data2['id'].',';
						$selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data2['user_id']."' ";
            			$selectQueryUser=query($selectSqlUser);
						$rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			$wallet = $rowUser['wallet'];
            			$winAmount = $row_data2['bid_real_amount'] * 9;
            			

            			$newWalletAmount = $winAmount + $wallet;

            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data2['user_id']."'";
            			$updateUserRun=query($updateSqlUser);
            			
						$updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data2['id']."' and bid_id='".$row['id']."'";
            			$updateWinStatus=query($updateSqlWinStatus);
            			
						}
						$whilesecond=rtrim($whilesecond, ',');
						$updateSqlthree="update apply_bid set result_status = 0 where id NOT IN ('".$whilesecond."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=1";
            			$updatethree=query($updateSqlthree);

				    }else if($priceCombinationKey==2){
				    	$real_price=$totalRedNumberAmount;
				    	$final_color=2;
				    	$final_number=$redNumberKey;
				    	

				    	//color
				    	$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$final_color."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalColor=query($selectSqlFinalColor);

            			$whilefirst='';
					    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
						{
						 $whilefirst .=$row_data['id'].',';
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
            			 $selectQueryUser=query($selectSqlUser);
						 $rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			 $wallet = $rowUser['wallet'];
            			 $winAmount = $row_data['bid_real_amount'] * 2;
            			

            			 $newWalletAmount = $winAmount + $wallet;

            			 $updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
            			 $updateUserRun=query($updateSqlUser);
            			
						 $updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data['id']."' and bid_id='".$row['id']."'";
            			 $updateWinStatus=query($updateSqlWinStatus);
            			
						} 
						$whilefirst=rtrim($whilefirst, ',');
						 
						$updateSqlfirst="update apply_bid set result_status = 0 where id NOT IN ('".$whilefirst."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=0";
            			$updatefirst=query($updateSqlfirst);

            			//number
            			$selectSqlFinalNumber = "SELECT * FROM apply_bid  WHERE bid_type = 1 AND bid_number = '".$final_number."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalNumber=query($selectSqlFinalNumber);

            			$whilesecond='';

					    while($row_data2 = mysqli_fetch_array($selectQueryFinalNumber))
						{
						 	
						$whilesecond .=$row_data2['id'].',';
						$selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data2['user_id']."' ";
            			$selectQueryUser=query($selectSqlUser);
						$rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			$wallet = $rowUser['wallet'];
            			$winAmount = $row_data2['bid_real_amount'] * 9;
            			

            			$newWalletAmount = $winAmount + $wallet;

            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data2['user_id']."'";
            			$updateUserRun=query($updateSqlUser);
            			
						$updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data2['id']."' and bid_id='".$row['id']."'";
            			$updateWinStatus=query($updateSqlWinStatus);
            			
						}
						$whilesecond=rtrim($whilesecond, ',');
						$updateSqlthree="update apply_bid set result_status = 0 where id NOT IN ('".$whilesecond."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=1";
            			$updatethree=query($updateSqlthree);

				    }else if($priceCombinationKey==3){
				    	$real_price=$totalvoiletOtherNumberAmount;
				    	$final_color='3,'.$secondColorKey;
				    	$final_number=$voiletNumberKey;
				    	$main_color=3;
				    	$sub_color=$secondColorKey;

				    	//color
				    	$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$main_color."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalColor=query($selectSqlFinalColor);

            			$whilefirst='';
					    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
						{
						 $whilefirst .=$row_data['id'].',';
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
            			 $selectQueryUser=query($selectSqlUser);
						 $rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			 $wallet = $rowUser['wallet'];
            			 $winAmount = $row_data['bid_real_amount'] * 4.5;
            			

            			 $newWalletAmount = $winAmount + $wallet;

            			 $updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
            			 $updateUserRun=query($updateSqlUser);
            			
						 $updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data['id']."' and bid_id='".$row['id']."'";
            			 $updateWinStatus=query($updateSqlWinStatus);
            			
						} 
						$whilefirst=rtrim($whilefirst, ',');
						 
						$updateSqlfirst="update apply_bid set result_status = 0 where id NOT IN ('".$whilefirst."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=0 and bid_color !='".$sub_color."'";
            			$updatefirst=query($updateSqlfirst);

            			//number
            			$selectSqlFinalNumber = "SELECT * FROM apply_bid  WHERE bid_type = 1 AND bid_number = '".$final_number."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalNumber=query($selectSqlFinalNumber);

            			$whilesecond='';

					    while($row_data2 = mysqli_fetch_array($selectQueryFinalNumber))
						{
						 	
						$whilesecond .=$row_data2['id'].',';
						$selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data2['user_id']."' ";
            			$selectQueryUser=query($selectSqlUser);
						$rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			$wallet = $rowUser['wallet'];
            			$winAmount = $row_data2['bid_real_amount'] * 9;
            			

            			$newWalletAmount = $winAmount + $wallet;

            			$updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data2['user_id']."'";
            			$updateUserRun=query($updateSqlUser);
            			
						$updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data2['id']."' and bid_id='".$row['id']."'";
            			$updateWinStatus=query($updateSqlWinStatus);
            			
						}
						$whilesecond=rtrim($whilesecond, ',');
						$updateSqlthree="update apply_bid set result_status = 0 where id NOT IN ('".$whilesecond."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=1";
            			$updatethree=query($updateSqlthree);

            			//subcolor
            			$selectSqlFinalColor = "SELECT * FROM apply_bid  WHERE bid_type = 0 AND bid_color = '".$sub_color."' AND bid_id='".$row['id']."'";
            			$selectQueryFinalColor=query($selectSqlFinalColor);

            			$whilefirst='';
					    while($row_data = mysqli_fetch_array($selectQueryFinalColor))
						{
						 $whilefirst .=$row_data['id'].',';
						 $selectSqlUser = "SELECT * FROM users  WHERE id = '".$row_data['user_id']."' ";
            			 $selectQueryUser=query($selectSqlUser);
						 $rowUser=mysqli_fetch_array($selectQueryUser); 
            			
            			 $wallet = $rowUser['wallet'];
            			 $winAmount = $row_data['bid_real_amount'] * 1.5;
            			

            			 $newWalletAmount = $winAmount + $wallet;

            			 $updateSqlUser="update users set wallet ='".$newWalletAmount."' where id='".$row_data['user_id']."'";
            			 $updateUserRun=query($updateSqlUser);
            			
						 $updateSqlWinStatus="update apply_bid set result_status = 1,win_amount='".$winAmount."' where id='".$row_data['id']."' and bid_id='".$row['id']."'";
            			 $updateWinStatus=query($updateSqlWinStatus);
            			
						} 
						 $whilefirst=rtrim($whilefirst, ',');
						 
						$updateSqlfirst="update apply_bid set result_status = 0 where id NOT IN ('".$whilefirst."')  and bid_id='".$row['id']."' and result_status ='' and bid_type=0 ";
            			$updatefirst=query($updateSqlfirst);
				    }




		    }else{
				    	
		    	 
		    	 $selectSqlNumber="SELECT * FROM number_list  ORDER BY RAND() LIMIT 1";
		         $selectQueryNumber=query($selectSqlNumber);
		         $rowNumber=mysqli_fetch_array($selectQueryNumber); 

		         $final_number=$rowNumber['id'];
		         
		         $final_color=$rowNumber['assign_color'];
		         $real_price=0;
                 
                 

		    }

		     $selectSqlNumber_n="select * from number_list where id='".$final_number."' ";
	         $selectQueryNumber_n=query($selectSqlNumber_n);
	         $numberData_n=mysqli_fetch_array($selectQueryNumber_n);
	         $bid_price= '205'.rand(10,100).$numberData_n['number_name'];
	         
		    

		    
			 //add result
	        $insertSql="insert into bid_result set bid_id='".$row['id']."',price='".$bid_price."',real_price='".$real_price."',number='".$final_number."',color='".$final_color."',created='".$current."' ";
    		$insertQuery=query($insertSql);

    		$updateSql="update bid set status='1',result_color='".$final_color."',result_number='".$final_number."',price='".$bid_price."',real_price='".$real_price."' where id='".$row['id']."'";
    		$updateRun=query($updateSql);

    		$output['success'] = 1;
    		$output['msg'] = "Result generated successfully !!";
    		return $output;

	    }else{
	    	$output['success'] = 0;
		    $output['msg'] = "Result already generated !!";
		    return $output;
	    }

	}else{
		$output['success'] = 0;
		$output['msg'] = "Bid Not Found !!";
		return $output;
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getBidHistory&user_id=32
function getBidHistory($data)
{
	if($data['user_id']==Null  )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSql="select * from apply_bid where user_id = '".$data['user_id']."' and result_status!='' order by id desc ";
	    $selectQuery=query($selectSql);
	    $countone=mysqli_num_rows($selectQuery);
	    if($countone){
	    	$record = array();
		    $i = 0;
		    while($row_data = mysqli_fetch_array($selectQuery))
			{

			 $record[$i]['id'] = $row_data['id'];	
			 $record[$i]['bid_amount'] = $row_data['bid_amount'];	
			 $record[$i]['create_time'] = change_date_view($row_data['apply_date']);

			 $selectSqlBid="select * from bid where id='".$row_data['bid_id']."' ";
		     $selectQueryBid=query($selectSqlBid);
		     $bidData=mysqli_fetch_array($selectQueryBid); 

		     $record[$i]['period'] = $bidData['title'];
		     if($row_data['bid_type']==0){
		     	 $selectSqlColor="select * from color where id='".$row_data['bid_color']."' ";
			     $selectQueryColor=query($selectSqlColor);
			     $colorData=mysqli_fetch_array($selectQueryColor);
			     $retrunSelect='<span style="color:'.$colorData['color_code'].';">'.$colorData['color_name'].'</span>';
		     	
		     }else{
		     	 $selectSqlNumber="select * from number_list where id='".$row_data['bid_number']."' ";
			     $selectQueryNumber=query($selectSqlNumber);
			     $numberData=mysqli_fetch_array($selectQueryNumber);
			     $retrunSelect=$numberData['number_name'];
		     }

		     $record[$i]['select'] = $retrunSelect;

		     if($row_data['result_status']==1){
		     	 
			     $record[$i]['status'] ='<span style="color:#00c41a;">Success</span>';

			     $record[$i]['amount'] = '<span style="color:#00c41a;">+'.$row_data['win_amount'].'</span>';
		     	
		     }else{
		     	 $record[$i]['status'] ='<span style="color:#ff0000;">Fail</span>';

		     	 $record[$i]['amount'] = '<span style="color:#ff0000;">-'.$row_data['bid_real_amount'].'</span>';
		     }
		         $record[$i]['delivery'] = $row_data['bid_real_amount'];
		         
		         $fee=$row_data['bid_amount']-$row_data['bid_real_amount'];
		         $record[$i]['fee'] = ''.$fee.'';


		         $selectSqlBidResult="select * from bid_result where bid_id='".$row_data['bid_id']."' ";
		         $selectQueryBidResult=query($selectSqlBidResult);
		         $BidResultData=mysqli_fetch_array($selectQueryBidResult);

		         $record[$i]['openprice'] = $BidResultData['price'];

		         $selectSqlResultNumber="select * from number_list where id='".$BidResultData['number']."' ";
			     $selectQueryResultNumber=query($selectSqlResultNumber);
			     $ResultNumberData=mysqli_fetch_array($selectQueryResultNumber);

		         $record[$i]['result_number'] = $ResultNumberData['number_name'];

                 
                 $allColor = explode(",",$BidResultData['color']);
		 
				 $abccolor = '';
				 $j = 0;
				 foreach($allColor as $color){
				     
				   $selectSqlColor="select * from color where id='".$color."' ";
			       $selectQueryColor=query($selectSqlColor);
			       $colorData=mysqli_fetch_array($selectQueryColor);
			       
			       $abccolor .='<span style="color:'.$colorData['color_code'].';">'.$colorData['color_name'].'</span> ';
			       $j++;
				 }

		         /*$selectSqlResultColor="select * from color where id='".$BidResultData['color']."' ";
			     $selectQueryResultColor=query($selectSqlResultColor);
			     $ResultColorData=mysqli_fetch_array($selectQueryResultColor);*/

		         $record[$i]['result_color'] = $abccolor;


			 
			 
			  	
			 $i++;
			}
			$output['bid_result_record'] = $record;
		    $output['success'] = 1;
			$output['msg'] = "Fetch Record successfully !!";
			return $output;



	    }else{
	    	$output['success'] = 0;
		    $output['msg'] = "Record Not Found !!";
		    return $output;
	    }
	}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getReferralRecord&user_id=32
function getReferralRecord($data)
{

    if($data['user_id']==Null  )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}
	else 
	{
		$selectSqlone="select * from users where level_one = '".$data['user_id']."' ";
	    $selectQueryone=query($selectSqlone);
	    $countone=mysqli_num_rows($selectQueryone);
	    $levelonecount=0;
	    $leveloneamount=0;
	    if($countone){
	     $levelonecount=$countone;	
	     $selectSqloner="select *,sum(amount) as total_amount from referral_bid_record where user_level_one = '".$data['user_id']."' ";
	     $selectQueryoner=query($selectSqloner);
	     $rowoner= mysqli_fetch_array($selectQueryoner);
	     $leveloneamount =$rowoner['total_amount'];
         
         
	    }

	    $selectSqltwo="select * from users where level_two = '".$data['user_id']."' ";
	    $selectQuerytwo=query($selectSqltwo);
	    $counttwo=mysqli_num_rows($selectQuerytwo);
	    $leveltwocount=0;
	    $leveltwoamount=0;
	    if($counttwo){
        $leveltwocount=$counttwo;

        $selectSqltwor="select *,sum(amount) as total_amount from referral_bid_record where user_level_two = '".$data['user_id']."' ";
	    $selectQuerytwor=query($selectSqltwor);
	    $rowtwor= mysqli_fetch_array($selectQuerytwor);
	    $leveltwoamount =$rowtwor['total_amount'];
         
	    }

	    $leveloneamountc=0;
        if(!empty($leveloneamount)){
        	$leveloneamountc=$leveloneamount;
        }

        $leveltwoamountc=0;
        if(!empty($leveltwoamount)){
        	$leveltwoamountc=$leveltwoamount;
        }
	    $output['levelonecount'] = $levelonecount;
	    $output['leveloneamount'] = $leveloneamountc;
	    $output['leveltwocount'] = $leveltwocount;
	    $output['leveltwoamount'] = $leveltwoamountc;
	    $output['success'] = 1;
		$output['msg'] = "Fetch Data successfully !!";
		return $output;

	}
}

/***********
bid api end 
***********/


/***********
other  api start 
***********/


//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getCountries
function getCountries($data)
{
	    $selectSql="select * from countries";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$record = array();
		    $i = 0;
		    while($row_data = mysqli_fetch_array($selectQuery))
			{
			  

		     $record[$i]['id'] = $row_data['id'];
			 $record[$i]['sortname'] = $row_data['sortname'];	
			 $record[$i]['name'] = $row_data['name'];
			 	
			 
			 $i++;
			}

			$output['countries'] = $record;
			$output['success'] = 1;
			$output['msg'] = "Countries Fetch successfully !!";
			return $output;
			
		}else{
			$output['success'] = 0;
			$output['msg'] = "Countries Not Found !!";
			return $output;
		}
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getStates&country_id=101
function getStates($data)
{
	    if($data['country_id']==Null  )
		{
			$output['success'] = 0;
			$output['msg'] = "Check Parameter !!";
			return $output;
		}
		else 
		{
			$selectSql="select * from states where country_id='".$data['country_id']."'";
			$selectQuery=query($selectSql);
			$count=mysqli_num_rows($selectQuery);
			if($count > 0)
			{
				$record = array();
			    $i = 0;
			    while($row_data = mysqli_fetch_array($selectQuery))
				{
				  

			     $record[$i]['id'] = $row_data['id'];
				 $record[$i]['name'] = $row_data['name'];	
				 $record[$i]['country_id'] = $row_data['country_id'];
				 	
				 
				 $i++;
				}

				$output['states'] = $record;
				$output['success'] = 1;
				$output['msg'] = "States Fetch successfully !!";
				return $output;
				
			}else{
				$output['success'] = 0;
				$output['msg'] = "states Not Found !!";
				return $output;
			}
		}
	   
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getCities&state_id=5
function getCities($data)
{
	    if($data['state_id']==Null  )
		{
			$output['success'] = 0;
			$output['msg'] = "Check Parameter !!";
			return $output;
		}
		else 
		{
			$selectSql="select * from cities where state_id='".$data['state_id']."'";
			$selectQuery=query($selectSql);
			$count=mysqli_num_rows($selectQuery);
			if($count > 0)
			{
				$record = array();
			    $i = 0;
			    while($row_data = mysqli_fetch_array($selectQuery))
				{
				  

			     $record[$i]['id'] = $row_data['id'];
				 $record[$i]['name'] = $row_data['name'];	
				 $record[$i]['state_id'] = $row_data['state_id'];
				 	
				 
				 $i++;
				}

				$output['cities'] = $record;
				$output['success'] = 1;
				$output['msg'] = "States Fetch successfully !!";
				return $output;
				
			}else{
				$output['success'] = 0;
				$output['msg'] = "Cities Not Found !!";
				return $output;
			}
		}
	   
}
//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=withdrawalRequst&user_id=5&bank_upi=0&amount=100
function withdrawalRequst($data){
		
		
		   if($data['user_id']==Null ||  $data['bank_upi']==Null ||  $data['amount']==Null)
		   {
				$output['success'] = 0;
				$output['msg'] = "Check Parameter !!";
				return $output;
		   }else{
		   		$current=date('Y-m-d H:i:s');
		   		$todays= strtolower(date ('l'));
		   		//$currentTime=date('H:i');
		   		$currentTime='11:00';
		   		$selectSql="select * from users where id='".$data['user_id']."' ";
		        $selectQuery=query($selectSql);
		        $count=mysqli_num_rows($selectQuery);
		        if($count){

		        	  $userData= mysqli_fetch_array($selectQuery);
	                  $wallet =$userData['wallet'];
	                  if($data['amount'] <= $wallet){
	                  	$selectSqlContent="select * from  other_content where id='1' ";
		                $selectRunContent=query($selectSqlContent);
		                $rowContent=mysqli_fetch_array($selectRunContent);
	                  	 if($wallet >= $rowContent['minimum_amount']){

	                  	 	 if($data['amount'] <= $rowContent['maximum_amount']){

	                  	 	 	if($todays == "sunday")
								{
						            $output['success'] = 0;
							        $output['msg'] = $todays." is weekend so withdrawal Request not accepted !!";
							        return $output;
						        }else
								{
						             if(($currentTime >= '10:00') && ($currentTime <= '17:00') ){

						             	/*payment hook*/
						             	     if($data['amount'] <= $rowContent['amount_first']){
						             	     	$charge=$rowContent['fee_first'];
						             	     	$wamount=$data['amount']-$charge;
						             	     }else{
						             	     	$charge = round(($rowContent['fee_second'] / 100) * $data['amount']);
						             	     	$wamount=$data['amount']-$charge;
						             	     }
											 if($data['bank_upi']==0){
												 	if($userData['account_number']){
                                                              $curl = curl_init();

															  curl_setopt_array($curl, array(
															  CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
															  CURLOPT_RETURNTRANSFER => true,
															  CURLOPT_ENCODING => '',
															  CURLOPT_MAXREDIRS => 10,
															  CURLOPT_TIMEOUT => 0,
															  CURLOPT_FOLLOWLOCATION => true,
															  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
															  CURLOPT_CUSTOMREQUEST => 'POST',
															  CURLOPT_POSTFIELDS =>'{
															    "account_number":"2323230063947344",
															    "amount":'.$wamount.',
															    "currency":"INR",
															    "mode":"NEFT",
															    "purpose":"payout",
															    "fund_account":{
															        "account_type":"bank_account",
															        "bank_account":{
													                 "name":"'.$userData['holder_name'].'",
													                 "ifsc":"'.$userData['ifsc_code'].'",
													                 "account_number":"'.$userData['account_number'].'"
													                },
															        "contact":{
															            "name":"'.$userData['name'].'",
															            "email":"'.$userData['email'].'",
															            "contact":"'.$userData['mobile_number'].'",
															            "type":"customer"
															        }
															    }
															}',
															  CURLOPT_HTTPHEADER => array(
															    'X-Payout-Idempotency: ',
															    'Authorization: Basic cnpwX3Rlc3RfYmFtNEs1TGkwZ2lUVWI6WDI3dFptRDR4eVE0ZzBONXpwRnVMQVIw',
															    'Content-Type: application/json'
															  ),
															)); 
															$response = curl_exec($curl);

															curl_close($curl);
															$responseData=json_decode($response);
															
															if(empty($responseData->error)){
															$updatedwallet=$wallet-$data['amount'];
															$updateSql="UPDATE users SET wallet='".$updatedwallet."' where id='".$data['user_id']."'";
			                                                $updateRun=query($updateSql);

			                                                $insertSql="insert into withdrawal_history set user_id='".$data['user_id']."', pay_id='".$responseData->id."',amount='".$data['amount']."',currency='".$responseData->currency."',charge='".$charge."',status='".$responseData->status."',mode='".$responseData->mode."',by_with='bank_transfer', created='".$current."'";
			                                                $insertQuery=query($insertSql);

			                                                $to = $userData['email'];
													        $subject = 'Withdrawal Confirmation !!';
													        $contant = 'Hello '.$userData['name'].', ! <br><br>';
															$contant.='<p>You have Withdrawal '.$responseData->amount.' rs successfully.</p>'; 

														    Send_mail($to,$subject,$contant);


															$output['success'] = 1;
															$output['wallet'] = $updatedwallet;
															$output['msg'] = "Amount withdrawal successfully !!";
															return $output;


															}else{
																$output['success'] = 0;
										                        $output['msg'] = $responseData->error->description;
										                        return $output;
															}


															

												 	}else{
												 		$output['success'] = 0;
										                $output['msg'] = "Please add bank account detail !!";
										                return $output;
												 	}
												       
												}else{

													if($userData['upi']){

														$curl = curl_init();

														  curl_setopt_array($curl, array(
														  CURLOPT_URL => 'https://api.razorpay.com/v1/payouts',
														  CURLOPT_RETURNTRANSFER => true,
														  CURLOPT_ENCODING => '',
														  CURLOPT_MAXREDIRS => 10,
														  CURLOPT_TIMEOUT => 0,
														  CURLOPT_FOLLOWLOCATION => true,
														  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
														  CURLOPT_CUSTOMREQUEST => 'POST',
														  CURLOPT_POSTFIELDS =>'{
														    "account_number":"2323230063947344",
														    "amount":'.$wamount.',
														    "currency":"INR",
														    "mode":"UPI",
														    "purpose":"payout",
														    "fund_account":{
														        "account_type":"vpa",
														        "vpa":{
														            "address":"'.$userData['upi'].'"
														        },
														        "contact":{
															            "name":"'.$userData['name'].'",
															            "email":"'.$userData['email'].'",
															            "contact":"'.$userData['mobile_number'].'",
															            "type":"customer"
															     }
														    }
														}',
														  CURLOPT_HTTPHEADER => array(
														    'X-Payout-Idempotency: ',
														    'Authorization: Basic cnpwX3Rlc3RfYmFtNEs1TGkwZ2lUVWI6WDI3dFptRDR4eVE0ZzBONXpwRnVMQVIw',
														    'Content-Type: application/json'
														  ),
														));  
														$response = curl_exec($curl);

														curl_close($curl);
														$responseData=json_decode($response);
														if(empty($responseData->error)){
														$updatedwallet=$wallet-$data['amount'];
														$updateSql="UPDATE users SET wallet='".$updatedwallet."' where id='".$data['user_id']."'";
		                                                $updateRun=query($updateSql);

		                                                $insertSql="insert into withdrawal_history set user_id='".$data['user_id']."', pay_id='".$responseData->id."',amount='".$data['amount']."',currency='".$responseData->currency."',charge='".$charge."',status='".$responseData->status."',mode='".$responseData->mode."',by_with='upi_transfer', created='".$current."'";
		                                                $insertQuery=query($insertSql);

		                                                $to = $userData['email'];
												        $subject = 'Withdrawal Confirmation !!';
												        $contant = 'Hello '.$userData['name'].', ! <br><br>';
														$contant.='<p>You have Withdrawal '.$responseData->amount.' rs successfully.</p>'; 

													    Send_mail($to,$subject,$contant);


														$output['success'] = 1;
														$output['wallet'] = $updatedwallet;
														$output['msg'] = "Amount withdrawal successfully !!";
														return $output;


														}else{
															$output['success'] = 0;
									                        $output['msg'] = $responseData->error->description;
									                        return $output;
														}
														

													}else{
												 		$output['success'] = 0;
										                $output['msg'] = "Please add upi detail !!";
										                return $output;
												 	}

													      
											  }
											  

											
						             	/*payment hook*/

						             }else{
						             	$output['success'] = 0;
						                $output['msg'] = "Withdrawal Request accept between 10:00 AM To 05:00 PM !!";
						                return $output;
						             }
						        }

	                  	 	 }else{
	                  	 	 	$output['success'] = 0;
						        $output['msg'] = "You can maximum withdrawal 50K in one time";
						        return $output;
	                  	 	 }

	                  	 }else{
	                  	 	$output['success'] = 0;
						    $output['msg'] = "Wallet should have 500 rs. minimum !!";
						    return $output;
	                  	 }

	                  }else{
	                  	 $output['success'] = 0;
						 $output['msg'] = "Sufficient amount not found in wallet !!";
						 return $output;
	                  }


		        	


		        }else{

				$output['success'] = 0;
				$output['msg'] = "User Not Found !!";
				return $output;
			    }

		  	   

		  }
		  



  
}



//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=getwithdrawalHistory&user_id=32
function getwithdrawalHistory($data)
{
	
	if($data['user_id']==Null  )
	{
		$output['success'] = 0;
		$output['msg'] = "Check Parameter !!";
		return $output;
	}else{
		$selectSql="select * from withdrawal_history where user_id='".$data['user_id']."' order by id desc ";
		$selectQuery=query($selectSql);
		$count=mysqli_num_rows($selectQuery);
		if($count > 0)
		{
			$record = array();
		    $i = 0;
		    while($row_data = mysqli_fetch_array($selectQuery))
			{
			  

		     $record[$i]['id'] = $row_data['id'];
			 $record[$i]['pay_id'] = $row_data['pay_id'];	
			 $record[$i]['amount'] = $row_data['amount'];
			 $record[$i]['currency'] = $row_data['currency'];
			 $record[$i]['charge'] = $row_data['charge'];
			 $record[$i]['status'] = $row_data['status'];
			 $record[$i]['mode'] = $row_data['mode'];
			 $record[$i]['by_with'] = $row_data['by_with'];
			 $record[$i]['created'] =change_date_view($row_data['created']);	
			 
			 $i++;
			}

			$output['withdrawal_history'] = $record;
			$output['success'] = 1;
			$output['msg'] = "Withdrawal History Fetch successfully !!";
			return $output;
			
		}else{
			$output['success'] = 0;
			$output['msg'] = "Withdrawal History Not Found !!";
			return $output;
		}
	}
	
}

//http://www.aurasoftsolutions.com/ColorApp/API/api.php?action=deleteRecord
function deleteRecord($data){
	$deleteBid="delete from bid where end_datetime < now() - interval 10 DAY";
	$deleteBidQuery=query($deleteBid);

	$deleteBid="delete from bid_result where created < now() - interval 10 DAY";
	$deleteBidQuery=query($deleteBid);

	$output['success'] = 1;
	$output['msg'] = "Record deleted successfully !!";
	return $output;




}
function sends($data){

$username="niteshji";
$password ="niteshji";
$number="9755563888";
$sender="TESTID";
$message="hello";
 
$url="login.bulksmsgateway.in/sendmessage.php?user=".urlencode($username)."&password=".urlencode($password)."&mobile=".urlencode($number)."&sender=".urlencode($sender)."&message=".urlencode($message)."&type=".urlencode('3'); 
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo $curl_scraped_page = curl_exec($ch);
curl_close($ch); 

	
return $output;
}
/***********
other  api end 
***********/

function Send_mail($toz,$sub,$body)
{
	    $to =$toz;	
		$from = Email_add;
		$headers ="From: ".Project." <".Email_add."> \r\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1 \n";
		$subject =$sub;
		$msg='<body style="margin:0px;"><table style="background-color:#f8f8f8;border-collapse:collapse!important;width:100%;border-spacing:0" width="100%" bgcolor="#f8f8f8"><tbody><tr><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top"></td><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;background:#ffffff;display:block;margin:0 auto!important;max-width:600px;width:600px;padding:0" width="600" valign="top"><table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"><tbody><tr><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:10px 0 10px 0;color:#ffffff;margin-top:20px;width:100%;border-bottom:none;background-color:#f8f8f8;margin-bottom:30px" width="100%" valign="top" bgcolor="#f8f8f8"><table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"><tbody><tr><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000;background-color: #00171f;text-align: center" valign="top" align="left"><img src="'.ADMIN_URL.'/img/logo.png" style="max-width:100%;width:160px;margin:5px 0 0 0" width="140"></td><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;color:#000000" valign="top" align="right"></td></tr></tbody></table></td></tr><tr><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top">
	        <table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"><tbody><tr><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:30px; background: #f1f1f1;" valign="top">'.$body.'</td></tr></tbody></table><table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"><tbody></tbody></table></td></tr></tbody></table><table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%"><tbody><tr style="display:block;margin:0 auto;max-width:600px;padding:10px 10px;background: #333333;color:#ffffff;font-size:16px;">
	        <td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;width:50%" width="50%" valign="top"><table style="border-collapse:collapse!important;width:100%;border-spacing:0" width="100%">
	           <tbody><tr><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0;width:50%; color: #fff;background: #333;" width="50%" valign="top" align="center"><p style="text-align: center;">Copyright '.date('Y').' '.Project.'&#169; All Rights Reserved.</p></td></tr></tbody></table></td></tr></tbody></table></td><td style="border-collapse:collapse;font-family:Helvetica Neue,Helvetica,Arial,Lucida Grande,sans-serif;font-size:14px;vertical-align:top;padding:0" valign="top"></td></tr></tbody></table></body>';

		mail($to,$subject,$msg,$headers);
		return 1;
}



?>