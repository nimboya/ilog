<?php
/* 
 * New SMS Message
 * 
 */
?>
<div class="grid">
    <div class="container">
        <div class="row">
            <div class="container span8">
                <h3><a href="start"><img src="img/back.png" /></a>  new sms</h3>
                <table>
                    <tr>
                    <th>Sender</th>
                    <th>To</th>
                    <th>Message</th>
                    </tr>
                    <tr>
                        <td>{sender}</td>
                        <td>{to}</td>
                        <td>{message}</td>
                    </tr>
                </table>
                
            </div>
            
            <div class="span4">
                <h3>other places</h3>             
                <a href="newsms">
                <div class="tile bg-pink" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-mail"></i>
                </div>
                <div class="tile-status">
                    <span class="name">new sms</span>
                </div>
                </div>
                </a>
                
                <a href="smssent">
                <div class="tile bg-red" data-click="transform">
                <div class="tile-content icon">
                    <i class="icon-mail"></i>
                </div>
                <div class="tile-status">
                    <span class="name">sent sms</span>
                </div>
                </div>
                </a>
                
                 <h3>other places</h3>     
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