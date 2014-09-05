	<?php 
		$url= array();
		if(isset($keyword) && !empty($keyword))
		$url['keyword']=$keyword;
		
		if(isset($cid) && !empty($cid))
		$url['cid']=$cid;	
	?>
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage SME's</strong></a></article>
		<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding">
		  <h3><span>List of SME's</span></h3>
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
							<?php echo $form->create('Admin',array('controller'=>'admins','action'=>'index','method'=>'POST','name'=>'frmAdmin','id'=>'form') )?> 
							<?php echo $form->input('Admin.keyword', array('placeholder'=>'Search By Keyword','type'=>'text','id'=>'keyword','label'=>false,'div'=> false)); ?>
							
							<?php echo $form->input('Admin.formtype', array('type'=>'hidden','id'=>'formtype','value'=>'search','label'=>false,'div'=>false,'error'=>false)); ?>

							<?php echo $form->submit('Search',array('div'=> false,'class'=>'btn')); ?>
						
							<br />
							<p>'<?php echo $count; ?> results returned!</p>
							<?php echo $form->end();?>
							
							<div class="rightpanel"> 
							<a href="<?php echo Configure::read('adminUrl'); ?>/admins/add"><img src="/img/img_add-plus.png" width="17" height="17" alt=""> Add SME</a>
							</div>
					</div>
			</td>
        </tr>
        
		<tr class="first-row">
          <th>
			<?php		
				echo $paginator->sort('Name','fullname',array('url'=>$url));
			?>
				
		</th>
          <th align="center">
		   <?php		
				echo $paginator->sort('Email','email',array('url'=>$url));
			?>
		  </th>
         
          <th align="center">		  
		  
                <?php		
				echo $paginator->sort('Modified Date','modified',array('url'=>$url));
				?>
		  </th>
		  <?php if($utype!="sme")
					  {?>
          <th align="center">Actions</th>
		  <?php } ?>
        </tr>
		<?php
			$i=1;
			$class = "alternate-row";
			if(count($allusers))
			{
				foreach($allusers as $data)
				{	
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}
			?>
				
					<tr class="<?php echo $class; ?>">
					  <td align="center"><?php echo $data['Admin']['fullname'];?></td>
					  <td><?php echo $data['Admin']['email'];?></td>
					  
					  <td> <?php echo date('d-m-Y H:i:s a',strtotime($data['Admin']['modified']));?></td>
					  <?php if($utype!="sme")
					  {?>
					  <td align="center">
					  
						<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'admins','action'=>'add',$data['Admin']['id']),array('escape'=>false)) ;?>
								
						<?php echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'admins','action'=>'delete',$data['Admin']['id']),array('escape'=>false),'Are you sure you want to delete this record?');?>
						
						<?php if($data['Admin']['is_active'] == '0' ){ 
							echo $html->link($html->image("icon_deactive.png",array("border"=>0,"alt"=>'Enable',"title"=>'Enable',"width"=>'16',"height"=>'16')),array('controller'=>'admins','action'=>'admin_changestatus',$data['Admin']['id'],'enable'),array('escape'=>false),'Are you sure you want to enable this record?') ;
						} else {
							echo $html->link($html->image("icon_active.png",array("border"=>0,"alt"=>'Disable',"title"=>'Disable',"width"=>'16',"height"=>'16')),array('controller'=>'admins','action'=>'admin_changestatus',$data['Admin']['id'],'disable'),array('escape'=>false),'Are you sure you want to disable this record?') ;
						}?>
					  
					  
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