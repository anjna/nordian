    <div align="right" class="listing">    
    <?php echo $html->link('Back to listing',array('controller'=>'admins','action'=>'index')); ?>
    </div>
    <div id="box">
    <h3 id="adduser">Admin user Detail</h3>
    <div class="userdetail">
        <fieldset id="personal">
        <legend><?php echo $user['Admin']['firstname'].' '.$user['Admin']['lastname'];?></legend>
        <label>Email : </label><div class="listing">&nbsp;<?php echo $user['Admin']['email'];?></div>
        
        <label>Name : </label> <div class="listing">&nbsp;<?php echo $user['Admin']['firstname'].' '.$user['Admin']['lastname'];?></div>
        
        <label>Profile Picture : </label> <div class="listing">&nbsp;
        <?php
        $image = 'user.png';
        if(!empty($user['Admin']['image']) && file_exists(WWW_ROOT."img/profile/large/img_100_100_".$user['Admin']['image'].""))
        {
            $image = "profile/large/img_100_100_".$user['Admin']['image'];
        }
        
        echo $html->image($image,array("border"=>0,"alt"=>$user['Admin']['firstname'],"title"=>$user['Admin']['firstname']));
        ?>
        
        </div>
        
        <label>Address1 : </label> <div class="listing">&nbsp;<?php echo $user['Admin']['address1'];?></div>
       
        <label>Address2 : </label> <div class="listing">&nbsp;<?php echo $user['Admin']['address2'];?></div>
        
        <label>City : </label> <div class="listing">&nbsp;<?php echo $user['Admin']['city'];?></div>
        
        <label>Contact Phone : </label> <div class="listing">&nbsp;<?php echo $user['Admin']['phone'];?></div>
        
        </fieldset>
    </div>
</div>