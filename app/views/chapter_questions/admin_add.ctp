	<!-- This code user for editor -->
	<script>
		var getId = "cq";
	</script>
	<!-- End -->
	<?php 
	echo $javascript->link(array("/ckeditor/ckeditor","/ckeditor/adapters/jquery"));
	?> 
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">Manage Chapter Question</a> » <a href="javascript:void(0);"><strong><?php echo $label; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo $label; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('ChapterQuestion',array('controller'=>'chapter_questions','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
					if(!isset($this->data['ChapterQuestion']['created']))
					{	
						echo date('d/m/Y');
					}
					else{
						echo date('d/m/Y',strtotime($this->data['ChapterQuestion']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['ChapterQuestion']['modified']))
				{	
					echo date('d/m/Y');
				}
				else{
					echo date('d/m/Y',strtotime($this->data['ChapterQuestion']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Course<span>*</span></label>				
				<?php 
						echo $form->input('ChapterQuestion.course_id', array('type' => 'select', 'options' => $courselist,'empty'=>'Select Course','label'=>false,'error'=>false,'style'=>'margin-left:0px;'));
					?>	
			</div>

			<div class="pure-control-group">
				<label for="name">Subject <span>*</span></label>
				<?php 
					echo $form->input('ChapterQuestion.subject_id', array('type' => 'select', 'empty'=>'Select Subject','label'=>false,'style'=>'margin-left:0px;','error'=>false));
				?>
			</div>
			
			<div class="pure-control-group">
				<label for="name">Chapter <span>*</span></label>
				<?php 
				echo $form->input('ChapterQuestion.chapter_id', array('type' => 'select', 'empty'=>'Select Chapter','label'=>false,'style'=>'margin-left:0px;','error'=>false));
			?>
			</div>
			
		
			<div class="pure-control-group">
				<label for="name">Question <span>*</span></label><div class="editor">
				 <?php 	
					$des = !empty($this->data['ChapterQuestion']['question']) ? $this->data['ChapterQuestion']['question'] : "";	
					echo $form->input('ChapterQuestion.question', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false)); 
				?>		
				</div> 				
			</div>
			
			<div class="pure-control-group">
				<label for="name">Answer 1 <span>*</span></label><div class="editor">
				 <?php 
					$des = !empty($this->data['ChapterQuestion']['option1']) ? $encrypt->_fnDecrypt($this->data['ChapterQuestion']['option1'], $sSecretKey) : "";	
					echo $form->input('ChapterQuestion.option1', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false)); ?>	
		
				</div> 	
				<div class="pure-radio"><input style="margin-left:180px;"  name="data[ChapterQuestion][answer]" value="option1" type="radio" <?php echo (@$this->data['ChapterQuestion']['answer'] == "option1" ? "checked" : "") ?> /><span>This is correct Answer</span></div>				
			</div>
			
			<div class="pure-control-group">
				<label for="name">Answer 2 <span>*</span></label><div class="editor">
				 <?php 
					$des = !empty($this->data['ChapterQuestion']['option2']) ? $encrypt->_fnDecrypt($this->data['ChapterQuestion']['option2'], $sSecretKey) : "";	
					echo $form->input('ChapterQuestion.option2', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false)); ?>	
		
				</div> 	
				<div class="pure-radio"><input style="margin-left:180px;"  name="data[ChapterQuestion][answer]" value="option2" type="radio" <?php echo (@$this->data['ChapterQuestion']['answer'] == "option2" ? "checked" : "") ?> /><span>This is correct Answer</span></div>		
			</div>
			
			<div class="pure-control-group">
				<label for="name">Answer 3</label><div class="editor">
				 <?php 
					$des = !empty($this->data['ChapterQuestion']['option3']) ? $encrypt->_fnDecrypt($this->data['ChapterQuestion']['option3'], $sSecretKey) : "";	
					echo $form->input('ChapterQuestion.option3', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false)); ?>	
		
				</div>
				<div class="pure-radio"><input style="margin-left:180px;"  name="data[ChapterQuestion][answer]" value="option3" type="radio" <?php echo (@$this->data['ChapterQuestion']['answer'] == "option3" ? "checked" : "") ?> /><span>This is correct Answer</span></div>	 					
			</div>
			
			<div class="pure-control-group">
				<label for="name">Answer 4</label><div class="editor">
				<?php 
					$des = !empty($this->data['ChapterQuestion']['option4']) ? $encrypt->_fnDecrypt($this->data['ChapterQuestion']['option4'], $sSecretKey) : "";	
					echo $form->input('ChapterQuestion.option4', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false)); ?>		
				</div> 	

				<div class="pure-radio"><input style="margin-left:180px;"  name="data[ChapterQuestion][answer]" value="option4" type="radio" <?php echo (@$this->data['ChapterQuestion']['answer'] == "option4" ? "checked" : "") ?> /><span>This is correct Answer</span></div>	
			</div>
			
			<!--
			<div class="pure-control-group">
				<label for="name">Answer <span>*</span></label><div>
				<?php 

					//echo $form->input('answer', array('type' => 'select', 'options' => array('option1'=>'option1','option2'=>'option2','option3'=>'option3','option4'=>'option4',),'empty'=>'Select Answer','label'=>false,'style'=>'margin-left:0px;','error'=>false));
				?>	
				</div> 				
			</div>
			-->
			
			<div class="pure-control-group">
				<label for="name">Status  <span>*</span></label>
					<?php
					$default = "";
					if(!isset($this->data['ChapterQuestion']['status'])){
						$default = "checked";
					}
				?>

				 <div class="pure-radio"><input   name="data[ChapterQuestion][status]" value="ready" type="radio" <?php echo ($this->data['ChapterQuestion']['status'] == "ready" ? "checked" : "") ?> /><span>Ready</span></div>
				 
				 <div class="pure-radio"><input <?php echo $default; ?> name="data[ChapterQuestion][status]" value="inprogress" type="radio" <?php echo ($this->data['ChapterQuestion']['status'] == "inprogress" ? "checked" : "") ?> /><span>In-Progress</span></div>
				 
			</div>
		
			<div class="buttons">
				
				<?php echo $form->input('ChapterQuestion.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('ChapterQuestion.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='/admin/chapter_questions/index'")); ?>
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	<script>
	$( document ).ready( function() {
		$( 'textarea#ChapterQuestionOption1' ).ckeditor();
		$( 'textarea#ChapterQuestionOption2' ).ckeditor();
		$( 'textarea#ChapterQuestionOption3' ).ckeditor();
		$( 'textarea#ChapterQuestionOption4' ).ckeditor();
		$( 'textarea#ChapterQuestionQuestion' ).ckeditor();
	} );
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