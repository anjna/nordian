	<?php 
		$url= array();
		if(isset($keyword) && !empty($keyword))
		$url['keyword']=$keyword;
	?>
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage Chapter Questions</strong></a></article>
		<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding">
		  <h3><span>List of Chapter Questions</span></h3>
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
							
							<?php echo $form->create('ChapterQuestion',array('controller'=>'chapter_questions','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form') )?> 
							
							<?php echo $form->input('ChapterQuestion.keyword', array('type'=>'text','id'=>'keyword','label'=>false,'div'=> false)); ?>
							
							<?php echo $form->input('ChapterQuestion.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>
							
							<?php echo $form->submit('GO',array('div'=> false,'class'=>'btn')); ?><br />
							
							<p>'<?php echo $count; ?>' results returned!</p>
							<?php echo $form->end();?>
							
							
							
							<label><span id="hashid">OR</span></label>
							
					
							<label for="select">
								
								<?php echo $form->create('ChapterQuestion',array('controller'=>'chapter_questions','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form','style'=>'width:508px !important;') )?>

								<?php 
									echo $form->input('ChapterQuestion.course_id', array('type' => 'select', 'options' => $courselist,'empty'=>'Select Courses','label'=>false,'style'=>'margin-left:0px;margin-right:3px'));
								?>
								

								<?php 
									echo $form->input('ChapterQuestion.subject_id', array('type' => 'select', 'empty'=>'Select Subjects','label'=>false,'style'=>'margin-left:0px;margin-right:3px'));
								?>
								

								<?php 
									echo $form->input('ChapterQuestion.chapter_id', array('type' => 'select', 'empty'=>'Select Chapters','label'=>false,'style'=>'margin-left:0px;;'));
								?>

								<?php echo $form->input('ChapterQuestion.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>


								<?php echo $form->submit('GO',array('div'=> false,'class'=>'btn')); ?>

								<?php echo $form->end();?>
								
							</label>
							<div class="rightpanel"> 
							<a href="<?php echo Configure::read('adminUrl'); ?>/chapter_questions/add"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Add Chapter Question</a>
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
				<?php echo $paginator->sort('Course Name','ChapterQuestion.course_id',array('url'=>$url));?>				
			</th>
		<?php
			} ?>
			
		<?php
			if(empty($subject_id))
			{
		?>
		<th>
			<?php echo $paginator->sort('Subject Name','ChapterQuestion.subject_id',array('url'=>$url));?>				
		</th>
		<?php
		} ?>
		
		<?php
			if(empty($chapter_id))
			{
		?>
		 <th>
			<?php echo $paginator->sort('Chapter Name','ChapterQuestion.chapter_id',array('url'=>$url));?>				
		</th>
		<?php
		} ?>
         
        
          <th align="center">		  
				<?php echo $paginator->sort('Question','question',array('url'=>$url));?>
		  </th>
		  
		  <th>
		  <?php echo $paginator->sort('Answer','answser',array('url'=>$url));?>
		  </th>
		  <th align="center">		  
				<?php echo $paginator->sort('Modified Date','modified',array('url'=>$url));?>
		  </th>
          <th align="center">Actions</th>
        </tr>
		<?php
			//pr($allChapters);
			$i=1;
			$class = "alternate-row";
			if(count($allChapterQuestions))
			{
				foreach($allChapterQuestions as $data)
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
					 
					  <td><?php echo strip_tags($data['ChapterQuestion']['question']); ?></td>
						<td><?php echo $data['ChapterQuestion']['answer']; ?></td>
						
					  <td> <?php echo date('d/m/y',strtotime($data['ChapterQuestion']['modified']));?></td>
					  <td align="center">
					  
						<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'chapter_questions','action'=>'add',$data['ChapterQuestion']['id']),array('escape'=>false)) ;?>
								
						<?php echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'chapter_questions','action'=>'delete',$data['ChapterQuestion']['id']),array('escape'=>false),'Are you sure you want to delete this record?');?>
						
							<?php if($data['ChapterQuestion']['status'] == 'inprogress' ){ 
							echo $html->link($html->image("icon_deactive.png",array("border"=>0,"alt"=>'In-Progress',"title"=>'In-Progress',"width"=>'16',"height"=>'16')),array('controller'=>'chapter_questions','action'=>'admin_changestatus',$data['ChapterQuestion']['id'],'ready'),array('escape'=>false),'Are you sure you want to ready this record?') ;
						} else {
							echo $html->link($html->image("icon_active.png",array("border"=>0,"alt"=>'Ready',"title"=>'Ready',"width"=>'16',"height"=>'16')),array('controller'=>'chapter_questions','action'=>'admin_changestatus',$data['ChapterQuestion']['id'],'inprogress'),array('escape'=>false),'Are you sure you want to inprogress this record?') ;
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
	
	var subject_id = "<?php echo @$this->data['ChapterQuestion']['subject_id']; ?>";
	$("#ChapterQuestionCourseId" ).change(function() 
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
					$('#ChapterQuestionSubjectId').html(resp);
					//alert(subject_id);
					$("#ChapterQuestionSubjectId" ).val(subject_id);
					$("#ChapterQuestionSubjectId" ).trigger('change');	
			}	
		});
	});
	
	var course_id = "<?php echo @$this->data['ChapterQuestion']['course_id']; ?>";	
	if(course_id != ''){	
		$("#ChapterQuestionCourseId" ).trigger('change');		
	}
	
	var chapter_id = "<?php echo @$this->data['ChapterQuestion']['chapter_id']; ?>";	
	$("#ChapterQuestionSubjectId" ).change(function() 
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
					$('#ChapterQuestionChapterId').html(resp);
					//alert(chapter_id);
					$("#ChapterQuestionChapterId" ).val(chapter_id);
			}	
		});
	});	
	</script>