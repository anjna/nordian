<?php
/*
Purpose: StaticPage model class
*/

    class Task extends AppModel{	
        var $name	= 'tasks';
		//var $hasMany = array('Task');
		 public $belongsTo = array(
		'Admin' => array(
			'className' => 'Admin',
			'foreignKey' => 'user_id',
			'dependent' => false
		)
	);
        //var $hasMany = array('Subject','Chapter','Summary','ChapterQuestion');
        // StaticPage validation rules
		var $validate = array(
                    'code' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Code is required.'
                          ),
						'UniqueField'=>array(
							 'rule' => array('checkUniqueCode','id'),
							 'message' => 'Topic code already exists.'
						)
                    ),
					'project_id' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Topic is required.'
                          ),		  
                    ),
					
					 'project_reference' => array(
                              'NotEmpty' => array(
                                    'rule' => array('notEmpty'),
                                    'message' => 'Description is required.'
                              ),
                     ),
					
					'task_description' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Presentator Name  is required.'
                          ),  
                    ),
					
					'project_type' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'Start time is required.'
                          ),	  
                    ),
					
						 'remarks' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' =>'End Time is required.'
                          ),	  
                    ),
					
						
                   
            );
			
		
		/*_____________________________________________________________________________
        *	@Function:		isExistscode
        *	@Description:	checking code if already exists
        *	@param:			$code
        *	@return:        $result 
        *	---------------------------------------------	
        */	
        function checkUniqueCode($code,$id=null){            
            
            $id = isset($this->data[$this->alias][$id]) ? $this->data[$this->alias][$id] : null;	
            $conditions[$this->alias.'.code'] = $code;			
            if(!empty($id)){
                $conditions[$this->alias.'.id !='] = $id;
            }
            
            $data = $this->find('count',array('conditions' =>$conditions ));
            
            if($data>0)
            {                      
                return false;
            }
            else
            { 
                return true;
            }
        }
		
		/*_____________________________________________________________________________
        *	@Function:		isExistscode
        *	@Description:	checking code if already exists
        *	@param:			$code
        *	@return:        $result 
        *	---------------------------------------------	
        */	
        function checkUniqueName($name,$id=null){            
            
            $id = isset($this->data[$this->alias][$id]) ? $this->data[$this->alias][$id] : null;	
            $conditions[$this->alias.'.name'] = $name;			
            if(!empty($id)){
                $conditions[$this->alias.'.id !='] = $id;
            }
            
            $data = $this->find('count',array('conditions' =>$conditions ));
            
            if($data>0)
            {                      
                return false;
            }
            else
            { 
                return true;
            }
        }
		
    }
?>

