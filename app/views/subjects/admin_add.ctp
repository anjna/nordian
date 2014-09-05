	<?php echo $javascript->link(array("/ckeditor/ckeditor","/ckeditor/adapters/jquery")); ?> 
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins">Home</a> » <a href="<?php echo Configure::read('adminUrl'); ?>/subjects">Manage Subjects</a> » <a href="javascript:void(0);"><strong><?php echo $label; ?></strong></a></article>
    <article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a>
	</article>
    <article class="pageheadding">
      <h3><span><?php echo $label; ?></span></h3>
    </article>
    <article class="common-container">
     <?php echo $form->create('Subject',array('controller'=>'subjects','action'=>'add','method'=>'POST','name'=>'frmWebpage','id'=>'form') )?>  
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
					if(!isset($this->data['Subject']['created']))
					{	
						echo date('d/m/Y');
					}
					else{
						echo date('d/m/Y',strtotime($this->data['Subject']['created']));
					}
				?>    
				<br>
				Date Updated:
				<?php 
				if(!isset($this->data['Subject']['modified']))
				{	
					echo date('d/m/Y');
				}
				else{
					echo date('d/m/Y',strtotime($this->data['Subject']['modified']));
				}
				?> 	
		
			</div>		  
		  
			<div class="pure-control-group">
				<label for="name">Select the course you want to add the subject to <span>*</span></label>				
				 <?php 
					echo $form->input('Subject.course_id', array('type' => 'select', 'options' => $courselist,'empty'=>'Select Chapter','label'=>false,'error'=>false));
				?>			
			</div>
			
			<div class="pure-control-group">
				<label for="name">&nbsp;</label>
				
				 <div class="pure-radio"><input class="choice"  checked  name="data[Subject][type]" value="create" type="radio" /><span>Create New Subject</span></div>
				 
				 <div class="pure-radio"><input class="choice"  name="data[Subject][type]" id="extoption" value="existing" type="radio" /><span>Create From Existing</span></div>
				 
			</div>
		
			<div id="existing" style="display:none" class="pure-control-group">
				<label for="name">&nbsp;</label>
				<?php 
					echo $form->input('Subject.copycourse_id', array('value'=>@$this->data['Subject']['existing'],'type' => 'select', 'options' => $courselist,'empty'=>'Select Chapter','label'=>false,'error'=>false));
				?>	
				
				
				<label for="name">&nbsp;</label>
				
				<div id="subjectlist">
				</div>
			</div>
			<div id="create" >
			
				<div class="pure-control-group">
					<label for="name">External Code <span>*</span></label>				
					<?php echo $form->input('Subject.extcode', array('type'=>'text','id'=>'title','label'=>false,'error'=>false)); ?>		
				</div>
				
				<div class="pure-control-group">
					<label for="name">Internal Code <span>*</span></label>				
					<?php echo $form->input('Subject.intcode', array('type'=>'text','id'=>'title','label'=>false,'error'=>false)); ?>		
				</div>
				
				<div class="pure-control-group">
					<label for="name">Subject Name <span>*</span></label>				
					<?php echo $form->input('Subject.name', array('type'=>'text','id'=>'title','label'=>false,'error'=>false)); ?>		
				</div>
				
				<div class="pure-control-group">
					<label for="name">Description <span>*</span></label>				
					<?php 
						$des = !empty($this->data['Subject']['description']) ? $encrypt->_fnDecrypt($this->data['Subject']['description'], $sSecretKey) : "";				
						echo $form->input('Subject.description', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35','value'=>$des,'error'=>false)); ?>		
				</div>
				
			</div>
	
		<script language="javascript"> 
		/* Change categories view modes */
		  $(function() {
				//alert('sdafasf');
				/*Add & remove categories here */
				$('#categoryadd,#categoryRemove').click(function(){
					//alert('dsfds');
					var thisid = $(this).attr('id');
					var source = '';
					var destination = '';
					if(thisid == 'categoryadd') {
						source = 'categories';
						destination = 'subcategories';
					} else if(thisid == 'categoryRemove'){
						source = 'subcategories';
						destination = 'categories';
					}
					var sourceval = $("#"+source).val();
					if(sourceval){
						var presenter = '';
						$.each(sourceval,function(k,v){
							presenter = '<option value="'+v+'">'+$("#"+source+" option[value='"+v+"']").text()+'</option>';
							$("#"+destination).append(presenter);
							$("#"+destination+" option[value='"+v+"']").attr('selected',true);
							$("#"+source+" option[value='"+v+"']").remove();
						});
						
						if ($("#categories_second").length > 0){
							$("#"+destination).triggerHandler('loadsubcat');
						}
					}
				});
				
				});
			
		</script>
		<div style="clear:both;"></div><br />
		<div class="pure-control-group">
		<label for="name">Choose SME
 <span>*</span></label>
		<table style=" width: 39%">
			<tr>
				<td> <?php
						//print_r($this->data['Admin']);
						
							$adminsubjects = @$this->data['Admin'];
							
							// creating array
							$checkselect = array();
							if(count($adminsubjects) > 0){
								foreach($adminsubjects as $sub){
									$checkselect[] = @$sub;
								}								
							}
							//print_r($checkselect);
						?>
						
					<select name="categories[]" id="categories" multiple="multiple" class="ddl_6 valid">
						<?php
							
							
							foreach($smelist as $index => $list){
								if(in_array($index,$checkselect)) continue;
							//print_r($list); die; 
						?>
							<option value="<?php echo $index; ?>"><?php echo $list; ?></option>			
						<?php
						}
						?>
					</select>
				</td>
				<td align="center" valign="middle">
					<button name="categoryadd" id="categoryadd" type="button" class="btn_3">&gt;</button>
					<br />
					<button name="categoryRemove" id="categoryRemove" type="button" class="btn_3">&lt;</button>
				</td>
				<td>
					<select name="data[Admin][]" id="subcategories" multiple="multiple" class="ddl_6">
					
						<?php
							
							$adminsubjects = @$this->data['Admin'];
							
							if(count($adminsubjects) > 0){
							foreach($smelist as $index => $list){
									if(!in_array($index,$checkselect)) continue;
								?>
									<option selected="selected" value="<?php echo $index; ?>"><?php echo $list; ?></option>			
								<?php
								}
						}
						?>
					
					</select>
				</td>
			</tr>
			<tr>
			<td colspan="3">
			</tr>
			</tr>

		</table>
		</div>
		
			
			<div class="pure-control-group">
				<label for="name">Status  <span>*</span></label>
				<?php
					$default = "";
					if(!isset($this->data['Subject']['is_active'])){
						$default = "checked";
					}
				?>

				 <div class="pure-radio"><input   name="data[Subject][is_active]" value="ready" type="radio" <?php echo ($this->data['Subject']['is_active'] == "ready" ? "checked" : "") ?> /><span>Ready</span></div>
				 
				 <div class="pure-radio"><input <?php echo $default; ?> name="data[Subject][is_active]" value="inprogress" type="radio" <?php echo ($this->data['Subject']['is_active'] == "inprogress" ? "checked" : "") ?> /><span>In-Progress</span></div>
				 
			</div>
		
			<div class="buttons">
				
				<?php echo $form->input('Subject.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>
				<?php echo $form->input('Subject.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'data','label'=>false,'div'=>false,'error'=>false)); ?>	      		  
				<?php echo $form->submit($submit_value,array('div'=> false,'class'=>'btn')); ?>
				
				<?php echo $form->button('Cancel',array('class'=>'btn','type'=>'button','div'=> false,'onclick'=>"location.href='/admin/subjects/index'")); ?>
	
			</div>
		  
		  </fieldset>
		  </form>
    </article>

	<style>
		.btn_3 {
			width:auto;
			 background: #d6e4f2; /* Old browsers */
			 background: -moz-linear-gradient(top, #d6e4f2 0%, #76a0c9 50%, #5186ba 51%, #497db2 100%); /* FF3.6+ */
			 background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #d6e4f2), color-stop(50%, #76a0c9), color-stop(51%, #5186ba), color-stop(100%, #497db2)); /* Chrome,Safari4+ */
			 background: -webkit-linear-gradient(top, #d6e4f2 0%, #76a0c9 50%, #5186ba 51%, #497db2 100%); /* Chrome10+,Safari5.1+ */
			 background: -o-linear-gradient(top, #d6e4f2 0%, #76a0c9 50%, #5186ba 51%, #497db2 100%); /* Opera 11.10+ */
			 background: -ms-linear-gradient(top, #d6e4f2 0%, #76a0c9 50%, #5186ba 51%, #497db2 100%); /* IE10+ */
			 background: linear-gradient(to bottom, #d6e4f2 0%, #76a0c9 50%, #5186ba 51%, #497db2 100%); /* W3C */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#d6e4f2', endColorstr='#497db2', GradientType=0 ); /* IE6-9 */
			 -webkit-border-radius: 10px 10px 10px 10px;
			 border-radius: 10px 10px 10px 10px;
			 font-size:18px;
			 font-weight:normal;
			 color:#fff;
			 padding:4px 18px;
			 text-decoration: none;
			 transition: box-shadow 0.1s linear 0s;
			 border:1px solid #5b95cf;
			 cursor:pointer;
			 margin:5px 25px;
			}

			.pure-control-group label table tr td select.valid, select.ddl_6{
			 -moz-box-sizing: border-box;
			 border: 1px solid #CCCCCC;
			 -webkit-border-radius: 15px 15px 15px 15px;
			 border-radius: 15px 15px 15px 15px;
			 box-shadow: 0 1px 3px #DDDDDD inset;
			 display: inline-block;
			 font-size:13px;
			 color:#adadac;
			 padding: 0.5em 0.6em;
			 transition: border 0.3s linear 0s;
			 min-height:140px;
			 width:200px!important;
			 color:#737373!important;
			}
		.ddl_6 {
			border: 1px solid #6A94BF;
			height: 168px;
			padding-left: 2px;
			width: 161px;
		}
		.ddl_1 option {
			padding-left: 5px;
		}
		.ddl_1_disabled {
			border: 1px solid #DFDFDF;
			height: 22px;
			width: 280px;
		}
	</style>

		<script>
		$( ".choice" ).click(function() {
			id = $(this).val();
			if(id == "create"){
				$('#existing').hide();
			}	
			if(id == "existing"){
				$('#create').hide();
			}
			$('#'+id).show();
		});

			$("#SubjectCopycourseId" ).change(function() 
			{
				courseId = $(this).val();
				if(courseId == ""){
					return;
				}
				$.ajax({
					type:"GET",
					url:'/admin/subjects/getsubject/'+courseId,
					data:"",

					beforeSend: function() {


					},
					complete: function(){


					},
					success:function (resp){
							$('#subjectlist').html(resp);
							//$('#extoption').checked(true);
							$('#extoption').prop('checked', true);
					}	
				});
			});
			var existingsubject = "<?php echo @$this->data['Subject']['type']; ?>";
			
			if(existingsubject == 'existing'){
				$("#create" ).hide();
				$("#existing" ).show();
				$("#SubjectCopycourseId" ).trigger('change');
			}
			
		</script>