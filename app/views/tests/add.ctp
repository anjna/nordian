<?php
 
echo $form->create('Test',array('controller'=>'tests','action'=>'add','method'=>'POST'));
						 
echo $form->input('name', array('type'=>'text'));
echo $form->input('id', array('type'=>'hidden'));
echo $form->submit('Submit', array('type'=>'submit'));?>
<?php //echo $this->Html->link('view',
        //array('controller'=>'tests', 'action'=>'index')); ?>
<?php echo $form->end();						
?>

