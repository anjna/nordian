<section class="login-area">
		
		<span class="errorlogin_msg" id="jsErrors">
		<?php
		if($session->check('Message.flash'))
		{
			?>
			<article class="wrong-email"><img src="/img/icon_wrong-email.png" width="22" height="22" alt=""><span><?php echo $session->flash(); ?></span></article>
			<?php
		}
		?>
		
		</span>
		
		
		
		<article class="login">
		  <header><img src="/img/img_login.png" width="20" height="23" alt=""><span>Forgot Password</span></header>
		  <?php echo $form->create('Admin',array('controller'=>'admins','action'=>'forgotpassword','method'=>'POST','name'=>'frmAdmin','id'=>'form') ); ?>
			
			<fieldset>
				<div class="login-container">
					<div class="pure-control-group">
						<label for="name">Email</label>
						
						 <?php 
						 echo $form->input('Admin.email', array('placeholder'=>'Email','class'=>'active','type'=>'text','label'=>false,'div'=>false,'error'=>true)); 
						 ?>					
					</div>

				</div>  
				
				<div class="buttons">
					
					<?php echo $form->submit('Forgot Password',array('class'=>'login','class'=>'btn2','div'=>false)); ?> 
					<?php //echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='".$siteurl."/admin/admins/index'")); ?>
					
					<?php echo  $form->submit('Cancel',array('div'=>false,'class'=>'btn2','type'=>'button','onclick'=>'location.href="'.$siteurl.'/admin/admins/login"'));?>
				</div>
			</fieldset>
			<?php
			echo $form->end();
			echo $validation->rules(array('Admin'),array('formId'=>'form'));
			?>
			</article>
	</section>
	
	
