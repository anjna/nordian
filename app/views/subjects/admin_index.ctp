	<?php 
		 $url= array();
		if(isset($keyword) && !empty($keyword))
		$url['keyword']=$keyword;
		
		if(isset($cid) && !empty($cid))
		$url['cid']=$cid;
	?>
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage Subjects</strong></a></article>
		<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding">
		  <h3><span>List of Subjects</span></h3>
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
							
							
							<?php echo $form->create('Subject',array('controller'=>'subjects','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form') )?> <?php echo $form->input('Subject.keyword', array('placeholder'=>'Search By Keyword','type'=>'text','id'=>'keyword','label'=>false,'div'=> false)); ?>&nbsp;&nbsp;<?php echo $form->input('Subject.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?><?php echo $form->submit('GO',array('div'=> false,'class'=>'btn')); ?>
							<br />
							<p>'<?php echo $count; ?>' results returned!</p>
							<?php echo $form->end();?>
							
							
							<label><span>OR</span></label>
							
					
							<label for="select">
								<?php echo $form->create('Subject',array('controller'=>'Courses','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form') )?>

								<?php
								echo $this->Form->input('Subject.cid', array('label'=>false,'type' => 'select', 'options' => $courselist, 'empty' => 'All Courses'));
								?>
								<?php echo $form->input('Subject.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?><?php echo $form->submit('GO',array('div'=> false,'class'=>'btn')); ?>

								<?php echo $form->end();?>			
							</label>
							<div class="rightpanel"> 
							<a href="<?php echo Configure::read('adminUrl'); ?>/subjects/add"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Add Subject</a>
							</div>
					</div>
			</td>
        </tr>
        
		<tr class="first-row">
		<?php
			if(empty($cid)) { ?>
          <th>
			<?php echo $paginator->sort('Course Name','course_id',array('url'=>$url));?>
				
		</th>
		<?php
			} ?>
		<th>
			<?php echo $paginator->sort('Subject Code','code',array('url'=>$url));?>
				
		</th>
          <th align="left">
			<?php echo $paginator->sort('Subject Name','name',array('url'=>$url));?>
		  </th>
     
          <th align="left">No of Chapters</th>
          <th align="left">No of Summaries</th>
          <th align="left">No of Qns.</th>
          <th align="left">		  
		  
                <?php		
				echo $paginator->sort('Modified Date','modified',array('url'=>$url));
				?>
		  </th>
          <th align="center">Actions</th>
        </tr>
		<?php
			$i=1;
			$class = "alternate-row";
			if(count($allsubjects))
			{
				foreach($allsubjects as $data)
				{	
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}
			?>
				
					<tr class="<?php echo $class; ?>">
						<?php
							if(empty($cid)) {?>
						<td><?php echo $data['Course']['name'];?></td>
						<?php } ?>
					   <td><?php echo $data['Subject']['intcode'];?></td>
						<td><?php echo $data['Subject']['name']; ?></td>
					 
					  <td><?php echo $html->link(count($data['Chapter']),array('controller'=>'chapters','action'=>'index',$data['Subject']['id'],'subject_id'),array('escape'=>false)) ;?></td>
					  
					  <td><?php echo $html->link(count($data['Summary']),array('controller'=>'summaries','action'=>'index',$data['Subject']['id'],'subject_id'),array('escape'=>false)) ;?></td>
					  
					  <td><?php echo $html->link(count($data['ChapterQuestion']),array('controller'=>'chapter_questions','action'=>'index',$data['Subject']['id'],'subject_id'),array('escape'=>false)) ;?></td>
					  
					  <td> <?php echo date('d/m/y',strtotime($data['Subject']['modified']));?></td>
					  <td align="center">
					  
						<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'subjects','action'=>'add',$data['Subject']['id']),array('escape'=>false)) ;?>
						
						
						
						<?php 
						if($data['Subject']['status'] == 'unpublish' ){ 
						echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'subjects','action'=>'delete',$data['Subject']['id']),array('escape'=>false),'Are you sure you want to delete this record?');
						}
						?>
						
						<?php if($data['Subject']['is_active'] == 'inprogress' ){ 
							echo $html->link($html->image("icon_deactive.png",array("border"=>0,"alt"=>'In-Progress',"title"=>'In-Progress',"width"=>'16',"height"=>'16')),array('controller'=>'subjects','action'=>'admin_changeisactive',$data['Subject']['id'],'ready'),array('escape'=>false),'Are you sure you want to ready this record?') ;
						} else {
							echo $html->link($html->image("icon_active.png",array("border"=>0,"alt"=>'Ready',"title"=>'Ready',"width"=>'16',"height"=>'16')),array('controller'=>'subjects','action'=>'admin_changeisactive',$data['Subject']['id'],'inprogress'),array('escape'=>false),'Are you sure you want to inprogress this record?') ;
						}?>
					  
						<?php if($data['Subject']['status'] == 'unpublish' ){ 
							echo $html->link($html->image("UnPublish-icon.png",array("border"=>0,"alt"=>'Un-Publish',"title"=>'Un-Publish',"width"=>'16',"height"=>'16')),array('controller'=>'subjects','action'=>'admin_changestatus',$data['Subject']['id'],'publish'),array('escape'=>false),'Are you sure you want to enable this record?') ;
						} else {
							echo $html->link($html->image("publish-icon.png",array("border"=>0,"alt"=>'Publish',"title"=>'Publish',"width"=>'16',"height"=>'16')),array('controller'=>'subjects','action'=>'admin_changestatus',$data['Subject']['id'],'unpublish'),array('escape'=>false),'Are you sure you want to unpublish this record?') ;
						}?>
					  
					  </td>
					</tr>
			<?php
					$i++;				
				}
			}
			else{
        ?> 
				<tr class="alternate-row"><td colspan="8">No Records. </td></tr>
		<?php
				} ?>		
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