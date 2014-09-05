<?php
/*
Purpose: Setting model class
*/

    class Setting extends AppModel{	
        var $name	= 'Setting';
        
        // setting validation rules
	var $validate = array(		
		'value' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => 'Value is required.',
					'last' => true
				)
			)
		);
    }
?>