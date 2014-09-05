	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
			<?php echo $javascript->link(array("jquery-ui-sliderAccess.js"));?>
   	<?php echo $javascript->link(array("jquery-ui-timepicker-addon.js"));?>
	
	<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css" type="text/css" media="all" />
	<?php 
								$url= array();
								if(isset($keyword) && !empty($keyword))
								$url['keyword']=$keyword;
								
								if(isset($cid) && !empty($cid))
								$url['cid']=$cid;	
	?>
								<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage Tasks</strong></a></article>
								<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
								<article class="pageheadding">
								 <h3><span>List of Tasks</span></h3>
								</article>
    <article class="common-container">
		      <?php
					if ($session->check('Message.flash')){ ?>
									<article class="success_display_msg"><img width="22" height="22" alt="" src="/img/img_tick_grn.png"><span><?php echo $session->flash();?></span></article>       
					<?php }?>	
						<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
									<tr class="header">
								   <td colspan="8" align="left">
				  <div class="formouter">
				  <?php if($utype!="sme")
							{?>
						<label for="select">
											    <?php echo $form->create('Task',array('controller'=>'Tasks','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form') )?>					
												<?php
												echo $this->Form->input('Task.alluserlist', array('label'=>false,'type' => 'select', 'options' => $userlist, 'empty' => 'All Users'));
												?>
												<?php //echo $form->input('Task.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>
						</label>					
						<label for="select">	
						
												<?php echo $form->input('Task.start_date', array('id'=>'start_date','type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
												<?php //echo $form->input('Task.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>
												<p>'<?php //echo $count; ?>' results returned!</p>
						</label>
						<label for="select">	
												<?php echo $form->input('Task.end_date', array('id'=>'end_date','type'=>'text','label'=>false,'div'=>false,'error'=>false)); ?>
												<?php echo $form->input('Task.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>
												<?php echo $form->submit('Go',array('div'=> false,'class'=>'btn')); ?><br />
												<p>'<?php //echo $count; ?>' results returned!</p>
												<?php echo $form->end();?>
						</label>
							<?php } ?>
							<?php
							if($utype!="admin")
							{
							?>
											<div class="rightpanel"> 
											<a href="<?php echo Configure::read('adminUrl'); ?>/tasks/add"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Add Task</a>
											</div>
		      <?php	}
						  else
						  {
						  ?>
										   <div class="rightpanel"> 
											<a href="<?php echo Configure::read('adminUrl'); ?>/tasks/senddsr"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Send Task</a>
											</div>
							<?php
							}?>
				</div>
			</td>
        </tr>
        
							<tr class="first-row">
							  <th>
								<?php		
									echo $paginator->sort('Project_id','project_id',array('url'=>$url));
								?>	
							</th>
						
							  <th align="center">
							   <?php		
									echo $paginator->sort('Project_reference','project_reference',array('url'=>$url));
								?>
							  </th>
							  
							  <th align="center">
							   <?php		
									echo $paginator->sort('Task_description','task_description',array('url'=>$url));
								?>
							  </th>
							  
							  <th align="center">
							   <?php		
									echo $paginator->sort('Project_type','project_type',array('url'=>$url));
								?>
							  </th>
							  
							  <th align="center">
							   <?php		
									echo $paginator->sort('Remarks','remarks',array('url'=>$url));
								?>
							  </th>
							  <th align="center">
							   <?php		
									echo $paginator->sort('created date','created',array('url'=>$url));
								?>
							  </th>
								<th align="center">
							   <?php		
									echo $paginator->sort('modified date','modified',array('url'=>$url));
								?>
							  </th>
							  <th align="center">Actions</th>

							</tr>
		<?php
			$i=1;
			$class = "alternate-row";
			
			//echo "<pre>";
		
	if(count($allCourses))
	{
				foreach($allCourses as $data)
				{		
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}
			      ?>		
					                  <td align="center"><?php echo $data['Task']['project_id'];?></td>
					  <?php
					if(empty($cid)) { ?>
					                 <td><?php echo $data['Task']['project_reference']; ;?></td>
					  <?php
					  } ?>
									  <td><?php echo $data['Task']['task_description']; ;?></td>
									  <td><?php echo $data['Task']['project_type']; ;?></td>
									  <td><?php echo $data['Task']['remarks']; ;?></td>
									  <td> <?php echo date('d-m-Y H:i:s',strtotime($data['Task']['created']));?></td>
									  <td> <?php echo date('d-m-Y H:i:s',strtotime($data['Task']['modified']));?></td>
									  
					  
					   
					 
					  
					  <td align="center">  
									<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'tasks','action'=>'add',$data['Task']['id']),array('escape'=>false)) ;?>						
									<?php echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'tasks','action'=>'delete',$data['Task']['id']),array('escape'=>false),'Are you sure you want to delete this record?');?>
					</td>
					
					</tr>
			<?php
					$i++;				
				//}
				//else{
        ?> 
			<!--	<tr class="alternate-row"><td colspan="8">No Records. </td></tr>!-->
		<?php
		//	}
		}
     }		
	 else{
        ?> 
				<tr class="alternate-row"><td colspan="8">No Records. </td></tr>
		<?php
			}
		?>
      </table>
      <article class="pagination">
		<div>
			<?php
				echo $this->Paginator->numbers(array('url'=>$url)).'&nbsp;';
				echo $paginator->prev('Previous',array('url'=>$url)).'&nbsp;';
				echo $this->Paginator->counter(array('url'=>$url)).'&nbsp;';
				echo $paginator->next('Next',array('url'=>$url)).'&nbsp;';
			?>
		</div>
		    <aside><span>Show</span>  <?php echo $common->display_items_per_page($dropdown_val); ?></aside>
      </article>
    </article>
<script language='JavaScript'>
	$(document).ready(function() {

		$('#start_date,#end_date').datetimepicker({dateFormat: 'yy-mm-dd'}); 
	});
	</script>
