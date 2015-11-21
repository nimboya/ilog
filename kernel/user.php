<?php
/* Import Classes */
include_once("personel.php");
include_once("appconnect.php");
/* myisusu project
Author: Ewere Diagboya
Company: Wicee Solutions
Date/Time: 2014-08-09 9:52PM
Location: Office

Description: Profiling Functionalities
*/
#########################################
class usersession extends memreg {
/* INSTANCE OF CLASS */
// Login, Logout, Guest methods
////////////////////////////////////////////
function SessionAuth($username, $logintok)
{
	// Connect to DB
	$res = $this->dbconect();
	// Check if User is Logged In and Using the Right Token
	$runtokqry = mysqli_query($res,"SELECT id FROM `members` WHERE (`email` = '$username' OR `phone` = '$username') AND logintok = '$logintok'") or $this->ErrorLog("cmd=sessionauth->".mysqli_error($res));
	if(!$runtokqry)
	{
		mysqli_close($res);
		$response = "System Error";
		return $response;	
	}
	
	$sessionactive = mysqli_num_rows($runtokqry);
	if($sessionactive == 1) {
		mysqli_close($res);
		$response = true;
		return $response;	
	}
	else {
		mysqli_close($res);
		$response = false;
		return $response;	
	}
	
}
////////////////////////////////////////////
function memlogin($username, $upwd, $agent="")
# LogIn User
{
	$response = "";
	$res = $this->dbconect();
	#Email
	$usrname = strip_tags($username);	
	#Password
	$usrpwd = strip_tags($upwd);
	
	// Get Salt
	$saltqry = mysqli_query($res, sprintf("SELECT salt FROM `members` WHERE `email` = '%s' OR `phone` = '%s'", $usrname, $usrname));
	$saltarray = mysqli_fetch_array($saltqry);
	$pwdsalt = $saltarray['salt'];
	
	// Concatenate Salt With Password
	$orpwd = $usrpwd.$pwdsalt;
	
	// Confirmation Authentication
	$confirmqry = sprintf("SELECT * FROM `members` WHERE (`email` = '%s' OR `phone` = '%s') AND (`validphone` = '0' AND `validmail` = '0')", $usrname, $usrname);
	$runconfirm = mysqli_query($res, $confirmqry) or $this->ErrorLog("cmd=memlogin->".mysqli_error($res));
	$confirmauth = mysqli_num_rows($runconfirm);
	
	if($confirmauth > 0)
	{
		// Check if Email/Phone Validated
		$response = "Phone or Email is not validated yet";
		$this->audittrail($usrname,"login","failed:".$response,$agent,"");
		return $response;
	}
	
	// Real Authentication
	$loginqry = sprintf("SELECT * FROM `members` WHERE (`email` = '%s' OR `phone` = '%s') AND `password` = SHA1('%s')", $usrname, $usrname,$orpwd);
	$runlogin = mysqli_query($res, $loginqry) or $this->ErrorLog("cmd=loginauth->".mysqli_error($res));
	$accessauth = mysqli_num_rows($runlogin);
	if($accessauth > 0)
	{
		// Generate LoginToken
		$logintok = md5(time().mt_rand());
		$updatelogintok = mysqli_query($res, "UPDATE `members` SET logintok = '$logintok' WHERE (`email` = '$usrname' OR `phone` = '$usrname')") or $this->ErrorLog("cmd=memlogin->".mysqli_error($res));
		if(!$updatelogintok)
		{
			$response = "System Error";
			return $response;
		}
		
		$this->audittrail($usrname,"login","success",$agent,$logintok);
		$response = "OK:".$logintok;
		return $response;
	}
	else {
		$response = "Wrong Login Details";
		$this->audittrail($usrname,"login","failed:".$response,$agent,"");
		return $response;		
	}
	
}

function memlogout($username, $logintok, $agent)
# Log Out User
{
	// Session Authenticator
	$authresp = $this->SessionAuth($username, $logintok);
	if(!$authresp)
	{
		$response = "Invalid, Not Logged In";
		return $response;	
	}
	
	$res = $this->dbconect();
	$logoutqry = mysqli_query($res, "UPDATE `members` SET `logintok` = '' WHERE `logintok` = '$logintok'") or $this->ErrorLog("cmd=memlogout->".mysqli_error($res));
	
	if($logoutqry)
	{
		$this->audittrail($username,"logout","success",$agent,$logintok);
		mysqli_close($res);
		return "OK";
	}
	else {
		$this->audittrail($username,"logout","failed:".$response,$agent,$logintok);
		mysqli_close($res);
		return "System Error";
	}
}

}


// Login, Logout, Guest procedures
############################################

