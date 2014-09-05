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
		  <header><img src="/img/img_login.png" width="20" height="23" alt=""><span>Login</span></header>
		  <?php
			
			echo $form->create('Admin',array('controller'=>'admins','action'=>'login','method'=>'POST','name'=>'frmAdmin','id'=>'form') );
			?>
			
			<fieldset>
				<div class="login-container">
					<div class="pure-control-group">
						<label for="name">Email</label>
						
						 <?php 
						 echo $form->input('Admin.email', array('placeholder'=>'Email','class'=>'active','type'=>'text','label'=>false,'div'=>false,'error'=>true)); 
						 ?>					
					</div>

					<div class="pure-control-group">
						<label for="name">Password</label>
						
						<?php echo $form->input('Admin.password', array('placeholder'=>'Password','type'=>'password','label'=>false,'div'=>false,'error'=>true)); ?>
					</div>
					
					<div class="pure-controls">
						<label for="cb" class="pure-checkbox">
							
							<?php echo $form->input('Admin.keepmeloggedin', array('type'=>'checkbox','label'=>false,'div'=>false,'error'=>true)); ?>
							Remember me</label>						
							<?php echo $html->link('Forgot Password?',array('controller'=>'admins','action'=>'forgotpassword')); ?> 
					</div>
				</div>  
				 <?php echo $form->submit('Login',array('class'=>'login')); ?>
			</fieldset>
			<?php
			echo $form->end();
			echo $validation->rules(array('Admin'),array('formId'=>'form'));
			?>
			</article>
	</section>
