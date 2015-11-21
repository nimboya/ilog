<?php
/*
 * Title: personnel
 * Type: kernel
 * Description: Performs all the functionalities of the personnel module
 * Date and Time: 2015-03-26 12:39am
 * Author: Ewere Diagboya
 * 
 */
include "appconnect.php"; // Contains easyDB
include "validators.php"; // Initializes the Validator
class Personnel extends easyDB {

    /* Total Members */
    var $totalmembers;
    
    function __construct() {
        
    }

    // POST: CreatePersonnel
    function CreatePersonnel() {
// Initialize Validation Object
        $vdator = new validators;

// Convert POST Array to Variable 
        extract($_POST);
        // Validate Input
        /* @var $firstname type */
        if (empty($firstname)) {
            $response = "Firstname is blank";
            return $response;
        }

        if (empty($lastname)) {
            $response = "Lastname is blank";
            return $response;
        }

        if (empty($rdsex)) {
            $response = "Sex is blank";
            return $response;
        }
        
        if (empty($dob)) {
            $response = "Date of Birth is blank";
            return $response;
        }
        
        if (empty($phone)) {
            $response = "Phone Number is blank";
            return $response;
        }

        if (empty($email)) {
            $response = "Email is blank";
            return $response;
        }
        
        /* @var $address type */
        if (empty($address)) {
            $response = "Address is blank";
            return $response;
        }

        if (!$vdator->emailvalid($email)) {
            $response = "Invalid Email Format";
            return $response;
        }

        /* @var $phone type */
        if (!$vdator->phonevalid($phone)) {
            $response = "Invalid Phone Number Format";
            return $response;
        }
        
        if(!$vdator->checkduplicate($phone, "phone"))
	{
		$response = "Phone Number has been used";
		return $response;
	}
        
        if(!$vdator->checkduplicate($email, "email"))
	{
		$response = "Email has been used";
		return $response;
	}
        // Passport Upload Validator
        if(isset($_FILES['passport']['name']) && $_FILES['passport']['type'] != "image/jpeg") {
                $response = "File must be a JPG file";
		return $response;
        }
        // Upload File
        $ppdir = "passports/"; if(!file_exists($ppdir)) mkdir($ppdir);
        $passportpath = $ppdir.$firstname."_".$phone.".jpg";
        $filename = $firstname."_".$phone.".jpg";
        $uplpassport = move_uploaded_file($_FILES['passport']['tmp_name'], $passportpath) or die("File Upload Error:".$_FILES['passport']['error']);
        $f = '["firstname", "lastname", "sex", "dob", "phone", "email", "address","gid", "passport"]'; // Fields in Database
        $v = array(ucwords($firstname), ucwords($lastname), ucwords($rdsex), $dob, $phone, strtolower($email), ucwords($address), $groupid, $filename); // Values from Form
        /* @var $resp type */
        $response = $this->Insert("personel", $f, $v);
        return $response;
    }

    // GET: GetPersonnel - Get Personnel for SMS
    function GetPersonnelForSMS() {
        $resource = $this->Retrieve();
        $query = mysqli_query($resource, "Select phone id, CONCAT(firstname, ' ', lastname) name FROM personel");
        $this->totalmembers = mysqli_num_rows($query);
        while ($row = mysqli_fetch_object($query)) {
            $p[] = $row;
        }
        if($this->totalmembers > 0) {
            $data = '{"aaData":'.json_encode($p).'}';
        }
        else {
           $p[] = array('id'=>'', 'name' => '');
           $data = json_encode($p);
        }
        return $data;
    }
    
    
    // GET: GetPersonnel - New Personnel Page
    function GetPersonnel() {
        $resource = $this->Retrieve();
        $query = mysqli_query($resource, "SELECT firstname, lastname, sex FROM personel");
        $this->totalmembers = mysqli_num_rows($query);
        while ($row = mysqli_fetch_object($query)) {
            $p[] = $row;
        }
        if($this->totalmembers > 0) {
            $data = '{"aaData":'.json_encode($p).'}';
        }
        else {
           $p[] = array('id'=>'', 'firstname' => '', 'lastname' => '', 'sex' =>'');
           $data = '{"aaData":'.json_encode($p).'}';
        }
        return $data;
    }
    
    // GET: GetPersonnel - Personnel Page
    function MorePersonnel() {
        $resource = $this->Retrieve();
        $q = "";
        if(isset($_GET['q'])) {
            $q = "SELECT p.id, p.firstname, p.lastname, p.sex, p.phone FROM personel p, `group` grp 
WHERE p.first LIKE '%".is_string($_GET['q'])."%' OR p.lastname LIKE '%".is_string($_GET['q'])."%'";
        }
        else {
            $q = "SELECT p.id, p.firstname, p.lastname, p.sex, p.phone, p.email, p.address, p.passport FROM personel p";
        }
        $query = mysqli_query($resource, $q);
        $this->totalmembers = mysqli_num_rows($query);
        while ($row = mysqli_fetch_object($query)) {
            $p[] = $row;
        }
        if($this->totalmembers > 0) {
            $data = '{"aaData":'.json_encode($p).'}';
        }
        else {
           $p[] = array('id'=>'', 'firstname' => '', 'lastname' => '', 'sex' =>'', 'phone' =>'');
           $data = '{"aaData":'.json_encode($p).'}';
        }
        return $data;
    }
    
    // POST Full Personnel - Full Personnel Profile
    function FullPersonnel($id) {
         $resource = $this->Retrieve();
        $q = "";
        if(isset($_GET['id'])) {
            $q = "SELECT p.id, p.firstname, p.lastname, p.sex, p.dob, p.phone, p.email, p.address, p.passport FROM personel p
WHERE p.id = '". trim($id)."'";
        }
        $query = mysqli_query($resource, $q);
        $this->totalmembers = mysqli_num_rows($query);
        while ($row = mysqli_fetch_object($query)) {
            $p[] = $row;
        }
        if($this->totalmembers > 0) {
            $data = '{"aaData":'.json_encode($p).'}';
        }
        else {
           $p[] = array('id'=>'', 'firstname' => '', 'lastname' => '', 'sex' =>'', 'phone' =>'', 'email' =>'', 'address' =>'', 'passport' =>'');
           $data = '{"aaData":'.json_encode($p).'}';
        }
        return $data;
    }
    
    // POST: UpdatePersonnel
    function UpdatePersonnel() {
        
    }

    function DeletePersonnel($personelid) {
        
    }

    function FindPersonnel($searchpara) {
        
    }

}
