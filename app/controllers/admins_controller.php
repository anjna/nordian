<?php
    /**
	* Admins Controller class
	* PHP versions 5.1.4
	* @filesource
	* @author
	* @link http://www.smartdatainc.com/
	* @copyright  Copyright 2012
	* @version 0.0.1 
	*   - Initial release
	*/
    
	class AdminsController extends AppController
	{
	
		// admin model
		var $name = 'Admins';
                
		// helpers
		var $helpers = array('Form','Html','Javascript','Ajax','Validation','Common','Session');
		
		// admin default layout	
		var $layout = "admin_inner";
		
		// component
		var $components = array('Session', 'RequestHandler','Email','Common','File','Thumb','Upload');
	
		/*
		*_____________________________________________________________________________
		*@Function:	beforeFilter
		*@Description:	before controller
		*@param:	None
		*@return:	none
		*______________________________________________________________________________
		*/	
		function beforeFilter()
		{
			if ( $this->params['admin'] == "admin" ) {
				
				
				//pr($this->Session->read('Auth.Admin'));exit;
				
				//$this->loadModel('ActionsAdmin');
				$controller = $this->params['controller'];
				$action = $this->params['action'];
				
				
				
				//$this->ActionsAdmin->find('first', array('conditions' => array('ActionsAdmin.controller' => $controller, 'ActionsAdmin.action' => $action) ) );
				
			}
			
			
			parent::beforeFilter();
            $this->Auth->allow('admin_login','admin_forgotpassword','admin_approvalonbadword');
		}
        
		/*_____________________________________________________________________________
		*	@Function:	login
		*	@Description:	function member login
		*	@param:		None
		*	@return:    None
		*/
		
		function admin_login()
		{
            $this->layout = "admin_login";
			/*
			$cookie = $this->Cookie->read('Auth.Keepme');
			//print_r($cookie);
			if(!empty($cookie))
			{
			
				$cdata = $this->Cookie->read('Auth.Keepme');
				$this->data['Admin']['email'] = 	$cdata['email'];
				$this->data['Admin']['password'] = $cdata['password'];
				$this->data['Admin']['keepmeloggedin'] = $cdata['keepmeloggedin'];
				$adminDetails = $this->Auth->login($this->data);
			}
			*/
			
			$adminDetails = $this->Auth->user();
			//print_r($this->data); die;
			if(!empty($adminDetails)){                
			   $this->redirect(array('controller'=>'admins','action'=>'dashboard','admin'=>true));
			}
		}
        
        /*__________________________________________________________________________
		*	@Function:	logout
		*	@Description:	take user to logout page
		*	@param:		
		*	@return: none
		*/
		
		function admin_logout()
		{			
			$this->Cookie->delete('Auth.Keepme');
			$this->Auth->logout();
			$this->redirect(array('controller'=>'admins','action'=>'login', 'admin'=>true));        
		}
        
        
        /*_____________________________________________________________________________
		*	@Function:	change password
		*	@Description:	when user change password
		*	@param:	none
		*	@return: none
		*/
        
		function admin_changepassword()
		{
			$this->layout = 'admin_inner';
			if(!empty($this->data)) {
				
				$this->Admin->set($this->data);
				$errors = array();
				$userid =  $this->Auth->user('id');
				$userDetails = $this->Admin->findById($userid,array('password','id'));
                
				$hash_password = Security::hash($this->data['Admin']['oldPassword'],null,true);
				$new_password = Security::hash($this->data['Admin']['newPassword'],null,true);
                
				//___If user password is not exist in user table
				if($userDetails['Admin']['password'] != $hash_password){
					$this->Admin->validationErrors['oldPassword'] =  'OldPassword is invalid,Please try again.';
				}
	
				//___If new password and confirm password is not match
				if($this->data['Admin']['newPassword'] != $this->data['Admin']['confirmPassword']){
					$this->Admin->validationErrors['confirmPassword'] = 'New password and confirm password do not match.';
				}
				
				//___If new password and confirm password is not match
				if(strlen($this->data['Admin']['newPassword'])<5){
					$this->Admin->validationErrors['confirmPassword'] = 'Password length should be more than 5 digits.';
				}
				
				//___If confirm password is empty
				if(empty($this->data['Admin']['confirmPassword'])){
					$this->Admin->validationErrors['confirmPassword'] = 'Confirm password is required.';
				}
				
				//___Server side validation is exist
				if($this->Admin->validates()){
					$this->Admin->id = $userid;
					
					$this->Admin->saveField('password',$new_password);
					$this->Session->setFlash('Password has been changed successfully','default',array('class'=>'successMessage'));
					$this->redirect(array('controller'=>'admins','action'=>'changepassword'));
				}else{
					$errors = $this->Admin->validationErrors;					 
					$this->set("errors",$errors);
				}
			}
		}        
        
        
        /*__________________________________________________________________________
		*	@Function:	dashboard
		*	@Description:	admin dashboard
		*	@param:		
		*	@return: none
		*/
        
        function admin_dashboard(){
			
   
        }


        /*__________________________________________________________________________
		*	@Function:	Delete
		*	@Description:	user delete records
		*	@param: $id		
		*	@return: none
		*/        
        function admin_delete($id=null)
		{		
		    
			$check=$this->Admin->find("first",array('conditions'=>array('Admin.id'=>$id,'Admin.user_type'=>'a','Admin.is_deleted'=>'0'),'contain' => false));
			
			if(!empty($check)){
				$this->Session->setFlash('<div class="successMessage">You have no permission to delete this user.</div>');
				$this->redirect(array('controller'=>'admins','action'=>'/index'));
			}
				
		    $this->Admin->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Admin has been deleted successfully.</div>');            		
		    $this->redirect(array('controller'=>'admins','action'=>'/index'));
	 
		}// end of function admin_delete
		
		
		/*_____________________________________________________________________________
		*	@Function:	admin_changestatus
		*	@Description:	activate/deactivate records from user table
		*	@param:		id, status
		*	@return:
		  ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
		*/
	
		function admin_changestatus($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'admins','action'=>'/index'));
			}
	
			$this->Admin->id=$id;
			$is_active='';
			
			if($status=='enable'){
				$is_active=1;
				$message='activated';
			}elseif($status=='disable'){
				$is_active=0;
				$message='deactivated';
			}else{
				$this->redirect(array('controller'=>'admins','action'=>'/index'));
			}
	
            $this->Admin->saveField('is_active',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Admin has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'admins','action'=>'/index'));
	 
		}// end of function admin_changestatus
		
		
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for users listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null){		
		    $user_id = $this->Auth->user('id');		
			date_default_timezone_set('Asia/Calcutta');
		    // if admin is login
		    $submit_value='Add SME';
		    $this->layout = 'admin_inner';
       
		    $validImg='';
		    if(!empty($this->data) && $this->data['Admin']['formtype']=='data')
			{			
			 
				$this->Admin->set($this->data);
				if($this->Admin->validates() && $validImg=='')
				{
                   
					//////////// Image Upload Code ///////////////////////
					
					
					
					if(empty($this->data['Admin']['id'])){
					    $this->data['Admin']['type']='sme';
					    $this->data['Admin']['is_active']='1';
					    $this->data['Admin']['is_verified']='1';
					    $this->data['Admin']['password']=Security::hash($this->data['Admin']['custom_password'],null,true);
					}
					
					if($this->Admin->save($this->data['Admin'])) {				
					
						if(empty($this->data['Admin']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> user has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> user has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'admins','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the user please review the errors below and try again.',"error");
					}
				}
				else{
					$this->Admin->validationErrors['pic'] = $validImg;
				}
		    }
		    else{
				if(!empty($id)){
					$this->data=$this->Admin->find("first",array('conditions'=>array('Admin.id'=>$id)));
					$submit_value='Update SME';
				}
				else{
					$this->data['Admin']['password']='';
					$this->data['Admin']['repassword']='';
				}
		    }
		    
		    $conditions=array();		    
		    if(isset($this->data['Admin']['keyword']) && !empty($this->data['Admin']['keyword']) ) {
				$keyword = $this->data['Admin']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
		    
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['Admin']['keyword']= trim($keyword);
			    $conditions['OR']['Admin.fullname LIKE']="%".$keyword."%";
			   
			    $conditions['OR']['Admin.email LIKE']="%".$keyword."%";			    
			    $this->set('keyword', $keyword);
		    }
		    
		    $conditions['Admin.type'] = "sme";		
			
			//pr($conditions);
			$count = 0;
			if(!empty($conditions) && isset($keyword)){
				$count = $this->Admin->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1,'fields'=>array('Admin.id,Admin.fullname,Admin.email,Admin.modified,Admin.is_active,Admin.is_verified,Admin.created,Admin.type'), 'order'=>array('Admin.id'=>'desc'), 'conditions'=>$conditions,'contain'=>array('AdminSubject'));
		    $allusers = $this->paginate('Admin');
		    //pr($allusers);
		    $this->set('allusers', $allusers);
		    
		    
		    $this->set('submit_value',$submit_value);
		}
		
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for users listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_add($id=null){		
		    $user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add SME';
			$label='Add SME';
		    $this->layout = 'admin_inner';
            date_default_timezone_set('Asia/Calcutta');
			
		    $validImg='';
		    if(!empty($this->data) && $this->data['Admin']['formtype']=='data')
			{
			
				//////////// End of Image Validate Code ///////////////////////
			 
				$this->Admin->set($this->data);
			
				if($this->Admin->validates() && $validImg=='')
				{
                   
					
					if(empty($this->data['Admin']['id'])){
					    $this->data['Admin']['type']='sme';
					   //$this->data['Admin']['is_active']='1';
					    $this->data['Admin']['is_verified']='1';
					    $this->data['Admin']['password']=Security::hash($this->data['Admin']['custom_password'],null,true);
					}
					
					if($this->Admin->save($this->data['Admin'])) {					
					
						if(empty($this->data['Admin']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> SME has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> SME has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'admins','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the admin user please review the errors below and try again.',"error");
					}
				}
				else{
						$errors = $this->Admin->validationErrors;
						$this->set('errors',$errors);
				}
		    }
		    else{
				if(!empty($id)){
					$this->data=$this->Admin->find("first",array('conditions'=>array('Admin.id'=>$id),'contain'=>array('AdminSubject')));
					$submit_value='Update SME';
					$label='Update SME';
				}
				else{
					$this->data['Admin']['password']='';
					$this->data['Admin']['repassword']='';
				}
		    }
		    
		    $this->set('submit_value',$submit_value);
			 $this->set('label',$label);
		}
		/*_____________________________________________________________________________
		*	@Function       :   admin_userdetail
		*	@Description    :   for users detail
		*	@param          :   id
		*	@return         :   None
		*/
		function admin_feedbackuser()
		{
	
		}
		function admin_userdetail($id=null){
		    $this->layout = 'admin_inner';
		    if(!empty($id)){
				$this->set('user',$this->Admin->find("first",array('conditions'=>array('Admin.id'=>$id))));
		    }
		    else{
				$this->redirect(array('controller'=>'admins','action'=>'/index'));
		    }
		    
		}
		
		/*_____________________________________________________________________________
        *	@Function:	multipleAction
        *	@Description: 	change status of page (activate/deactivate/Delete) records of multiple records 
        *	@param:		none
        *	@return: 	none
        */
        function admin_multipleAction(){            
            //check that admin is login
            if($this->data['Admin']['submit']=='active'){                
                foreach($this->data['select'] as $id){                    
                    if(!empty($id)){
                    $this->Admin->id=$id;
                    $this->Admin->saveField('is_active','1');                    
                    }                    
                }
                $this->Session->setFlash('<div class="successMessage">Admin has been activated successfully.</div>');
            } elseif($this->data['Admin']['submit']=='inactive'){
                foreach($this->data['select'] as $id){
                    if(!empty($id)){        
                        $this->Admin->id=$id;                        
                        $this->Admin->saveField('is_active','0');                        
                    }
                }
                $this->Session->setFlash('<div class="successMessage">Admin has been deactivated successfully.</div>');	
            } elseif($this->data['Admin']['submit']=='del'){
                foreach($this->data['select'] as $id){
                    if(!empty($id)){
                        $this->Admin->delete($id);                        
                    }
                }
                $this->Session->setFlash('<div class="successMessage">Admin has been deleted successfully.</div>');	
            }		
            $this->redirect(array('controller'=>'admins','action'=>'index'));
        }
        
        /*_____________________________________________________________________________
		*	@Function       :   forgotpassword
		*	@Description    :   forgot password
		*	@param          :   None
		*	@return         :   None
		*/
		
		function admin_forgotpassword()
		{
			$this->layout = 'admin_login';
		//	echo $data;die;
		 
			if ( isset($this->data) && !empty($this->data) ){
			  
				$checkEmail = $this->Admin->find('first',array('conditions'=>array('Admin.email'=>$this->data['Admin']['email']),'fields'=>array('Admin.id','Admin.email')));
			// pr($checkEmail);die;
				if(empty($checkEmail)){					 
					 $this->Session->setFlash('Email does not exist in our website.','default',array('class'=>'failureMessage'));
				}
				
			   //___Check user if user is not exist display message invalid user
			   if($checkEmail)
			   {
					$newPassword =  $this->get_random_string(6);
					$email = $checkEmail['Admin']['email'];
					
					//___Import emailTemplate Model and get template
					App::import('Model','EmailTemplate');
					$this->EmailTemplate = new EmailTemplate;
	
					$template = $this->EmailTemplate->find('first',array('conditions'=>array("EmailTemplate.slug"=>'forgot-password'),'fields' =>array( 'EmailTemplate.description','EmailTemplate.title')));
					$data=$template['EmailTemplate']['description'];
					$data=str_replace('{EMAIL}',$checkEmail['Admin']['email'],$data);
					$data=str_replace('{PASSWORD}',$newPassword,$data);
					
					$this->Email->to = $email;
					$this->Email->from = $this->get_setting('SiteEmail');
					$this->Email->sendAs= 'html';
					$this->Email->subject = 'Forgot password';				
					$this->Email->template = 'common_template';
					
					$this->set('data',$data);
					if($this->Email->send()){
						//___Save new password in data base
						$this->Admin->id = $checkEmail['Admin']['id'];					
						$hash_password = Security::hash($newPassword,null,true);
						$this->Admin->saveField('password',$hash_password);										
						$this->Session->setFlash('An email has been sent to you which contains your new password. Please check your inbox.','default',array('class'=>'successMessage'));
						$this->redirect(array('controller'=>'admins','action'=>'login'));
					}
					else{
						$this->Session->setFlash('An error occurred while sending the email to the email address provided by you. Please contact Customer Support.','default',array('class'=>'failureMessage'));
						
					}
				}
			}
		}
		
		/*_____________________________________________________________________________
		*	@Function       :   approvalonbadword
		*	@Description    :   approvalonbadword
		*	@param          :   $modelName,$updatefld,$pid,$badwords,$email
		*	@return         :   None
		*/
		
		function admin_approvalonbadword($modelName,$updatefld,$pid,$badwords,$email){
			
			App::import('Model',$modelName);
			$this->$modelName = new $modelName;
			$this->$modelName->id=$pid;                    
			$this->$modelName->saveField($updatefld,1);
			
			
			App::import('Model','EmailTemplate');
            $this->EmailTemplate = new EmailTemplate;
			
			$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate.slug"=>'approval-bad-word'),'fields' =>array( 'EmailTemplate.description','EmailTemplate.title','EmailTemplate.subject')));
			
			$data=$template['EmailTemplate']['description'];                        
			$data=str_replace('{POST}',base64_decode($badwords),$data);
			
			$this->Email->to = 'gyanp.sdei@gmail.com';
			$this->Email->from = 'gyanp.sdei@gmail.com';
			$this->Email->sendAs= 'html';
			$this->Email->subject = $template['EmailTemplate']['subject'];				
			//$this->Email->textMessage = $data;              
			$this->Email->send($data);
			
			$this->Session->setFlash('Your have successfully approved the content, Now this is publish on front-end.','default',array('class'=>'successMessage'));
			$this->redirect(array('controller'=>'admins','action'=>'login'));
			
		}
		
		
		/*_____________________________________________________________________________
		*	@Function       :   declinedbadword
		*	@Description    :   declinedbadword
		*	@param          :   $modelName,$updatefld,$pid,$badwords,$email
		*	@return         :   None
		*/
			
		function admin_declinedbadword($modelName,$updatefld,$pid,$badwords,$email) {
			
			App::import('Model',$modelName);
			$this->$modelName = new $modelName;
			$this->$modelName->id=$pid;
			$this->$modelName->saveField($updatefld,0);
			
			App::import('Model','EmailTemplate');
            $this->EmailTemplate = new EmailTemplate;
			
			$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate.slug"=>'cancel-bad-word'),'fields' =>array( 'EmailTemplate.description','EmailTemplate.title','EmailTemplate.subject')));
			
			$data=$template['EmailTemplate']['description'];
			$data=str_replace('{POST}',base64_decode($badwords),$data);
			
			$this->Email->to = base64_decode($email);
			$this->Email->from = 'gyanp.sdei@gmail.com';
			$this->Email->sendAs= 'html';
			$this->Email->subject = $template['EmailTemplate']['subject'];
			//$this->Email->textMessage = $data;
			$this->Email->send($data);
			
			$this->Session->setFlash('Your have successfully declined the content, Now this is not publish on front-end.','default',array('class'=>'successMessage'));
			$this->redirect(array('controller'=>'admins','action'=>'login'));
			
		}
		
		
		/*_____________________________________________________________________________
		*	@Function       :   admin_setpermission
		*	@Description    :   for users detail
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_setpermission($id=null){

			$this->layout = 'admin_inner';
			
			$this->loadModel('ActionsAdmin');
			
		    //pr($_REQUEST);exit;
			if ( isset($this->data) && !empty($this->data) ) {
			//	pr($this->data);exit;
				$adminId = $this->data['AdminAction']['admin_id'];
				
				$this->set('adminId', $adminId);
				
				$this->loadModel('ActionsAdmin');
				
				$this->ActionsAdmin->deleteAll( array( 'ActionsAdmin.admin_id = ' . $adminId ) );
				
				//pr($this->data["ActionsAdmin"]);exit;
				foreach ($this->data["ActionsAdmin"] as $controllerName => $actionArray) {
					
					foreach ($actionArray as $actionName => $permissions) {
						
						if ( !isset($permissions['add']) ) {
							$permissions['add'] = 0;
						}
						if ( !isset($permissions['edit']) ) {
							$permissions['edit'] = 0;
						}
						if ( !isset($permissions['delete']) ) {
							$permissions['delete'] = 0;
						}
						if ( !isset($permissions['activate']) ) {
							$permissions['activate'] = 0;
						}
						
						$permissionData["ActionsAdmin"]  = array(
							"id" => null,
							"admin_id" => $adminId,
							"controller" => strtolower($controllerName),
							"action" => $actionName,
							"add" => $permissions['add'],
							"edit" => $permissions['edit'],
							"delete" => $permissions['delete'],
							"activate" => $permissions['activate'],
						);
						//pr($permissionData);exit;
						$this->ActionsAdmin->save($permissionData);
						
					}
					
				}
				
				$this->Session->setFlash('Permissions has been updated successfully!','default',array('class'=>'successMessage'));
				
				$this->redirect( '/admin/admins/setpermission/' . $adminId );
				
			}
			else {
				$this->set('adminId', $id);
			}
			
			$controllers = $this->Common->getControllersList();
			
			$adminActionsList = $this->ActionsAdmin->find('all', array('conditions' => array('ActionsAdmin.admin_id' => $id) ) );
			
			$actionsListing = array();
			
			if ( count($adminActionsList) > 0 ) {
				$submit_value = "Update";
				
				foreach ($adminActionsList as $actionArr) {
					if ($actionArr['ActionsAdmin']['add'] == 1) {
						$actionsListing["add"][] = array(
							"controller" => $actionArr['ActionsAdmin']['controller'],
							"action" => $actionArr['ActionsAdmin']['action']
						);
					}
					
					if ($actionArr['ActionsAdmin']['edit'] == 1) {
						$actionsListing["edit"][] = array(
							"controller" => $actionArr['ActionsAdmin']['controller'],
							"action" => $actionArr['ActionsAdmin']['action']
						);
					}
					
					if ($actionArr['ActionsAdmin']['delete'] == 1) {
						$actionsListing["delete"][] = array(
							"controller" => $actionArr['ActionsAdmin']['controller'],
							"action" => $actionArr['ActionsAdmin']['action']
						);
					}
					
					if ($actionArr['ActionsAdmin']['activate'] == 1) {
						$actionsListing["activate"][] = array(
							"controller" => $actionArr['ActionsAdmin']['controller'],
							"action" => $actionArr['ActionsAdmin']['action']
						);
					}
				}
			}
			else {
				$submit_value = "Save";
			}
			//pr($actionsListing);exit;
			$this->set('actionsListing', $actionsListing);
			
			$this->set('countAdminActions', $countAdminActions);
			
			$this->set('controllers', $controllers);
			
			
			
			$this->set('user',$this->Admin->find("first",array('conditions'=>array('Admin.id'=>$id))));
			
		}
		
		function admin_getpassword(){
			$this->layout = 'ajax';
		
			echo $pass = $this->get_random_string(6);
			die;
		}
		
			
    }