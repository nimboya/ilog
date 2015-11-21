<?php
/*
 *  
 * Personnel Profile
 * 
 */
$requrl = $pageurl."/shell/index.php?cmd=fullprofile&id=".$_GET['id'];
$jurl = file_get_contents($requrl);
$p = json_decode($jurl);
?>
<div class="grid">
    <div class="container">
        <div class="row">
            <div class="span4" style="padding-left: 3em;">
                <h3><a href="personel"><img src="img/back.png"></a>&nbsp;&nbsp;personnel profile</h3>
                <br />
                <p><img height="150" width="150" src="shell/passports/<?php echo $p->aaData[0]->passport; ?>" /></p>
            <a href="#" title="send sms">
            <div class="span1">
            <div class="tile bg-blue half" data-click="transform">
            <div class="tile-content icon">
                <i class="icon-mail"></i>
            </div>
            <div class="tile-status">
                <span class="name"></span>
            </div>
            </div>
            </div>
            </a>
                
            <a href="#" title="id card">
            <div class="span1">
            <div class="tile bg-green half" data-click="transform">
            <div class="tile-content icon">
                <i class="icon-user-2"></i>
            </div>
            <div class="tile-status">
                <span class="name"></span>
            </div>
            </div>
            </div>
            </a>
                
            <a href="#" title="edit profile">
            <div class="span1">
            <div class="tile bg-pink half" data-click="transform">
            <div class="tile-content icon">
                <i class="icon-pencil"></i>
            </div>
            <div class="tile-status">
                <span class="name"></span>
            </div>
            </div>
            </div>
            </a>
            </div>
            
            <div class="span4" style="padding-top: 80px;">      
                <p><b>Firstname</b> <?php echo $p->aaData[0]->firstname; ?></p>
                <p>&nbsp;</p>
                <p><b>Lastname</b> <?php echo $p->aaData[0]->lastname; ?> </p>
                <p>&nbsp;</p>
                <p><b>Sex</b> <?php echo $p->aaData[0]->sex; ?> </p>
                <p>&nbsp;</p>
                <p><b>Phone</b> <?php echo $p->aaData[0]->phone; ?> </p>
                <p>&nbsp;</p>
                <p><b>Email</b> <?php echo $p->aaData[0]->email; ?> </p>
                <p>&nbsp;</p>
                <p><b>Date of Birth</b> <?php echo $p->aaData[0]->dob; ?> </p>
                <p>&nbsp;</p>
                <p><b>Address</b> <?php echo $p->aaData[0]->address; ?> </p>
                <p>&nbsp;</p>
            <?php // } ?>
            </div>
            
            <div class="span4">
                <h3> other places</h3>
                <a href="personel">
                <div class="tile bg-teal" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-user-2"></i>
                </div>
                <div class="tile-status">
                    <span class="name">personnel</span>
                </div>
                </div>
                </a>
                
                <a href="group">
        <div class="tile bg-orange" data-click="transform">
        <div class="tile-content icon">
        <i class="icon-grid"></i>
        </div>
        <div class="tile-status">
        <span class="name">groups/categories</span>
        </div>
        </div>
        </a>
        
        <a href="sms">
        <div class="span4">
        <div class="tile bg-olive" data-click="transform">
        <div class="tile-content icon">
        <i class="icon-mail"></i>
        </div>
        <div class="tile-status">
        <span class="name">sms</span>
        </div>
        </div>
        </div>
        </a> 
            </div>
        </div>
    </div>
</div>