<?php
/*
Purpose: StaticPage model class
*/

    class Summary extends AppModel{	
        var $name	= 'Summary';
        var $belongsTo = array('Chapter','Course','Subject');
        // StaticPage validation rules
		var $validate = array(
					'course_id' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Course is required.'
                          )
                    ),
					'subject_id' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Subject is required.'
                          )
                    ),
					
                    'chapter_id' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Chapter is required.'
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