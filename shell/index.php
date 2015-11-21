<?php
if(!isset($_SESSION)) {
    session_start();	
}
/* Inclusions */
include_once("../kernel/personnel.php");
include_once("../kernel/group.php");
include_once("../kernel/sms.php");
/* Inclusions */
/* 
ilog Web App Shell
Author: Ewere Diagboya
Company: Wicee Solutions
Date/Time: 2015-03-27 4:34PM
*/
/* Instances */
$personnel = new Personnel;
$group = new Group;
$sms = new SMS;
/* Instances */

// POST Req/Resp - Process all POST Reqeusts
if(isset($_POST['cmd'])) {
    /* @var $_POST type */
    switch ($_POST['cmd'])
    {
        // Create Personnel
        // POST: CreatePersonnel
        case "newpersonnel":
        echo $personnel->CreatePersonnel();
        break;
    
        // Create Group
        // POST: CreateGroup
        case "newgroup":
        $ret = $group->CreateGroup();
        if($ret == "OK") {
            header("Location: $_SERVER[HTTP_REFERER]");
        }
        else {
            header("Location: $_SERVER[HTTP_REFERER]");
        }
        break;
        
        // Send SMS
        // POST: SendSMS
        case "newsms":
            echo $sms->SendSMS($_POST['sender'], $_POST['recs'], $_POST['message']);
            //echo $sms->SaveDraft($_POST['sender'], $_POST['recs'], $_POST['message']);
        break;
    
        // Send SMS
        // POST: SendToAllSMS
        case "sendtoall":
            echo $sms->SendToAll($_POST['sender'], $_POST['message']);
        break;
    }
}
// For All GET Requests/Responses
if(isset($_GET['cmd']))
{
        /* @var $_GET type */
      switch ($_GET['cmd'])
      {
        // GET: GetPersonnel - New Personnel Page
        case "getpersonnnel":
            echo $personnel->GetPersonnel();
        break;
    
        // GET: GetPersonnel - Personnel Page
        case "morepersonnnel":
            //echo '{"aaData":'.$personnel->MorePersonnel().'}';
            echo $personnel->MorePersonnel();
        break;
    
        case "getpersonnelforsms":  
            header('Content-type: application/json');
            echo $personnel->GetPersonnelForSMS();
        break;
    
        // GET: GetPersonnel - Personnel Page
        case "fullprofile":
            //echo '{"aaData":'.$personnel->MorePersonnel().'}';
            echo $personnel->FullPersonnel($_GET['id']);
        break;
      
        // GET: GetGroup
        case "getgroup":
            echo '{"aaData":'.$group->GetGroup().'}';
        break;
      }      
}