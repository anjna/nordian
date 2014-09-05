<?php
    class Admin extends AppModel {
        
        var $name='Admin';
        var $actsAs = array('Containable');
	var $hasMany = array('AdminSubject');
	
	var $belongTo = 'Task';

         // user validation rules
        var $validate = array(		
                'email' => array(
                            'notEmpty' => array(
                                 'rule' => array('notEmpty'),
                                 'message' => 'Email address is required.',
                                 'last' => true
                            ),
                            'valid' => array(
                                 'rule' => array('email'),
                                 'message' => 'Enter valid email address.'
                            ),
                            'UniqueField'=>array(
                                 'rule' => array('checkUniqueEmail','id'),
                                 'message' => 'Email is already exist.'
                            )
                ),
                'password' => array(
                        'NotEmpty' => array(
                             'rule' => array('notEmpty'),
                             'message' => 'Password is required.',
                             'last'=>true
                        ),
                        'minLength' => array(
                              'rule' => array('minLength', 6),
                              'message' => 'Password must be 6 characters.'
                        ),
                ),
                'custom_password' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'Password is required.',
                        'last'=>true
                    ),
                    'minLength' => array(
                         'rule' => array('minLength', 6),
                         'message' => 'Password must be 6 characters.'
                    ),
                ),
                'repassword' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'Re-password is required.',
                        'last'=>true
                    ),
                    'checkSame'=>array(
                        'rule' => array('ConfirmField','custom_password'),
                        'message' => 'Password mismatch.'
                    )
                ),
                'fullname' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'FullName is required.',
                        //'required' => true,
                        'allowEmpty' => false,
                        'last'=>true
                    ),
                    'custom_fullname' => array(
                        'rule' => '/^[a-zA-Z \'~]+$/',
                        'message' => 'Please enter valid characters(a-z,A-Z) for fullname.'
                    )
                ),
                'lastname' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'Last name is required.',
                        //'required' => true,
                        'allowEmpty' => false,
                        'last'=>true
                    ),
                    'custom_lastname' => array(
                        'rule' => '/^[a-zA-Z \'~]+$/',
                        'message' => 'Please enter valid characters(a-z,A-Z) for lastname.'
                    )
                ),
                'address1' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'Address1 is required.'
                    )
                ),
                'city' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'City is required.'
                    )
                ),
                
                 'phone' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'Phone  is required.',
                        'allowEmpty' => false,
                        'last'=>true
                    )
                ),
                
                
                'oldPassword' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'OldPassword is required.',
                        'last'=>true
                    ),
                    'minLength' => array(
                        'rule' => array('minLength', 6),
                        'message' => 'Password must be 6 characters.'
                    ),
                ),
                'newPassword' => array(
                    'NotEmpty' => array(
                        'rule' => array('notEmpty'),
                        'message' => 'NewPassword is required.',
                        'last'=>true
                    ),
                    'minLength' => array(
                        'rule' => array('minLength', 6),
                        'message' => 'New Password must be 6 characters.'
                    ),
                ),
                'agree' => array(
                    'NotEmpty' => array(
                        'rule' => array('comparison', '!=', '0'),
                        'message' => 'You must accept the terms and conditions.'
                    )
                )
        );
         
        /*_____________________________________________________________________________
        *	@Function:		isExistsEmail
        *	@Description:	checking email if already exists
        *	@param:			$email
        *	@return:        $result 
        *	---------------------------------------------	
        */	
        function checkUniqueEmail($email,$id=null){ 
            $id = isset($this->data[$this->alias][$id]) ? $this->data[$this->alias][$id] : null;	
            $conditions[$this->alias.'.email'] = $email;			
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
        *	@Function:		ConfirmField
        *	@Description:	checking $field1 and $field2
        *	@param:			$field1 and $field2
        *	@return:        $result 
        *	---------------------------------------------	
        */	
        function ConfirmField($field1, $field2){
            foreach($field1 as $name=>$value){
                if($this->data[$this->alias][$name] != $this->data[$this->alias][$field2])
                     return false;
            }
            return true;
        }
        
        /*_____________________________________________________________________________
        *	@Function:		getUserList
        *	@Description:	getting users list
        *	@param:		$region_id
        *	@return:        users list 
        *	---------------------------------------------	
        */
        function getUserList($region_id=null){
            $this->User->recursive =-1;
            $conditions=array();
            $conditions['User.user_type']='c';
            if(!empty($region_id)){
                $conditions['User.region_id']=$region_id;
            }
            
            return $this->find("list",array('conditions'=>$conditions,'order'=>array('User.email'=>'asc'),'fields' => array('User.id','User.email')));
        }
    }
?>
