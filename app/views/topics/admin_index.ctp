	<?php 
		$url= array();
		if(isset($keyword) && !empty($keyword))
		$url['keyword']=$keyword;
		
		if(isset($cid) && !empty($cid))
		$url['cid']=$cid;	
	?>
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage Session</strong></a></article>
		<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding">
		  <h3><span>List of Sessions</span></h3>
		</article>
    <article class="common-container">
		<?php
			if ($session->check('Message.flash')){ ?>
			<article class="success_display_msg"><img width="22" height="22" alt="" src="/img/img_tick_grn.png"><span><?php echo $session->flash();?></span></article>       
		<?php }?>	
		<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">
        <tr class="header">

          <td colspan="11" align="left">
				  <div class="formouter">
							<?php echo $form->create('Topic',array('controller'=>'Topics','action'=>'index','method'=>'POST','name'=>'frmPages','id'=>'form') )?>
							
							<?php echo $form->input('Topic.keyword', array('placeholder'=>'Search By Keyword','type'=>'text','id'=>'keyword','label'=>false,'div'=> false)); ?>
							<?php echo $form->input('Topic.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>
							
							<?php echo $form->submit('Go',array('div'=> false,'class'=>'btn')); ?><br />
							<p>'<?php echo $count; ?>' results returned!</p>
							<?php echo $form->end();?>
							
					<?php if($utype!="sme")
					{?>
							<div class="rightpanel"> 
							<a href="<?php echo Configure::read('adminUrl'); ?>/topics/add"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Add Session</a>
							</div>
<?php }?>
							</div>
			</td>
        </tr>
        
		<tr class="first-row">
          <th>
			<?php		
				echo $paginator->sort('Name','topic',array('url'=>$url));
			?>	
		</th>
	
          <th align="center">
		   <?php		
				echo $paginator->sort('Description','description',array('url'=>$url));
			?>
		  </th>
		  
		  <th align="center">
		   <?php		
				echo $paginator->sort('Presentator','presentator',array('url'=>$url));
			?>
		  </th>
		  
		  <th align="center">
		   <?php		
				echo $paginator->sort('Start date','start_time',array('url'=>$url));
			?>
		  </th>
		  
		  <th align="center">
		   <?php		
				echo $paginator->sort('End Date','end_time',array('url'=>$url));
			?>
		  </th>
		 <?php if($utype!="admin")
					{?>
          <th align="center">Give feedback</th>
         <?php }
		 ?>
               <th align="center">Total Feedback users</th>
			      <th align="center">Sum</th>
				     <th align="center">Average</th>
					    <th align="center">Feedback View</th>
		  
                
				<?php if($utype!="sme")
					{?>
          <th align="center">Actions</th>
		  <?php }
		  ?>
        </tr>
		<?php
			$i=1;
			$class = "alternate-row";
			
			//echo "<pre>";
			if(count($allCourses))
			{
				foreach($allCourses as $data)
				{	
				
					//pr($data);
					
					
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}
			?>
					  <td align="center"><?php echo $data['Topic']['topic'];?></td>
					  <?php
						if(empty($cid)) { ?>
					  <td><?php echo $data['Topic']['description']; ;?></td>
					  <?php
					  } ?>
					  <td><?php echo $data['Topic']['presentator']; ;?></td>
					  <td> <?php echo date('d-m-Y H:i:s',strtotime($data['Topic']['start_time']));?></td>
					   <td> <?php echo date('d-m-Y H:i:s',strtotime($data['Topic']['end_time']));?></td>
					   <?php
					   	 if($utype!="admin")
						{?>
					   <td><?php
				
					   $feedbackUsers = array();
					   foreach($data['Feedback'] as $course)
								{
							$feedbackUsers[]	=  $course['user_id'];
								}
					   
					     date_default_timezone_set('Asia/Calcutta');
						$curdate=date('d-m-Y H:i:s');					
						
					   //if(!empty($feedbackUsers)){
					   
							  if(in_array($iduser,$feedbackUsers))
							  {
									echo "Feedback Sent..";
							  }
							  elseif(strtotime($curdate) > strtotime($data['Topic']['end_time']) )
							  {
								echo $html->link('feedback',array('controller'=>'topics','action'=>'feedbackuser',$data['Topic']['id']),array('escape'=>false)) ;
							  }
						   else
							  {
								echo "wait";
							  }
						//}
					   
							?>
					   </td>	   
					   <?php }
					   ?>
					   <td><?php echo $count; ?></td>
					   <td>
					 <?php 
					 $totalsum=0;
					
					  foreach($data['Feedback'] as $course)
							{			
								$totalsum = $totalsum + $course['feedback'];
							}	
						echo $totalsum;
						
						?>
					   </td>
					   <td>
					   <?php 
				$totalsum=0;
				$count=0;
	  foreach($data['Feedback'] as $course)
			{			
				$totalsum = $totalsum + $course['feedback'];
				//$totalsum=$totalsum / $course['feedback'];
				$count++;
			}
			if($totalsum>0){
		echo ($totalsum/$count);
		}else{
		echo '0';
		}

            ?>	   
					   </td>
					   <td><?php echo $html->link('view',array('controller'=>'topics','action'=>'feedbackview',$data['Topic']['id']),array('escape'=>false)) ;?></td>
					   
					   <?php if($utype!="sme")
					{?>
					  
					  <td align="center">
					  
						<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'topics','action'=>'add',$data['Topic']['id']),array('escape'=>false)) ;?>
								
						<?php echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'topics','action'=>'delete',$data['Topic']['id']),array('escape'=>false),'Are you sure you want to delete this record?');?>
					  
					  </td>
					  <?php }
					  ?>
					</tr>
			<?php
					$i++;				
				}
			}
			else{
        ?> 
				<tr class="alternate-row"><td colspan="10">No Records. </td></tr>
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
