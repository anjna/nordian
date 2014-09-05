<?php

	foreach($alldata as $data)
	{
		$id = $data['Test']['id'];

		echo $data['Test']['name']."<br />";

		echo $this->Html->link('Edit',
        array('controller'=>'tests', 'action'=>'edit',$id));

		echo "<br />";  

	}
?>
