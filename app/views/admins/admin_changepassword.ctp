    <div id="box">
        <h3 id="addAdmin">Change Password</h3>
            <div class="errorlogin_msg" id="jsErrors">

            </div>
            <?php if ($session->check('Message.flash')){ echo $session->flash();}?>
            <?php echo $form->create('Admin',array('controller'=>'admins','action'=>'changepassword','method'=>'POST','name'=>'frmAdmin','id'=>'form') )?>  
   
            <label for="email">Old Password:</label>
            <?php echo $form->input('Admin.oldPassword', array('type'=>'password','maxlength'=>'50','size'=>'20','class'=>'textbox','label'=>false)); ?>	     
 
            <label for="lastname">New Password:</label> 
             <?php echo $form->input('Admin.newPassword', array('type'=>'password','maxlength'=>'50','size'=>'20','class'=>'textbox','label'=>false)); ?>	     
 
            <label for="firstname">Confirm Password:</label>
            <?php echo $form->input('Admin.confirmPassword', array('type'=>'password','maxlength'=>'50','size'=>'20','class'=>'textbox','label'=>false)); ?>	     
            
    
            <label for="lastname">&nbsp;</label>
            <?php
                echo $form->submit('Change Password',array('div'=> false));
                echo '&nbsp;&nbsp;';
               
                echo $form->submit('Cancel',array('type'=>'button','div'=> false,'onclick'=>"location.href='".ADMINSITEURL."admins/dashboard'"));         
            ?>
            <?php
                echo $form->end();
                echo $validation->rules(array('Admin'),array('formId'=>'form'));
            ?>            
    </div>