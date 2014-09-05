<?php
/*
Purpose: StaticPage model class
*/

    class Feedback extends AppModel{	
        var $name	= 'Feedback';
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
				'feedback' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'topic is required.'
                          ),		  
                    ),
					'comments' => array(
                          'NotEmpty' => array(
                                'rule' => array('notEmpty'),
                                'message' => 'topic is required.'
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