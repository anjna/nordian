	<?php 
		$url= array();
		if(isset($keyword) && !empty($keyword))
		$url['keyword']=$keyword;
	?>
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage Summaries</strong></a></article>
		<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding">
		  <h3><span>List of Summaries</span></h3>
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
							
							<?php echo $form->create('Summary',array('controller'=>'summaries','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form') )?> 
							
							<?php echo $form->input('Summary.keyword', array('type'=>'text','id'=>'keyword','label'=>false,'div'=> false)); ?>
							
							<?php echo $form->input('Summary.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>
							
							<?php echo $form->submit('GO',array('div'=> false,'class'=>'btn')); ?>
							<br />
							<p>'<?php echo $count; ?>' results returned!</p>
							<?php echo $form->end();?>
							
							
							
							<label><span>OR</span></label>
							
					
							<label for="select">
								
								<?php echo $form->create('Summary',array('controller'=>'summaries','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form','style'=>'width:498px;') )?>

								<?php 
									echo $form->input('Summary.course_id', array('type' => 'select', 'options' => $courselist,'empty'=>'Select Courses','label'=>false,'style'=>'margin-left:0px;margin-right: 3px;'));
								?>
								

								<?php 
									echo $form->input('Summary.subject_id', array('type' => 'select', 'empty'=>'Select Subjects','label'=>false,'style'=>'margin-left:0px;margin-right: 3px;'));
								?>
								

								<?php 
									echo $form->input('Summary.chapter_id', array('type' => 'select', 'empty'=>'Select Chapters','label'=>false,'style'=>'margin-left:0px;margin-right: 3px;'));
								?>

								<?php echo $form->input('Summary.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>


								<?php echo $form->submit('GO',array('div'=> false,'class'=>'btn')); ?>

								<?php echo $form->end();?>
								
							</label>
							<div class="rightpanel"> 
							<a href="<?php echo Configure::read('adminUrl'); ?>/summaries/add"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Add Summary</a>
							</div>
					</div>
			</td>
        </tr>
        
		<tr class="first-row">
		<?php
			if(empty($course_id))
			{
		?>
			<th>
				<?php echo $paginator->sort('Course Name','Summary.course_id',array('url'=>$url));?>				
			</th>
		<?php
			} ?>
			
		<?php
			if(empty($subject_id))
			{
		?>
		<th>
			<?php echo $paginator->sort('Subject Name','Summary.subject_id',array('url'=>$url));?>				
		</th>
		<?php
		} ?>
		
		<?php
			if(empty($chapter_id))
			{
		?>
		 <th>
			<?php echo $paginator->sort('Chapter Name','Summary.chapter_id',array('url'=>$url));?>				
		</th>
		<?php
		} ?>
          <th>
			<?php echo $paginator->sort('Summary','Summary.description',array('url'=>$url));?>				
		</th>
        
          <th align="center">		  
				<?php echo $paginator->sort('Modifed Date','Summary.modified',array('url'=>$url));?>
		  </th>
          <th align="center">Actions</th>
        </tr>
		<?php
			//pr($allChapters);
			$i=1;
			$class = "alternate-row";
			if(count($allSummaries))
			{
				foreach($allSummaries as $data)
				{	
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}
			?>
				
					<tr class="<?php echo $class; ?>">
					
					<?php						
						if(empty($course_id))
						{
					?>
							<td align="center">
								<?php 	
								
								echo $data['Course']['name'];?>
							</td>
					<?php
						} ?>
					<?php
						if(empty($subject_id))
						{
					?>	
						<td>
						<?php 	
						echo $data['Subject']['name'];?>
						</td>
					<?php
						}
						?>
					<?php
						if(empty($chapter_id))
						{
					?>
						<td>
						<?php 	
						echo $data['Chapter']['name'];?>
						</td>
					<?php
					} ?>					
					  <td align="center">
						<?php 	
							$description = $encrypt->_fnDecrypt($data['Summary']['description'], $sSecretKey);
							echo strip_tags(substr($description,0,100));
						?>
						</td>
					  
					  <td> <?php echo date('d/m/y',strtotime($data['Summary']['modified']));?></td>
					  <td align="center">
					  
						<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'summaries','action'=>'add',$data['Summary']['id']),array('escape'=>false)) ;?>
								
						<?php echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'summaries','action'=>'delete',$data['Summary']['id']),array('escape'=>false),'Are you sure you want to delete this record?');?>
						
						<?php if($data['Summary']['status'] == 'inprogress' ){ 
							echo $html->link($html->image("icon_deactive.png",array("border"=>0,"alt"=>'In-Progress',"title"=>'In-Progress',"width"=>'16',"height"=>'16')),array('controller'=>'summaries','action'=>'admin_changestatus',$data['Summary']['id'],'ready'),array('escape'=>false),'Are you sure you want to ready this record?') ;
						} else {
							echo $html->link($html->image("icon_active.png",array("border"=>0,"alt"=>'Ready',"title"=>'Ready',"width"=>'16',"height"=>'16')),array('controller'=>'summaries','action'=>'admin_changestatus',$data['Summary']['id'],'inprogress'),array('escape'=>false),'Are you sure you want to inprogress this record?') ;
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
	<script>
	
	var subject_id = "<?php echo @$this->data['Summary']['subject_id']; ?>";
	$("#SummaryCourseId" ).change(function() 
	{
		courseId = $(this).val();
		if(courseId == ""){
			return;
		}
		$.ajax({
			type:"GET",
			url:'/admin/subjects/getdropsubject/'+courseId,
			data:"",

			beforeSend: function() {


			},
			complete: function(){


			},
			success:function (resp){
					$('#SummarySubjectId').html(resp);
					//alert(subject_id);
					$("#SummarySubjectId" ).val(subject_id);
					$("#SummarySubjectId" ).trigger('change');	
			}	
		});
	});
	
	var course_id = "<?php echo @$this->data['Summary']['course_id']; ?>";	
	if(course_id != ''){	
		$("#SummaryCourseId" ).trigger('change');		
	}
	
	var chapter_id = "<?php echo @$this->data['Summary']['chapter_id']; ?>";	
	$("#SummarySubjectId" ).change(function() 
	{
		subjectId = $(this).val();
		
		if(subjectId == ""){
			return;
		}
		$.ajax({
			type:"GET",
			url:'/admin/subjects/getdropchapter/'+subjectId,
			data:"",

			beforeSend: function() {


			},
			complete: function(){


			},
			success:function (resp){
					$('#SummaryChapterId').html(resp);
					//alert(chapter_id);
					$("#SummaryChapterId" ).val(chapter_id);
			}	
		});
	});		
	</script>