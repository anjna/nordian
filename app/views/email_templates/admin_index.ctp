<?php
    if ($session->check('Message.flash')){ ?>
        <div align="center" class="messageBlock">
            <?php echo $session->flash();?>
        </div>
<?php }?>
<?php echo $javascript->link("fckeditor"); ?>
<div id="box">
    <h3>Email Templates</h3>
    <?php
    if(count($alltemplates))
    {
        
    ?>
    <table width="100%">
        <thead>
            <tr>
                <th width="40px" align="center">S.No.</th>
                <th><?php echo $paginator->sort('Title','title');?></th>
                <th><?php echo $paginator->sort('Subject','subject');?></th>
                <th><?php echo $paginator->sort('Last Modified','modified');?></th>
                <th width="100px" align="center">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $i=1;
                foreach($alltemplates as $template){
            ?>
                    <tr>
                        <td class="a-center"><?php echo $i;?></td>
                        <td><?php echo $template['EmailTemplate']['title']; ?></td>
                        <td><?php echo $template['EmailTemplate']['subject'];?></td>
                        <td><?php echo $common->getFormatDate($template['EmailTemplate']['modified']); ?></td>
                        <td align="center">
                            <?php echo $html->link($html->image("edit.png",array("border"=>0,"alt"=>'Edit record',"title"=>'Edit record',"width"=>'16',"height"=>'16')),array('controller'=>'email_templates','action'=>'index',$template['EmailTemplate']['id']),array('escape'=>false)) ;?>
                            <?php //echo $html->link($html->image("icons/b_drop.png",array("border"=>0,"alt"=>'Delete webpage',"title"=>'Delete webpage',"width"=>'16',"height"=>'16')),array('controller'=>'email_templates','action'=>'delete',$template['EmailTemplate']['id']),array('escape'=>false),'Are you sure you want to delete the record?') ;?>
                        </td>
                    </tr>
            <?php
                    $i++;
                
            }
            ?>
        </tbody>
    </table>
    <div id="pager">
        <?php
            echo $this->Paginator->numbers().'&nbsp;';
            echo $paginator->prev().'&nbsp;';
	    echo $this->Paginator->counter().'&nbsp;';
	    echo $paginator->next().'&nbsp;';
        ?>
        <!--Page <a href="#"><img src="img/icons/arrow_left.gif" width="16" height="16" /></a> -->
        <!--<input size="1" value="1" type="text" name="page" id="page" /> -->
        <!--<a href="#"><img src="img/icons/arrow_right.gif" width="16" height="16" /></a>of 42-->
        <!--pages | View <select name="view">-->
        <!--<option>10</option>-->
        <!--<option>20</option>-->
        <!--<option>50</option>-->
        <!--<option>100</option>-->
        <!--</select> -->
        <!--per page | Total <strong>420</strong> records found-->
        <?php echo $common->display_items_per_page($dropdown_val); ?>
        </div>
    <?php
    }
    ?>
    </div>
    
	<br />
	<div id="box">
	<h3 id="addwebpage">Email Template</h3>
	<?php echo $form->create('EmailTemplate',array('controller'=>'email_templates','action'=>'index','method'=>'POST','name'=>'frmTemplate','id'=>'form') )?>  
	<fieldset id="personal">
	<legend>TEMPLATE INFORMATION</legend>
	<label for="title">Title : </label>
	<?php echo $form->input('EmailTemplate.title', array('type'=>'text','id'=>'title','label'=>false)); ?>
	
	<label for="subject">Subject : </label>
	<?php echo $form->input('EmailTemplate.subject', array('type'=>'text','id'=>'subject','label'=>false)); ?>
	
	<label for="description">Description : </label>
	<?php echo $form->input('EmailTemplate.description', array('type'=>'textarea','label'=>false,'rows'=>'20','cols'=>'35')); ?>	      		  
	
	</fieldset>
	<div><label style="margin-right:10px;"></label>
	<?php echo $form->input('EmailTemplate.id', array('type'=>'hidden','id'=>'id','label'=>false,'div'=>false)); ?>	      		  
	<?php echo $form->submit($submit_value,array('div'=> false)); ?>
	</div>
	<?php
		echo $form->end();
		echo $fck->load('EmailTemplateDescription');        
		echo $validation->rules(array('EmailTemplate'),array('formId'=>'form'));
	?>

	</div>
   