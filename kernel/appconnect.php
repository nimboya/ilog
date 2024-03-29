<?php
#########################################
class startapp {
/* INSTANCE OF CLASS */
  # Declare Variables
  // For Recording Database Error Logs
  public function ErrorLog($content)  {
		$file = 'log.txt';
		$current = file_get_contents($file);
		$current .= "[".date('Y-m-d h:i')."]".$content."\n";
		file_put_contents($file, $current);
  }

  public function dbconect()  { 
	$dbhost = "localhost";
	$dbusername = "root";
	$dbpassword = "password";
	$db = "ilog";
	$conres = mysqli_connect($dbhost, $dbusername, $dbpassword, $db);
	
	if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
	$this->ErrorLog("Connect failed: %s\n", mysqli_connect_error()); // Save in Text Log
    exit();
	}
	return $conres;
  }
  
  public function sysconnect() {
      $dbhost = "localhost";
	$dbusername = "root";
	$dbpassword = "";
	$db = "ilmanager";
	$conres = mysqli_connect($dbhost, $dbusername, $dbpassword, $db);
	
	if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
	$this->ErrorLog("Connect failed: %s\n", mysqli_connect_error()); // Save in Text Log
    exit();
	}
	return $conres;
  }
  
  public function counthits() {
    $browserspecs = $_SERVER['HTTP_USER_AGENT'];
    $httphost = $_SERVER['HTTP_HOST'];
    $remoteadd = $_SERVER['REMOTE_ADDR'];
    $remoteport = $_SERVER['REMOTE_PORT'];

    $this->dbconect();
    $sqlq = "INSERT INTO hits (`browser`, `host`, `remoteadd`, `remoteport`) VALUES ('$browserspecs', '$httphost', '$remoteadd', '$remoteport')";
    $runq = mysql_query($sqlq);
    if (!$runq) { echo "Conn Err: ". die(mysql_error()); }
    }
  
  public function audittrail($loginid, $operation, $status, $agent, $logintok)  {
    $con = $this->dbconect();
    $sqlq = "INSERT INTO audittrail (loginid, operation, status, agent, logintokfk) VALUES ('$loginid', '$operation', '$status', '$agent','$logintok')";
    mysqli_query($con,$sqlq) or $this->ErrorLog("cmd=audittrail->".  mysqli_error($con));
  }
  
  // Generate GUID
  function generateGuid($include_braces = false) {
    if (function_exists('com_create_guid')) {
        if ($include_braces === true) {
            return com_create_guid();
        } else {
            return substr(com_create_guid(), 1, 36);
        }
    } else {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
       
        $guid = substr($charid,  0, 8) . '' .
                substr($charid,  8, 4) . '' .
                substr($charid, 12, 4) . '' .
                substr($charid, 16, 4) . '' .
                substr($charid, 20, 12);
 
        if ($include_braces) {
            $guid = '{' . $guid . '}';
        }
        return $guid;
    }
  }
  
}

class agents {
	public $web = "Web";
	public $android = "And";
	public $win = "Win";
	public $bb = "BB";
}

class easyDB extends startapp
{	
	// General Insert Method
	public function Insert($tablename, $fields, $values)
	{	
		$res = $this->dbconect();
		$status = "";
		$field = implode("`,`", $fields);
		$value = implode("','", $values);
		$instq = "INSERT INTO " . $tablename . "(`" . $field . "`) VALUES ('" . $value . "')";
		$runq = mysqli_query($res, $instq) or $this->ErrorLog("Insert Qry: $tablename->".mysqli_error($res));
		// Possible Scenarios
		# Inserted Successfully
		if ($runq === true)
		{
			$status = "OK";
		}
		// Unknown Error
		else
		{
			$status = "System Error";
		}
		return $status;
	}
	
	// Update Method
	public function Update($tablename, $conditions, $fields, $values)
	{
		$status = "";
		$field = implode("`,`", $fields);
		$value = implode("','", $values);
		$res = $this->dbconect();
		$runq = mysqli_query($res, "UPDATE ".$tablename."SET $field = '$value' WHERE $conditions") or $this->ErrorLog("Update Qry: $tablename ->".mysqli_error($res));
		// Possible Scenarios		
		if($runq === true) { $status = "OK"; }
		// Unknown Error
		else { $status = "System Error"; }	
		return $status;
	}
	// Retrieve Method
	public function Retrieve()
	{
		$res = $this->dbconect();
		return $res;
	}
	
	// Delete Method
	public function Delete($tablename, $conditions)
	{
		$status = "";
		$res = $this->dbconect();
		$runq = mysqli_query($res,"DELETE FROM " .$tablename. "WHERE ". $conditions) or $this->ErrorLog("Delete Error: ".mysqli_error($res));
		// Possible Scenarios		
		if($runq === true) { $status = "OK"; }
		// Unknown Error
		else { $status = "System Error"; }	
		return $status;
	}
}
