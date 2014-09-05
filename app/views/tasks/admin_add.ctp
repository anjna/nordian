<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
			<?php echo $javascript->link(array("jquery-ui-sliderAccess.js"));?>
   	<?php echo $javascript->link(array("jquery-ui-timepicker-addon.js"));?>
	
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css" type="text/css" media="all" />
		
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">Manage Courses</a> » <a href="javascript:void(0);"><strong><?php echo $label; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo $label; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('Task',array('controller'=>'tasks','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
					if(!isset($this->data['Task']['created']))
					{	
						echo date('Y-m-d H:i:s ');
					}
					else{
						echo date('Y-m-d H:i:s ',strtotime($this->data['Task']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Task']['modified']))
				{	
					echo date('Y-m-d H:i:s ');
				}
				else{
					echo date('Y-m-d H:i:s ',strtotime($this->data['Task']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Project id<span>*</span></label>				
				<?php echo $form->input('Task.project_id', array('type'=>'text','placeholder'=>"",'label'=>false,'div'=>false,'error'=>false)); ?>				
			</div>

			<div class="pure-control-group">
				<label for="name">Project_reference<span>*</span></label>
				<?php echo $form->input('Task.project_reference', array('type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
			</div>
		
			<div class="pure-control-group">
				<label for="name">Task_Description<span>*</span></label>
			
			<?php echo $form->input('Task.task_description', array('type'=>'textarea','label'=>false,'div'=>false,'error'=>false)); ?>
				</div> 			
				<div class="pure-control-group">
				<label for="name">Project_Type<span>*</span></label>
			<?php echo $form->input('Task.project_type', array('type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
				</div>
              <div class="pure-control-group">
				<label for="name">Remarks<span>*</span></label>
			<?php echo $form->input('Task.remarks', array('type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
				</div>
		         
			<div class="buttons">
				
				<?php echo $form->input('Task.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Task.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='".$siteurl."/admin/tasks/index'")); ?>
			
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	<script language='JavaScript'>
	$(document).ready(function() {
	
		$('#start_time').datetimepicker({dateFormat: 'yy-mm-dd'}); 
	});
	</script>