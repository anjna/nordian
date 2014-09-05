
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">Manage Feedbacks</a> » <a href="javascript:void(0);"><strong><?php echo "Give Feedback"; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo "Give Feedback"; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create(null,array('controller'=>'topics','action'=>'feedbackuser','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
				<label for="name">Feedback<span>*</span></label>				
				<?php echo $form->input('Feedback.feedback', array('type'=>'text','placeholder'=>"",'label'=>false,'div'=>false,'error'=>false)); ?>				
			</div>

			<div class="pure-control-group">
				<label for="name">Comments <span>*</span></label>
				<?php echo $form->input('Feedback.comments', array('type'=>'textarea','label'=>false,'div'=>false,'error'=>false)); ?>
			</div>
                     
			<div class="pure-control-group">
				
			<?php echo $form->input('Feedback.topic_id', array('type'=>'hidden','value'=>$id,'label'=>false,'div'=>false,'error'=>false)); ?>
			</div>	 
				<div class="pure-control-group">
			<?php 
              // foreach($alldata as $data)
		               //{
						//	echo $form->input('Topic.allusers][',array('hiddenField' => false,'type'=>'checkbox','class'=>'case','value'=>$data['Admin']['email'],'label'=>false,'div'=>false)).'  '.$data['Admin']['fullname']." <br />";
					   //} ?>
				</div>		
			
		
			<div class="buttons">
				<?php echo $form->input('Feedback.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Feedback.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='".$siteurl."/admin/topics/index'")); ?>
			
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	