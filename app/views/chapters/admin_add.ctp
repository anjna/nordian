	<?php echo $javascript->link(array("/ckeditor/ckeditor","/ckeditor/adapters/jquery")); ?> 
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/courses">Manage Courses</a> » <a href="javascript:void(0);"><strong><?php echo $label; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo $label; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('Chapter',array('controller'=>'chapters','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?> 
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
					if(!isset($this->data['Course']['created']))
					{	
						echo date('d/m/Y');
					}
					else{
						echo date('d/m/Y',strtotime($this->data['Course']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Course']['modified']))
				{	
					echo date('d/m/Y');
				}
				else{
					echo date('d/m/Y',strtotime($this->data['Course']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Course<span>*</span></label>				
				<?php 
					echo $form->input('Chapter.course_id', array('type' => 'select', 'options' => $courselist,'empty'=>'Select Course','label'=>false,'style'=>'margin-bottom:10px;','error'=>false));
				?>			
			</div>

			<div class="pure-control-group">
				<label for="name">Subject <span>*</span></label>
				<?php 
					echo $form->input('Chapter.subject_id', array('type' => 'select', 'empty'=>'Select Subject','label'=>false,'style'=>'margin-bottom:10px;','error'=>false));
				?>
			</div>
			
			<div class="pure-control-group">
				<label for="name">Chapter Name <span>*</span></label>
				<?php echo $form->input('Chapter.name', array('type'=>'text','id'=>'title','label'=>false,'error'=>false)); ?>    
			</div>
			
		
			<div class="pure-control-group">
				<label for="name">Description <span>*</span></label><div class="editor">
				<?php 
						$des = !empty($this->data['Chapter']['description']) ? $encrypt->_fnDecrypt($this->data['Chapter']['description'], $sSecretKey) : "";				
						echo $form->input('Chapter.description', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false));
				?>
				</div> 				
			</div>
			
			<div class="pure-control-group">
				<label for="name">Status  <span>*</span></label>
				<?php
						$default = "";
						if(!isset($this->data['Chapter']['status'])){
							$default = "checked";
						}
					?>

				 <div class="pure-radio"><input   name="data[Chapter][status]" value="ready" type="radio" <?php echo ($this->data['Chapter']['status'] == "ready" ? "checked" : "") ?> /><span>Ready</span></div>
				 
				 <div class="pure-radio"><input <?php echo $default; ?> name="data[Chapter][status]" value="inprogress" type="radio" <?php echo ($this->data['Chapter']['status'] == "inprogress" ? "checked" : "") ?> /><span>In-Progress</span></div>
				 
			</div>
		
			<div class="buttons">
				
				<?php echo $form->input('Chapter.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Chapter.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='/admin/chapters/index'")); ?>
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>
	<script>
	$( document ).ready( function() {
		$( 'textarea#ChapterDescription' ).ckeditor();
	
	} );
	var subject_id = "<?php echo @$this->data['Chapter']['subject_id']; ?>";
	$("#ChapterCourseId" ).change(function() 
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
					$('#ChapterSubjectId').html(resp);
					//alert(subject_id);
					$("#ChapterSubjectId" ).val(subject_id);
			}	
		});
	});
	var course_id = "<?php echo @$this->data['Chapter']['course_id']; ?>";
	
	if(course_id != ''){	
		$("#ChapterCourseId" ).trigger('change');
		
	}
	</script>