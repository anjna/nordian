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
     <?php echo $form->create('Topic',array('controller'=>'topics','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
					if(!isset($this->data['Topic']['created']))
					{	
						echo date('d/m/Y');
					}
					else{
						echo date('d/m/Y',strtotime($this->data['Topic']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Topic']['modified']))
				{	
					echo date('d/m/Y');
				}
				else{
					echo date('d/m/Y',strtotime($this->data['Topic']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Name<span>*</span></label>				
				<?php echo $form->input('Topic.topic', array('type'=>'text','placeholder'=>"",'label'=>false,'div'=>false,'error'=>false)); ?>				
			</div>

			<div class="pure-control-group">
				<label for="name">Description <span>*</span></label>
				<?php echo $form->input('Topic.description', array('type'=>'textarea','label'=>false,'div'=>false,'error'=>false)); ?>
			</div>
		
			<div class="pure-control-group">
				<label for="name">Presentator<span>*</span></label>
			<?php echo $form->input('Topic.presentator', array('type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
				</div> 			
				<div class="pure-control-group">
				<label for="name">Start Time<span>*</span></label>
			<?php echo $form->input('Topic.start_time', array('id'=>'start_time','type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
				</div>
				<div class="pure-control-group">
				<label for="name">End Time<span>*</span></label>
			<?php echo $form->input('Topic.end_time',array('id'=>'end_time','type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
				</div>
			<div class="pure-control-group">
				<label for="name">Select All SME's<span>*</span></label>
			<?php echo $form->checkbox('Topic.selectall', array('id'=>'selectall','type'=>'checkbox','label'=>false,'div'=>false,'error'=>false)).' '."Select All"; ?>
				</div>
				<style>.case {    margin: 0 0 0 178px !important;}</style>
				<div class="pure-control-group">
			<?php 
				
               foreach($alldata as $data)
		               {
						
							echo $form->input('Topic.allusers][',array('hiddenField' => false,'type'=>'checkbox','class'=>'case','value'=>$data['Admin']['email'],'label'=>false,'div'=>false)).'  '.ucfirst($data['Admin']['fullname'])." <br />";
						
					   } ?>
				</div>		
		
			<div class="buttons">
				
				<?php echo $form->input('Topic.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Topic.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='".$siteurl."/admin/topics/index'")); ?>
			
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	<script language='JavaScript'>
	$(document).ready(function() {
	    $('#selectall').click(function(event) {  //on click
		if(this.checked) { // check select status
		    $('.case').each(function() { //loop through each checkbox
		        this.checked = true;  //select all checkboxes with class "checkbox1"              
		    });
		}else{
		    $('.case').each(function() { //loop through each checkbox
		        this.checked = false; //deselect all checkboxes with class "checkbox1"                      
		    });        
		}
	    });
	//	$("#enddate").datepicker({ dateFormat: "dd-mm-yy" }).val()
		$('#start_time, #end_time').datetimepicker({dateFormat: 'yy-mm-dd'}); 
	});
	</script>