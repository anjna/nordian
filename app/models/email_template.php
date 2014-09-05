<?php
/*
Purpose: EmailTemplate model class
*/

    class EmailTemplate extends AppModel{	
        var $name	= 'EmailTemplate';
        
        // EmailTemplate validation rules
	var $validate = array(
                    'title' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Title is required.'
                          )
                    ),
                    'subject' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Subject is required.'
                          )
                    ),
                    'description' => array(
                              'NotEmpty' => array(
                                    'rule' => array('notEmpty'),
                                    'message' => 'Description is required.'
                              )
                        )
            );
    }
?>