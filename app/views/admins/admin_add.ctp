	<?php echo $javascript->link(array("/ckeditor/ckeditor","/ckeditor/adapters/jquery")); ?> 
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">Manage SME's</a> » <a href="javascript:void(0);"><strong><?php echo $label; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo $label; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('Admin',array('controller'=>'admins','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
	  <fieldset>
	  
			<?php
				if(isset($errors) && !empty($errors))
				{
			?>
					<article class="front-error"><img width="22" height="22" alt="" src="/img/icon_wrong-email.png">
						<div class="error">
							<ul>
								<?php
									foreach($errors as $error){
								?>
								<li><?php echo $error; ?></li>
								<?php
									}
								?>
							</ul>
						</div>
					</article>
			<?php
				}
			?>
			
			
			<div class="date">
				Date Added: 
				<?php 
					if(!isset($this->data['Admin']['created']))
					{	
						echo date('Y-m-d H:i:s a');
					}
					else{
						echo date('Y-m-d H:i:s a',strtotime($this->data['Admin']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Admin']['modified']))
				{	
					echo date('Y-m-d H:i:s a');
				}
				else{
					echo date('Y-m-d H:i:s a',strtotime($this->data['Admin']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Full Name  <span>*</span></label>				
				 <?php echo $form->input('Admin.fullname', array('type'=>'text','id'=>'firstname','label'=>false,'error'=>false)); ?>	  				
			</div>

			<div class="pure-control-group">
				<label for="name">Email <span>*</span></label>
				<?php echo $form->input('Admin.email', array('type'=>'text','id'=>'email','label'=>false,'error'=>false)); ?>
			</div>
		
			<?php
			
				if(empty($this->data['Admin']['id'])){
			?>
			<div class="pure-control-group">
				<label for="name">Password  <span>*</span></label>				
				 <?php echo $form->input('Admin.custom_password', array('type'=>'password','label'=>false,'error'=>false)); ?>	
				<div style="padding-top:10px;">
					<a href="javascript:void(0)" id="getpassword" style="color:#1D4F93;margin-left: 600px; padding-top: 10px;" />Generate random</a>
				</div>
			</div>

			<?php
			
			} ?>
		
			
			<div class="pure-control-group">
				<label for="name">Status  <span>*</span></label>
				<?php
					$default = "";
					if(!isset($this->data['Admin']['is_active'])){
					$default = "checked";
					}
				?>

				 <div class="pure-radio"><input   name="data[Admin][is_active]" value="1" type="radio" <?php echo (@$this->data['Admin']['is_active'] == "1" ? "checked" : "") ?> /><span>Enable</span></div>
				 
				 <div class="pure-radio"><input <?php echo $default; ?> name="data[Admin][is_active]" value="0" type="radio" <?php echo (@$this->data['Admin']['is_active'] == "0" ? "checked" : "") ?> /><span>Disable</span></div>
				 
			</div>
		
			<div class="buttons">
				
				<?php echo $form->input('Admin.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Admin.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='".$siteurl."/admin/admins/index'")); ?>
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	
	<script>
	
	var siteurl = "<?php echo $siteurl; ?>";
	$("#getpassword" ).click(function() 
	{
		
		$.ajax({
			type:"GET",
			url : siteurl+'/admin/admins/getpassword/',
			data:"",

			beforeSend: function() {


			},
			complete: function(){


			},
			success:function (resp){
					$('#AdminCustomPassword').val(resp);
			}	
		});
	});		
	</script>