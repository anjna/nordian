  <article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">View Feedbacks</a> » <a href="javascript:void(0);"><strong><?php echo "View Feedback"; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo "view Feedback"; ?></span></h3>
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
		  
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
        <tr class="header">
      <td colspan="3" align="left">
			
			</td>
        </tr>
			<tr class="first-row">
          <th>Users</th>
	
          <th align="center">Feedback</th>
		  
		  <th align="center">Comments</th>
	     </tr>	
		
        <?php
		/*	$i=1;
			$class = "alternate-row";
			if(count($allCourses))
			{
		     //pr($allCourses);
				foreach($allCourses as $data)
				{	
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}*/
		
		if(!empty($feedbackuserid['Feedback']))
        {		
		foreach($feedbackuserid['Feedback'] as $info)
			{
		
			?>
			<tr>
			  <td align="center">
			<?php	
				echo $info['fullname'];
			?>	
		     </td>
	
          <td align="center">
		   <?php			   
	    
				echo $info['feedback'];
			
			?>
		  </td>
		  
		  <td align="center">
		   <?php		
			
				echo $info['comments'];
			
			?>
		  </td>
		  
        </tr>	
		<?php 
		  }
		  }
		  else{
        ?> 
				<tr class="alternate-row"><td colspan="3" >No Records. </td></tr>
		<?php
				} ?>	
		
		
      </table>
			
			<div class="buttons">
				<?php echo $form->input('Feedback.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Feedback.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
			
				
				<?php echo $form->button('Back',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='".$siteurl."/admin/topics/index'")); ?>
			
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	