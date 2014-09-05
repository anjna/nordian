<?php
    /**
	* EmailTemplates Controller class
	* PHP versions 5.1.4
	* @filesource
	* @author
	* @link       http://www.smartdatainc.com/
	* @copyright  Copyright 2009 
	* @version 0.0.1 
	*   - Initial release
	*/
	class EmailTemplatesController extends AppController
	{
	
		// admin model
		var $name = 'EmailTemplates';
		
		// helpers
		var $helpers = array('Form','Html','Javascript','Fck','Common','Ajax','Validation');
		
		// admin default layout	
		//var $layout = "home_page";
		
		// component
		var $components = array('Session', 'RequestHandler','Email');
	
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
			parent::beforeFilter();
			$this->Auth->allow('admin_login');
		}
		
		/*
		*_____________________________________________________________________________
		*@Function:	beforeRender
		*@Description:	before Render
		*@param:	None
		*@return:	nonelogin
		*______________________________________________________________________________
		*/	
		
		function beforeRender()
		{			
			parent::beforeRender();			
		}
		
			
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for email templates listing and for update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null)
		{		
		    $user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Template';
		    $this->layout = 'admin_inner';
		    
		    if(!empty($this->data)) {
				if($this->EmailTemplate->validates())
				{
					if($this->EmailTemplate->save($this->data['EmailTemplate'])) {
						if(empty($this->data['EmailTemplate']['id'])){
						    $this->Session->setFlash('<div class="successMessage">Email Template has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage">Email Template has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'email_templates','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem updating the email template please review the errors below and try again.',"error");
					}
				}
		    }
		    else {
				if(!empty($id)){
					$this->data=$this->EmailTemplate->find("first",array('conditions'=>array('EmailTemplate.id'=>$id)));
					$submit_value='Update Template';
				}
			}
			$this->set('submit_value',$submit_value);
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('EmailTemplate.title'=>'asc'));
		    $alltemplates = $this->paginate('EmailTemplate');
		    $this->set('alltemplates', $alltemplates);
		}
	}
?>