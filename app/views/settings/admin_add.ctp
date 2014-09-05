	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/settings">Manage Setting</a> » <a href="javascript:void(0);"><strong>Edit Setting</strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo 'Update Setting'; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('Setting',array('controller'=>'settings','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
					if(!isset($this->data['Setting']['created']))
					{	
						echo date('d/m/Y');
					}
					else{
						echo date('d/m/Y',strtotime($this->data['Course']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Course']['modified']))
				{	
					echo date('d/m/Y');
				}
				else{
					echo date('d/m/Y',strtotime($this->data['Course']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Setting Name<span>*</span></label>				
				<?php echo $form->input('Setting.name', array('readonly'=>'readonly','type'=>'text','placeholder'=>"",'label'=>false,'div'=>false,'error'=>false)); ?>				
			</div>

			<div class="pure-control-group">
				<label for="name">Value<span>*</span></label>
				<?php echo $form->input('Setting.value', array('type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
			</div>
		
			<div class="buttons">
				
				<?php echo $form->input('Setting.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Setting.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit('Update Setting',array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='/admin/settings/index'")); ?>
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	<script>
	$( document ).ready( function() {
		$( 'textarea#CourseDescription' ).ckeditor();		
	} );
	</script>