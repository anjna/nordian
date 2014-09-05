<?php
    /**
	* 0Static Pages Controller class
	* PHP versions 5.1.4
	* @filesource
	* @author
	* @link       http://www.smartdatainc.com/
	* @copyright  Copyright 2009 
	* @version 0.0.1 
	*   - Initial release
	*/
	class TopicsController extends AppController
	{
	
		// admin model
		var $name = 'Topics';
		var $uses= array('Feedback','Topic','Admin');
		
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
			//$this->Auth->allow('*');
		}
		
		/*
		*_____________________________________________________________________________
		*@Function:	before Render
		*@Description:	before Render
		*@param:	None
		*@return:	nonelogin
		*______________________________________________________________________________
		*/	
		
		function beforeRender(){			
			parent::beforeRender();			
		}
		
		/*_____________________________________________________________________________
		*	@Function:		admin_delete
		*	@Description:	delete records from static_pages table
		*	@param:		    $id
		*	@return:
		  ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
		*/
	
		function admin_delete($id=null)
		{		
		    //delete records	
		    $this->Topic->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('Topics has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'topics','action'=>'/index'));
	 
		}// end of function admin_delete
		
        /*_____________________________________________________________________________
		*	@Function:	admin_changestatus
		*	@Description:	activate/deactivate records from static_page table
		*	@param:		$id, status
		*	@return:
		  ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
		*/

		function admin_changestatus($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'topics','action'=>'/index'));
			}
	
			$this->Topic->id=$id;
			$is_active='';
			
			if($status=='enable'){
				$is_active='enable';
				$message='enabled';
			
			}elseif($status=='disable'){
				$is_active='disable';
				$message='disabled';
			
			}else{
				$this->redirect(array('controller'=>'topics','action'=>'/index'));
			}
	
			$this->Topic->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Topic has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'topics','action'=>'/index'));
	 
		}// end of function admin_changestatus
                
			
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for Courses listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null){		
		    $user_id = $this->Auth->user('id');	
			$utype = $this->Auth->user('type');				
		    // if admin is login
		    $submit_value='Add  Topic';
                         $this->layout = 'admin_inner';
         
			//pr($this->params);	
		    if(!empty($this->data) && $this->data['Topic']['formtype']=='data')
			{                    				
				if($this->Topic->validates())
				{
					$this->data['Topic']['admin_id'] = $user_id;
					
					$this->data['Topic']['description'] = $this->_fnEncrypt($this->data['Topic']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
			
					if($this->Topic->save($this->data['Topic'])) {
						if(empty($this->data['Topic']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Topic has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Topic has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'topics','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Course please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
			
		    
            $conditions=array();
		    if(isset($this->data['Topic']['keyword']) && !empty($this->data['Topic']['keyword']) ) {
				$keyword = $this->data['Topic']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
			
			
		    //pr($this->params); die;
			if(isset($this->data['Topic']['cid']) && !empty($this->data['Topic']['cid']) ) {
				$cid = $this->data['Topic']['cid'];
		    }
		    
		    if(isset($this->params['named']['cid']) && !empty($this->params['named']['cid']) ) {
				$cid = $this->params['named']['cid'];
		    }
			
		$this->loadModel('Admin');
			if($user_id==1)	
		  {
				$conditions = null;
		   } 
		   elseif( isset($user_id) && $user_id !=1)
		   {
				$topic_list = $this->Topic->find('all');
				//debug($topic_list);die;
				$conditions = array(
										'AND' => array(
													array('Topic.user_id' => $user_id)
												)
											);
		   }
			
			
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['Topic']['keyword']= trim($keyword);
							$conditions['OR']['Topic.topic LIKE']="%".$keyword."%";
                            $conditions['OR']['Topic.description LIKE']="%".$keyword."%";                         
							$this->set('keyword', $keyword);
		    }
            
			 if(isset($cid) && !empty($cid) ) {
			    $this->data['Topic']['cid']= trim($cid);
							$conditions['Topic.id']= $cid;                   
							
		    }
			
			//$conditions['Topic.user_id']= $userid;                 
				
	   $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Topic.modified'=>'DESC'),'conditions' => $conditions,'contain'=>array('Feedback')); 
	   $allCourses = $this->paginate('Topic');
			$count = 0;
			if(isset($this->data['Topic']['cid']) || isset($this->data['Topic']['keyword'])){
				$count = $this->Topic->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			//pr($allCourses); die;
		    $this->set('allCourses', $allCourses);		    
			
			$topiclist = $this->Topic->find('list');
			$this->set('topiclist', $topiclist);	
			//die;
			App::import('Model', 'Feedback');
			$this->Feedback = new Feedback;
			
			/*
			$sum = $this->Feedback->find('all', array(
				'conditions' =>  "Feedback.topic_id =topic_id ",
				'fields'     =>  "SUM(feedback) as 'total'",
				'group'      =>  "Feedback.topic_id"
        ));
		    $this->set('sum',$sum);
		    */
			$this->set('submit_value',$submit_value);
			
			$this->set('cid', @$cid);
			$this->set('id', @$id);
			$this->set('iduser',$user_id );
			
			
		}
        
		
		function admin_add($id=null){
		
			$user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Topic';
			$label = "Add Topic";
            $this->layout = 'admin_inner';
                    
		    if(!empty($this->data) && $this->data['Topic']['formtype']=='data')
			{                    
				 $this->Topic->set($this->data);
			
				if($this->Topic->validates())
				{
					
				$this->data['Topic']['admin_id'] = $user_id;
					
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
				//debug($this->data);
				    $topic=$this->data['Topic']['topic'];
					$description=$this->data['Topic']['description'];
					$presentator=$this->data['Topic']['presentator'];
			        
				//	echo $start;die;
				   $allmails=$this->data['Topic']['email']=implode(',', $this->data['Topic']['allusers']);
				   $alldList = $this->Admin->find('all',array('conditions'=>array('Admin.email'=>$this->data['Topic']['allusers'])));
				   //pr($alldList);die;
				   foreach($alldList as $data)
				   {
				 
						$userIdList[]=	$data['Admin']['id'];
				   }
				   
				   $this->data['Topic']['user_id']	=	implode(',', $userIdList);
				   $count_of_mails=count($this->data['Topic']['allusers']); 
				   //$this->countusers=count($this->data['Topic']['allusers']);
			
                    // $this->set('allmails',$alldata);	                
			     //  	$this->data['Topic']['user_id']=$this->data['Topic']['useremail'];
				//	pr( $this->data['Topic']['allusers']);die;
					if(!empty($allmails))
						{
						
						$start=date('Y-m-d H:i:s a',strtotime($this->data['Topic']['start_time']));
						$end= date('Y-m-d H:i:s a',strtotime($this->data['Topic']['end_time']));
						
						
						/* SMTP Options */
						$this->Email->smtpOptions = array(
							 'port'=>'465',
							 'timeout'=>'30',
							 'host' => 'ssl://smtp.gmail.com',
							 'username'=>'trigmap1@gmail.com',
							'password'=>'trigma123',
						);

						
						$this->Email->from    = 'Admin <trigmap1@gmail.com>';
						$this->Email->to      = $allmails;
						$this->Email->subject = 'New user registered';
						$this->Email->sendAs = 'both';
						$this->Email->template = 'userinfo';
						$this->set('topic', $topic);
						$this->set('description', $description);
						$this->set('presentator', $presentator);
						$this->set('start_time', $start);
						$this->set('end_time', $end);
						$this->Email->send();
						}
					if($this->Topic->save($this->data['Topic'])) 
					{
						
					
					
						if(empty($this->data['Topic']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Topic has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Topic has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'topics','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the topics please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Topic->validationErrors;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->Topic->find("first",array('conditions'=>array('Topic.id'=>$id)));
					
					$submit_value='Update Course';
					$label = "Edit Course";
				}					
			}
				
			   //___Check user if user is not exist display message invalid user
		/* 	 if(!empty($allmails))
			    {
					foreach($count_of_mails as $allusersmails)
					{
						echo $allmails;
							$this->Email->to = $allmails;		
							$this->Email->subject = 'New user Registered';				
							$this->Email->message = 'hello users';
							$this->Email->sendAs = 'both';
							//$this->sendMail($to,$subject,$message);
							$this->Email->send();
					
					}
					die;
				} */
			
		
			App::import('Model', 'Admin');
			$this->Admin = new Admin;

			$view = $this->Admin->find('all',array("conditions"=>array("Admin.type"=>'sme')));
   			$this->set('alldata', $view);		
			
			
			$this->set('id', @$id);
			$this->set('submit_value',$submit_value);
			$this->set('label',$label);
		}
		function admin_feedbackuser($id=null)
		{
		   App::import('Model', 'Feedback');
			$this->Feedback = new Feedback;
           $user_id = $this->Auth->user('id');	  
		    // if admin is login
		    $submit_value='Give feedback';
			$label = "Give feedback";
		     $this->layout = 'admin_inner';
			
			if(!empty($this->data) && $this->data['Feedback']['formtype']=='data')
			{                    
	   		if($this->Topic->validates())
				{
				$this->data['Feedback']['admin_id'] = $user_id;
					
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
					
				   $this->data['Feedback']['user_id']=$user_id;
   
					if($this->Feedback->save($this->data['Feedback'])) {
						if(empty($this->data['Feedback']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Session has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Session
							has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'topics','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the topics please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Feedback->validationErrors;
						$this->set('errors',$errors);
				}
		    }
		
			

			App::import('Model', 'Admin');
			$this->Admin = new Admin;

			$view = $this->Admin->find('all',array("conditions"=>array("Admin.type"=>'sme')));
   			$this->set('alldata', $view);		
			
			
			$this->set('id', @$id);
			$this->set('submit_value',$submit_value);
			$this->set('label',$label);
		}
		
		function admin_feedbackview($id=null)
		{
          	 $user_id = $this->Auth->user('id');	  
		App::import('Model', 'Admin');
		$this->Admin = new Admin;
		    // if admin is login
		    $submit_value='Give feedback';
			$label = "Give feedback";
		     $this->layout = 'admin_inner';			
			$topicArr =$this->Topic->find('first',array('conditions'=>array('Topic.id'=>$id)));
			
		//pr($topicArr);die;
			foreach($topicArr['Feedback'] as $key=>$valUserId){
					$viewUserData = $this->Admin->find('first',array("conditions"=>array("Admin.id"=>$valUserId['user_id'])));
					$topicArr['Feedback'][$key]['fullname'] = $viewUserData['Admin']['fullname'];
			//	pr($viewUserData);
			}
			
			//echo '<pre>';pr($topicArr);die;
				$this->set('feedbackuserid',$topicArr);	
		}
		
	}
?>


