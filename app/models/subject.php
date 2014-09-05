<?php
/*
Purpose: StaticPage model class
*/

    class Subject extends AppModel{	
        var $name	= 'Subject';
		var $belongsTo = array('Course');
        var $hasMany = array('Chapter','AdminSubject','Summary','ChapterQuestion');
        // StaticPage validation rules
		var $validate = array(
					'course_id' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Course is required.'
                          )
                    ),
					'extcode' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'External Code is required.'
                          )
                    ),
					
                    'intcode' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Internal Code is required.'
                          )
                    ),
					'name' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Name is required.'
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