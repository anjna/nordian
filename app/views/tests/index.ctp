<?php
echo $this->Html->script('jquery');
echo $form->create('Test',array('controller'=>'tests','action'=>'multipleactionstatus','method'=>'POST'));
?>
<table border="2">
<tr>
<td><input type="checkbox"  id="selectall" name="selectall" /></td>
<th>id</th>
<th>Name</th>
<th>Status</th>
<th>Action</th>
</tr>
<?php
		foreach($alldata as $data)
		{
?>
<tr>
 <td>

 
<?php
	echo $form->input('allusers][', array('hiddenField' => false,'type'=>'checkbox','class'=>'case','value'=>$data['Test']['id'],'label'=>false,'div'=>false));
?>
</td>

 <td><?php  echo $id = $data['Test']['id'];?></td>
		
	<td><?php echo $data['Test']['name'];?></td>
						<td>
						<?php if($data['Test']['status'] == '0' ){ 
							echo $html->link($html->image("icon_deactive.png",array("border"=>0,"alt"=>'Enable',"title"=>'Enable',"width"=>'16',"height"=>'16')),array('controller'=>'tests','action'=>'changestatus',$data['Test']['id'],'enable'),array('escape'=>false),'Are you sure you want to enable this record?') ;
						} else {
							echo $html->link($html->image("icon_active.png",array("border"=>0,"alt"=>'Disable',"title"=>'Disable',"width"=>'16',"height"=>'16')),array('controller'=>'tests','action'=>'changestatus',$data['Test']['id'],'disable'),array('escape'=>false),'Are you sure you want to disable this record?') ;
						}?>
						
						</td>

	<td>
	<?php echo $html->link($html->image("icon_edit.png",array("border"=>0,"alt"=>'Edit',"title"=>'Edit',"width"=>'16',"height"=>'16')),array('controller'=>'tests','action'=>'add',$data['Test']['id']),array('escape'=>false)) ;?>
								
	<?php echo $html->link($html->image("icon_dlt.png",array("border"=>0,"alt"=>'Delete',"title"=>'Delete',"width"=>'16',"height"=>'16')),array('controller'=>'tests','action'=>'delete',$data['Test']['id']),array('escape'=>false),'Are you sure you want to delete this record?');?>

	
		</td>
 </tr> 
<?php
      }
?>
</table>
<?php
	echo $form->submit('Enable',array('name'=>'submit'));
	echo $form->submit('Disable',array('name'=>'submit'));
	
	echo $form->end();
?>
<script language='JavaScript'>
	$(document).ready(function() {
	    $('#selectall').click(function(event) {  //on click
		if(this.checked) { // check select status
		    $('.case').each(function() { //loop through each checkbox
		        this.checked = true;  //select all checkboxes with class "checkbox1"              
		    });
		}else{
		    $('.case').each(function() { //loop through each checkbox
		        this.checked = false; //deselect all checkboxes with class "checkbox1"                      
		    });        
		}
	    });
	});
	</script>
	
