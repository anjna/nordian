	<?php echo $javascript->link(array("/ckeditor/ckeditor","/ckeditor/adapters/jquery")); ?> 
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">Manage Summaries</a> » <a href="javascript:void(0);"><strong><?php echo $label; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo $label; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('Summary',array('controller'=>'summaries','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
					if(!isset($this->data['Summary']['created']))
					{	
						echo date('d/m/Y');
					}
					else{
						echo date('d/m/Y',strtotime($this->data['Summary']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Summary']['modified']))
				{	
					echo date('d/m/Y');
				}
				else{
					echo date('d/m/Y',strtotime($this->data['Summary']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Course<span>*</span></label>				
				<?php 
						echo $form->input('Summary.course_id', array('type' => 'select', 'options' => $courselist,'empty'=>'Select Course','label'=>false,'style'=>'margin-left:0px;'));
					?>		
			</div>

			<div class="pure-control-group">
				<label for="name">Subject <span>*</span></label>
				<?php 
					echo $form->input('Summary.subject_id', array('type' => 'select', 'empty'=>'Select Subject','label'=>false,'style'=>'margin-left:0px;'));
				?>
			</div>
			
			<div class="pure-control-group">
				<label for="name">Chapter Name <span>*</span></label>
				<?php 
					echo $form->input('Summary.chapter_id', array('type' => 'select', 'empty'=>'Select Chapter','label'=>false,'style'=>'margin-left:0px;'));
				?>
			</div>
			
		
			<div class="pure-control-group">
				<label for="name">Description <span>*</span></label><div class="editor">
				<?php 
					$des = !empty($this->data['Summary']['description']) ? $encrypt->_fnDecrypt($this->data['Summary']['description'], $sSecretKey) : "";				
					echo $form->input('Summary.description', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des)); ?>	
				</div> 				
			</div>
			
			<div class="pure-control-group">
				<label for="name">Status  <span>*</span></label>
				<?php
						$default = "";
						if(!isset($this->data['Summary']['status'])){
							$default = "checked";
						}
					?>

				 <div class="pure-radio"><input   name="data[Summary][status]" value="ready" type="radio" <?php echo ($this->data['Summary']['status'] == "ready" ? "checked" : "") ?> /><span>Ready</span></div>
				 
				 <div class="pure-radio"><input <?php echo $default; ?> name="data[Summary][status]" value="inprogress" type="radio" <?php echo ($this->data['Summary']['status'] == "inprogress" ? "checked" : "") ?> /><span>In-Progress</span></div>
				 
			</div>
		
			<div class="buttons">
				
				<?php echo $form->input('Summary.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Summary.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='/admin/summaries/index'")); ?>
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	<script>
	$( document ).ready( function() {
	$( 'textarea#SummaryDescription' ).ckeditor();
	} );
	
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