############################################
class useroperations extends usersession
{
/* ABSTRACT OF CLASS */
// transactions, mail admin

////////////////////////////////////////////
function mnotifier($to, $subj, $msg)
# Email Notifier
{
	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: MyISUSU <notifier@myisusu.com>' . "\r\n";
	$this->dbconect();
	$q = mysql_query("SELECT * FROM members WHERE phone='$to' or email='$to'");
	$u = mysql_fetch_array($q); 
	mail($u[email], $subj, $msg, $headers);
}

////////////////////////////////////////////
// Photo Upload
function fileupload($curuser) {
# Perform Upload	
	$filetype = $_FILES[uploadsignature][type];
	$file_size = $_FILES[uploadsignature][size] / 1024;
	$maxsize = "3000000";	
	
	# Random Number
	$rnd = uniqid(rand(),true);
	
	#Check file size and File Type before upload
	if($filetype != "image/png" && $filetype != "image/jpeg" && $filetype != "image/gif" && $filetype != "image/pjpeg")
	{
		return die("File selected is not a an Image/JPEG File <a href='javascript:history.go(-1);'>Back</a>"); 
	}
	elseif ($file_size > $maxsize) // File Size too Large
	{
		return die("File size larger than 3MB <a href='javascript:history.go(-1);'>Back</a>");	
	}
	else { // Upload ran successfully
		$folda = "sysadmin/mandatesignatures/";
		if(!file_exists($folda)) mkdir($folda);
		$newname = $folda . $curuser . "_signature.jpg";
		move_uploaded_file($_FILES[uploadsignature][tmp_name], $newname) or die($_FILES[uploadsignature][error]);
		return $newname;		
	}
}
// Photo Upload
////////////////////////////////////////////


////////////////////////////////////////////
function myprofile($username, $logintok)
{
/* My Profile */

// Database Connection
		$res = $this->dbconect();
		
// Session Authenticator
	$authresp = $this->SessionAuth($uname, $logintok);
	if(!$authresp)
	{
		$response = "Invalid, Not Logged In";
		return $response;	
	}

// Get Profile
	$res = $this->dbconnect();
	$getProfile = "SELECT * FROM members WHERE (email='$uname' OR phone='$uname') AND logintok = '$logintok'";
	$result = mysqli_query($res, $getcluster) or $this->ErrorLog("cmd=getclusters->".mysqli_error($res));
	
	if($result) {
		//Create an json Response
		$json_response = array();
		
		// Get Names
		while ($cluster = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			$mem[] = $memrec;
			array_push($json_response, $mem);
		}
			echo json_encode($mem);
	}
	else {
		$response = "System Error";
		return $response;	
	}
/* My Profile */
}
////////////////////////////////////////////

function updateprof($uname, $logintok, $agent, $nok, $nokphone)
# Update Profile
{
	// Session Authenticator
	$authresp = $this->SessionAuth($uname, $logintok);
	if(!$authresp)
	{
		$response = "Invalid, Not Logged In";
		return $response;	
	}
	
	if(empty($nok))
	{
		$response = "Next of KIN is blank";
		return $response;
	}
	
	if(empty($nokphone))
	{
		$response = "Next of KIN Phone is blank";
		return $response;
	}
	
	
	$response = "";
	$res = $this->dbconect();
	$sqlup = "UPDATE `members` SET  `nok`='$nok', `nokphone`='$nokphone' WHERE (`email`='$uname' OR `phone`='$uname')";
	$runq = mysqli_query($res, $sqlup) or $this->ErrorLog("cmd=updateprof->".mysqli_error($res));
	if($runq) {
		$this->audittrail($uname,"profileupdate","success",$agent,$logintok);
		$response = "OK";
	}
	else {
		$this->audittrail($uname,"profileupdate","failed",$agent,$logintok);
		$response = "Update Failed";
	}
	return $response;

}
# Update Profile
/////////////////////////////////////////////
function changepwd($usrname, $logintok, $agent, $opass, $npass) {
// Change Password
	// Session Authenticator
	$authresp = $this->SessionAuth($usrname, $logintok);
	if(!$authresp)
	{
		$response = "Invalid, Not Logged In";
		return $response;	
	}
	$response="";
	$res = $this->dbconect();
	
	// Get Salt
	$saltqry = mysqli_query($res, sprintf("SELECT salt FROM `members` WHERE `email` = '%s' OR `phone` = '%s'", $usrname, $usrname)) or die(mysqli_error($res));
	$saltarray = mysqli_fetch_array($saltqry);
	$pwdsalt = $saltarray['salt'];
	$saltedopass = $opass.$pwdsalt;
	
	// Check if old password Matches
	$check_opass = "SELECT * FROM `members` WHERE (`email` = '$usrname' OR `phone` = '$usrname') AND password=SHA1('$saltedopass')";
	$runq = mysqli_query($res, $check_opass) or $this->ErrorLog("cmd=changepwd|checkold->".mysqli_error($res));
	$r1 =  mysqli_num_rows($runq); 
	// If Query Failes
	if(!$runq) {
		$response = "System Error";
		$this->audittrail($usrname,"changepwd","failed",$agent,$logintok);
		return $response;
	}
	if($r1 > 0) {
		// Perform Actual password change
		//$newsalt = time().mt_rand();
		$saltednpass = $npass.$pwdsalt;
		$chpassqry = "UPDATE `members` SET password=SHA1('$saltednpass') WHERE (`email` = '$usrname' OR `phone` = '$usrname')";
		$chngpassword = mysqli_query($res,$chpassqry) or $this->ErrorLog("cmd=changepwd|updatenew->".mysqli_error($res));
		// If Query Failes
		if(!$chngpassword) {
			$response = "System Error";
			$this->audittrail($usrname,"changepwd","failed:".mysqli_error($res),$agent,$logintok);
			mysqli_close($res);
			return $response;
		}
		$this->audittrail($usrname,"changepwd","success",$agent,$logintok);
		mysqli_close($res);
		// Send Email Notification
		$msg = "An operation has been performed in your account<b>Your password has been changed successfully</b>. Your new password is: $npass";
		$this->mnotifier($usrname, "Password Changed", $msg);
		$response = "OK";
	}
	else {
		// Cant Perform Change because old password did not match
		$this->audittrail($usrname,"changepwd","failed:Invalid old password",$agent,$logintok);
		$response = "Old password Invalid";
	}
	return $response;
}
///////////////////////////////////////////////////////////////////////////////////
// Direct Debit Application
function ddapply($fullname, $address, $phone, $email, $accname, $bankadd, $accno, $acctype, $biller="BILLIONAIRESPIE", $maxapproval,  $mandatestartdate,$mandateenddate, $mandatetype, $frequencyofpayment, $curuser, $plan, $subamount) {
	
	// Validate User Input
	if(empty($fullname))
	{
		$response = "Firstname is blank";
		return $response;
	}
	
	if(empty($address))
	{
		$response = "Address is blank";
		return $response;
	}
	
	if(empty($phone))
	{
		$response = "Phone is blank";
		return $response;
	}
	
	if(!is_numeric($phone))
	{
		$response = "Phone is not numeric";
		return $response;
	}
	
	if(empty($email))
	{
		$response = "Email is blank";
		return $response;
	}
	
	if(empty($accname))
	{
		$response = "Account Name is blank";
		return $response;
	}
	
	
	if(empty($bankadd))
	{
		$response = "Bank Address is blank";
		return $response;
	}
	
	if(empty($accno))
	{
		$response = "Account Number is blank";
		return $response;
	}
	
	if(empty($acctype))
	{
		$response = "Account Type is blank";
		return $response;
	}
	
	if(empty($maxapproval))
	{
		$response = "Maximum amount approved is blank";
		return $response;
	}
	
	if(empty($mandatestartdate))
	{
		$response = "Start mandate date is blank";
		return $response;
	}
	
	if(empty($mandateenddate))
	{
		$response = "End mandate date is blank";
		return $response;
	}
	
	if(empty($mandatetype))
	{
		$response = "Mandate Type is blank";
		return $response;
	}
	
	if(empty($frequencyofpayment))
	{
		$response = "Frequency is blank";
		return $response;
	}
	
	$startdt = strtotime($mandatestartdate); $endddate = strtotime($mandateenddate);
	$tdiff = $endddate - $startdt;
	if($tdiff <= 1)
	{
		$response = "Mismatch on your start date and end date";
		return $response;	
	}
	
	if(!isset($_FILES['uploadsignature']['name'])) {
		$response = "No Image File Selected for Upload";
		return $response;	
	}

	
	// Instantiate DB Class
	$ins = new Db;
	
	// Upload Signature
	$signature = $this->fileupload($_SESSION['curuser']);
	
	// Insert into Table
	$servicetype = "PERIODIC CONTRIBUTION";
	$f = array('fullname', 'address', 'phone', 'email', 'accname', 'bankadd', 'accno', 'acctype', 'biller', 'servicetype', 'maxapproval', 'mandatestartdate', 'mandateenddate', 'mandatetype', 'frequencyofpayment', 'signature', 'systemid', 'plan', 'subamount');
	$v = array($fullname, $address, $phone, $email, $accname, $bankadd, $accno, $acctype, $biller, $servicetype, $maxapproval, $mandatestartdate, $mandateenddate, $mandatetype, $frequencyofpayment, $signature, $curuser, $plan, $subamount);
	$response = $ins->InsertOpt("ddmandate",$f,$v);
	return $response;
}
// Direct Debit Application

////////////////////////////////////////////
}
// transactions, operations
############################################

?>