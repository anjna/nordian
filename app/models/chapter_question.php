<?php
/*
Purpose: StaticPage model class
*/

    class ChapterQuestion extends AppModel{	
        var $name	= 'ChapterQuestion';
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
					'question' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Question is required.'
                          )
                    ),
					'option1' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'option1 is required.'
                          )
                    )
					,
					'option2' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'option2 is required.'
                          )
                    )
					,
					'answer' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Answer is required.'
                          )
                    )
					
            );
    }
?>