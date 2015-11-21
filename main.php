<?php
$urlf = preg_split("[/]", $_SERVER['REQUEST_URI']);
//$pageurl="http://".$_SERVER['HTTP_HOST']."/".$urlf[1];
?>
<!DOCTYPE html>
<head>
<link href="css/metro-bootstrap.min.css" rel="stylesheet" />
<link href="css/metro-bootstrap-responsive.min.css" rel="stylesheet" />
<link href="css/iconFont.min.css" rel="stylesheet" />
<link href="css/select2.min.css" rel="stylesheet" />
<!-- Load JavaScript Libraries -->
<script src="js/jquery/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery/jquery.widget.min.js"></script>
<script src="js/jquery/jquery.mousewheel.js"></script>
<script src="js/jquery/jquery.dataTables.js"></script>
<script src="js/jquery/jquery.easing.1.3.min.js"></script>
<script src="js/prettify/prettify.js"></script>
<script src="js/holder/holder.js"></script>
<script src="js/select2.full.js"></script>
<!-- Metro UI CSS JavaScript plugins -->
<script src="js/metro.min.js"></script>
<script src="js/load-metro.js"></script>
</head>
<style>
body {
    margin-top: 0px;
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-image: url(img/bg.fw.png);
 }
</style>
<title>iLog - CRM, HR, MMS System</title>
<body class="metro">
    <div class="container">
        <div class="container">
        <div class="grid">
        <div class="row">
            <div class="span12">
                <h2><b>iLog</b>&nbsp;</h2><small>{Company Name}</small>
            <?php if(isset($_GET['p']) && $_GET['p'] != "personnel") { ?>
            <center>
            <div style="width:50%;">
            <div class="input-control text">
                <input type="text" name="q" placeholder="search for personel" />
            <button class="btn-search"></button>
            </div></div>
            </center>
            <?php } ?>
            </div>
            
            <div class="span0">
                <div class="button-dropdown">
                    <button class="dropdown-toggle command-button inverse">
                    <i class="icon-user on-left"></i>
                        Admin
                        <small>&nbsp;&nbsp;&nbsp;&nbsp;</small>
                    </button>
                    <ul class="dropdown-menu inverse" data-role="dropdown" style="display: none;">
                        <li><a href="#"><b>Settings</b></a></li>
                        <li><a href="#"><b>Log Out</b></a></li>
                    </ul>
                </div>
            </div>
        </div>
            </div>
        
    <?php
    if(isset($_GET['p'])) {
        switch($_GET['p']) {
            // Start/Main Menu
            case "start":
                require './start.php';
            break;
            // Create New Personnel
            case "newpersonnel":
                require './personnel/new.php';
            break;
        
            // Manage Personnel
            case "ipersonnel":
                require './personnel/mg.php';
            break;
        
            // View Personnel
            case "viewprofile":
                require './personnel/profile.php';
            break;
        
            // Create Group
            case "newgroup":
                require './group/new.php';
            break;
        
            // New SMS
            case "newsms":
                require './ilsms/newsms.php';
            break;  
        
            // Sent SMS
            case "smssent":
                require './ilsms/smssent.php';
            break;  
        
            // Sent to All
            case "smstoall":
                require './ilsms/smstoall.php';
            break;  
        
        }
    }
    ?>
        </div> 
    </div>
</body>
</html>