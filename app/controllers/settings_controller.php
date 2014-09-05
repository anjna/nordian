<?php
    /**
	* Settings Controller class
	* PHP versions 5.1.4
	* @filesource
	* @author
	* @link       http://www.smartdatainc.com/
	* @copyright  Copyright 2009 
	* @version 0.0.1 
	*   - Initial release
	*/
	class SettingsController extends AppController
	{
	
		// admin model
		var $name = 'Settings';
		
		// helpers
		var $helpers = array('Form','Html','Javascript','Ajax','Validation');
		
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
			$this->Auth->allow('admin_login','encryptdata','summaryencryptdata');
		}
		
		/*
		*_____________________________________________________________________________
		*@Function:	beforeRender
		*@Description:	before Render
		*@param:	None
		*@return:	nonelogin
		*______________________________________________________________________________
		*/	
		
		function beforeRender(){			
			parent::beforeRender();			
		}
		
			
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for settings listing and for update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null){		
		    $user_id = $this->Auth->user('id');		
		    // if admin is login
		    
		    $this->layout = 'admin_inner';
		    
		    if(!empty($this->data)) {
				if($this->Setting->validates())
				{
					if($this->Setting->save($this->data['Setting'])) {
						$this->Session->setFlash('<div class="successMessage"> Setting value has been updated successfully.</div>');
						$this->redirect(array('controller'=>'settings','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem updating the settings please review the errors below and try again.',"error");
					}
				}
		    }
			else
			{
				if(!empty($id)){
					$this->data=$this->Setting->find("first",array('conditions'=>array('Setting.id'=>$id)));
				}
			}
		    
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Setting.name'=>'asc'));
		    $allsettings = $this->paginate('Setting');
		    $this->set('allsetting', $allsettings);  
  
		}
		
		// add function
		function admin_add($id=null){
		
			$this->layout = 'admin_inner';
		    
		    if(!empty($this->data)) {
				if($this->Setting->validates())
				{
					if($this->Setting->save($this->data['Setting'])) {
						$this->Session->setFlash('<div class="successMessage"> Setting value has been updated successfully.</div>');
						$this->redirect(array('controller'=>'settings','action'=>'/index'));
					}
				}
		    }
			else
			{
				if(!empty($id)){
					$this->data=$this->Setting->find("first",array('conditions'=>array('Setting.id'=>$id)));
				}
			}
		}
		
		function encryptdata(){	
		
			$this->layout = '';
			$this->autoRender="";
			App::import('Model','ChapterQuestion');
            $this->ChapterQuestion = new ChapterQuestion;
			
			$data =  $this->ChapterQuestion->find('all');
			
			$res['messageid']=1;
			$res['Message']="success"; 
			$res['data']= $data;
			
			$res['link'] = 'http://nordian.demo.netsmartz.us/files/test.zip';
			
			
			$json_result=json_encode($res);
			//pr($json_result); die;
			return htmlspecialchars_decode($json_result, ENT_QUOTES);
			
		}
		
		
		function summaryencryptdata(){	
		
			$this->layout = '';
			$this->autoRender="";
			App::import('Model','Summary');
            $this->Summary = new Summary;
			
			$data =  $this->Summary->findById(18);
			
			$res['Data']['messageid']=1;
			$res['Data']['Message']="success"; 
			
			
			$res['Data']['description']= $data['Summary']['description']; 
			
			$res['Data']['link'] = 'http://nordian.demo.netsmartz.us/files/test.zip';
			
			
			$json_result=json_encode($res);
			//pr($json_result); die;
			return htmlspecialchars_decode($json_result, ENT_QUOTES);
			
		}
		
		function decryptdata($data){	
			return $this->_fnDecrypt($data, $this->sSecretKey);
		}
	}
?>