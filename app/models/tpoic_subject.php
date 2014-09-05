<?php
/*
Purpose: StaticPage model class
*/

    class CourseSubject extends AppModel{	
        var $name	= 'CourseSubject';
		
        var $belongsTo = array('Subject');
		
	}
	?>