	<?php 
		$url= array();
		if(isset($keyword) && !empty($keyword))
		$url['keyword']=$keyword;
	?>
	<article class="dredcrum"><a href="<?php echo Configure::read('adminUrl'); ?>/admins/dashboard">Home</a> » <a href="javascript:void(0);"><strong>Manage Setting</strong></a></article>
		<article class="setting-panel"><a href="<?php echo Configure::read('adminUrl'); ?>/settings"><img src="/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding">
		  <h3><span>List of Setting</span></h3>
		</article>		
    <article class="common-container">
	<?php
			if ($session->check('Message.flash')){ ?>
			<article class="success_display_msg"><img width="22" height="22" alt="" src="/img/img_tick_grn.png"><span><?php echo $session->flash();?></span></article>       
		<?php }?>
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="grid">       
        
		<tr class="first-row">
          <th>
			<?php		
				echo $paginator->sort('Name','name',array('url'=>$url));
			?>
				
		</th>
		<th >
		   <?php		
				echo $paginator->sort('Value','value',array('url'=>$url));
			?>
		</th>
		<th align="center">Actions</th>
        </tr>
		<?php
			$i=1;
			$class = "alternate-row";
			if(count($allsetting))
			{
				foreach($allsetting as $data)
				{	
					$class = "alternate-row";
					if($i%2 == 0){
						$class = "active";
					}
			?>
				
					<tr class="<?php echo $class; ?>">
					  <td align="center"><?php echo $data['Setting']['name'];?></td>
					  <td><?php echo $data['Setting']['value'];?></td>					 
					  <td align="center">
					  
						<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit Setting',"title"=>'Edit Setting',"width"=>'16',"height"=>'16')),array('controller'=>'settings','action'=>'add',$data['Setting']['id']),array('escape'=>false)) ;?>
						
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