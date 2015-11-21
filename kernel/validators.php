<?php
include_once 'appconnect.php';
############################################
class validators extends easyDB
{  
    var $errval = "";
//////////////////////////////////////////
   function textvalid ($uvalu, $errmsg) {
    // Validate Text
        $uvalu = stripslashes(strip_tags($uvalu));
        if (strlen($uvalu) < 3 || !ereg('([a-zA-Z0-9])', $uvalu))
        {
          return false;
        }
        else
        {
          return true;
        }
    // Validate Text
    }
//////////////////////////////////////////
    function emailvalid($emvalu)
    // Validate Email
    {
        if (!ereg('([a-z0-9.])'.'@'.'([a-z0-9.])'.'.'.'([a-z])', $emvalu) || !ereg('([a-z0-9.])'.'@'.'([a-z0-9.])'.'.'.'([a-z0-9])'.'.'.'([a-z0-9])', $emvalu))
        {
              return false;
        }
        else
        {
              return true;
        }
    // Validate Email
    }
//////////////////////////////////////////	
    function chmailava ($usrmail)
    { 
            // Validate Email by Availability
            $conn = $this->dbconect();
            $sqlq = "SELECT `email` FROM `members` WHERE `email` = '$usrmail'";
            $rq = mysqli_query($conn, $sqlq);
            if (mysqli_num_rows($rq) > 0)
            { mysqli_close($conn); return false; }
            else {  mysqli_close($conn); return true; }
    }
//////////////////////////////////////////

//////////////////////////////////////////	
	function checkduplicate($phone, $col)
	{ 
                // date Email by Availability
		$conn = $this->dbconect();
		$sqlq = "SELECT * FROM `personel` WHERE `". $col ."` = '$phone'";
		$rq = mysqli_query($conn, $sqlq);
		if (mysqli_num_rows($rq) > 0)
		{ mysqli_close($conn); return false; }
		else { mysqli_close($conn); return true; }
	}
//////////////////////////////////////////	
    function phonevalid ($phvalu)
    // Validate Phone
    {
      if (strlen($phvalu) < 11 || ereg("[a-zA-Z<>.!@#$%^&*()_'=+|?;:~` ]", $phvalu)) 
      {  return false;  }
      else  { return true; }
    // Validate Phone
    }
//////////////////////////////////////////	
    function numbervalid ($numeric)
    // Validate Number
    {
      if (!is_numeric($numeric)) {
			return false;
	  }
      else  {
         	return true;
      }
    // Validate Number
    }
//////////////////////////////////////////	
    function pwdvalid($pvalu)
    // Validates Password
    {
        $pvalu = strip_tags(stripslashes($pvalu));
        if (strlen($pvalu) < 6 || !ereg('([a-zA-Z0-9!@#$%^&*?])', $pvalu)) {
          //$this->errval = 'Password must be minimum of 6 characters';
          //echo $this->errval;
          return false;
        }
        else {
          //$this->errval ='';
          //echo $this->errval;
          return true;
        }
    // Validate Password
    }

//////////////////////////////////////////
	function repwdf ($uinput, $repwd)
	{
		// Retype Password
		if ($uinput != $repwd)
		{
			echo  'Passwords do not match';
			return false;
		}
		elseif (empty($repwd))
		{
			echo  'No data entered';
			return false;
		}
		else
		{
			echo '';
			return true;
		}
	}
//////////////////////////////////////////
    function formatval($urvalu)
    {
        $revalu = strip_tags(stripslashes(trim($urvalu)));
        return $revalu;
    }
//////////////////////////////////////

	/// $datatype - email, phone
	function check_exists($data, $datatype)
	{
		$res = $this->dbconect();
		$sqlqry = mysqli_query($res, "SELECT firstname, lastname, email, phone FROM members WHERE `".$datatype."` = '".trim($data)."'");
		$totaldata = mysqli_num_rows($sqlqry);
		if($totaldata > 0) {
			$udata = mysqli_fetch_array($sqlqry);
			return $udata;
		}
		else {
			return "N/A";	
		}
	}

// End of Validators Class
###########################################
}
?>