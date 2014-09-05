<?php
/*
Purpose: StaticPage model class
*/

    class Chapter extends AppModel{	
        var $name	= 'Chapter';
        var $belongsTo = array('Subject','Course');
		var $hasMany = array('Summary','ChapterQuestion');
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