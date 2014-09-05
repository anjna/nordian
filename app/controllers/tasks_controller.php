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
	class TasksController extends AppController
	{
	
		// admin model
		var $name = 'Tasks';
		var $uses= array('Task');
		
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
		    $this->Task->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('Task has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'tasks','action'=>'/index'));
	 
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
				$this->redirect(array('controller'=>'tasks','action'=>'/index'));
			}
	
			$this->Task->id=$id;
			$is_active='';
			
			if($status=='enable'){
				$is_active='enable';
				$message='enabled';
			
			}elseif($status=='disable'){
				$is_active='disable';
				$message='disabled';
			
			}else{
				$this->redirect(array('controller'=>'tasks','action'=>'/index'));
			}
	
			$this->Task->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Topic has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'tasks','action'=>'/index'));
	 
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
		    $submit_value='Add  Task';
                         $this->layout = 'admin_inner';
         date_default_timezone_set('Asia/Calcutta');
			//pr($this->params);	
			//echo '<pre>';print_r($this->data);die;
		    if(!empty($this->data) && $this->data['Task']['formtype']=='data')
			{                    
			    
				if($this->Task->validates())
				{
					$this->data['Task']['user_id'] = $user_id;
					
					$this->data['Task']['project_description'] = $this->_fnEncrypt($this->data['Task']['project_description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
			
					if($this->Task->save($this->data['Task'])) {
						if(empty($this->data['Task']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Topic has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Topic has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'tasks','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Course please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
			
		   // debug($this->data);die;
            $conditions=array();
		   /* if(isset($this->data['Task']['start_date']) && !empty($this->data['Task']['start_date']) ) {
			 $start_date = date( 'Y-m-d',strtotime($this->data['Task']['start_date']));
			 echo $start_date;
			// echo $keyword;die;
		    }
			
			 if(isset($this->data['Task']['end_date']) && !empty($this->data['Task']['end_date']) ) {
			 $end_date = date( 'Y-m-d',strtotime($this->data['Task']['end_date']));
			 echo $end_date;
			// echo $keyword;die;
		    } */
			
			if(isset($this->data['userlist']) && !empty($this->data['userlist']) ) {
			 $userlist = date( 'Y-m-d',strtotime($this->data['userlist']));
		   // echo $userlist;die;
		    }
			
		   /* if(isset($this->params['named']['start_date']) && !empty($this->params['named']['start_date']) ) {
			$start_date = date( 'Y-m-d',strtotime($this->params['named']['start_date']));
		    }
			
			 if(isset($this->params['named']['end_date']) && !empty($this->params['named']['end_date']) ) {
			$end_date = date( 'Y-m-d',strtotime($this->params['named']['end_date']));
		    } */
			
		    //pr($this->params); die;
			if(isset($this->data['Task']['cid']) && !empty($this->data['Task']['cid']) ) {
				$cid = $this->data['Task']['cid'];
		    }
		    
		    if(isset($this->params['named']['cid']) && !empty($this->params['named']['cid']) ) {
				$cid = $this->params['named']['cid'];
		    }
			$this->loadModel('Admin');
			//$fetch_AdminArr = $this->Admin->find('first', array('condition' => array('id'=>$user_id)));
			//$task_userArr = $this->Task->find('first', array('condition' => array('user_id'=>$user_id)));
			//debug($fetch_AdminArr);die;
			// Condition to show data only for admin and login user
			//debug($fetch_AdminArr['Admin'] ['id']);die;
			//$this->loadModel('Admin');
			if($user_id==1)	
			{
			    $conditions = null;
				if(!empty($this->data) || $this->params['named'])
				{
					if(!empty($this->data))
					{
						 $alluserlist = $this->data['Task']['alluserlist'];
						 $start_date = date( 'Y-m-d',strtotime($this->data['Task']['start_date']));
						 $end_date = date( 'Y-m-d',strtotime($this->data['Task']['end_date']));
					}
					 elseif(isset($this->params['named']) && !empty($this->params['named']))
					 {
						  $alluserlist = $this->params['named']['alluserlist'];
						  $start_date = date( 'Y-m-d',strtotime($this->params['named']['start_date']));
						  $end_date = date( 'Y-m-d',strtotime($this->params['named']['end_date']));
					 }
					$conditions =  array(
										'AND' => array(
													array('Task.user_id' => $alluserlist),
													array('Task.created BETWEEN ? and ? ' => array($start_date, $end_date))		
												)
											);			
				}
		   } 
		   elseif( isset($user_id) && $user_id !=1)
		   {
				 $conditions = array(
										'AND' => array(
													array('Task.user_id' => $user_id)
												)
											);
		   }
		    //condition for searching users
		
		  /*  if(isset($start_date) && !empty($start_date) ) {
			    $this->data['Task']['start_date']= trim($start_date);
				$conditions['OR']['Task.created LIKE'] = "%".$start_date."%"; 
				//$conditions['AND']['Task.user_id']= $user_id;
			    $this->set('start_date', $start_date);
		    }
			
			  if(isset($end_date) && !empty($end_date) ) {
			    $this->data['Task']['end_date']= trim($end_date);
			    $conditions['OR']['Task.created LIKE'] = "%".$end_date."%"; 
				//$conditions['AND']['Task.user_id']= $user_id;
			    $this->set('end_date', $end_date);
		    } 
			
			  if(isset($alluserlist) && !empty($alluserlist) ) {
			    $this->data['alluserlist']= trim($alluserlist);
			    $conditions['OR']['alluserlist LIKE'] = "%".$alluserlist."%"; 
			    $this->set('alluserlist', $alluserlist);
		    } */
			
			 if(isset($cid) && !empty($cid) ) {
			    $this->data['Task']['cid']= trim($cid);
							$conditions['Task.id']= $cid;                   
							
		    }
			
		
			//echo $conditions;die;
			//$conditions['Topic.user_id']= $userid;                 
				
	       $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Task.modified'=>'DESC'),'conditions' => $conditions); 
	       $allCourses = $this->paginate('Task');
		  //pr($allCourses);die;
			// Below code is for total result count
			/*$count = 0;
			if(isset($this->data['Task']['cid']) || isset($this->data['Task']['keyword'])){
				$count = $this->Task->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count); */
			//pr($allCourses); die;
		    $this->set('allCourses', $allCourses);		
			$userlist = $this->Admin->find('list',array(
																'fields'=>array('fullname'),
																'conditions'=>array('Admin.type'=>'sme')
															));
			$this->set('userlist', $userlist);	
			$this->set('submit_value',$submit_value);
			$this->set('cid', @$cid);
			$this->set('id', @$id);
			$this->set('iduser',$user_id );
			
			
		}
        
		
		function admin_add($id=null){
		
			$user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Task';
			$label = "Add Task";
            $this->layout = 'admin_inner';
            date_default_timezone_set('Asia/Calcutta');   
		    if(!empty($this->data) && $this->data['Task']['formtype']=='data')
			{                    
				 $this->Task->set($this->data);
			
				if($this->Task->validates())
				{
					
				$this->data['Task']['admin_id'] = $user_id;
				$this->data['Task']['user_id']=$user_id;	
			
					if($this->Task->save($this->data['Task'])) 
					{
							
					if(empty($this->data['Task']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Task has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Task has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'tasks','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the tasks please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Task->validationErrors;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->Task->find("first",array('conditions'=>array('Task.id'=>$id)));
					
					$submit_value='Update Course';
					$label = "Edit Course";
				}					
			}
			
				
			
			
		

			
			
			$this->set('id', @$id);
			$this->set('submit_value',$submit_value);
			$this->set('label',$label);
		}
		
		
		function admin_senddsr($id=null){
		
		        // if(!empty->data)
					// {	
										$alldata=$this->Task->find("all");
							if(!empty($alldata))
								{
										//pr($alldata);die;
									
								
										/* SMTP Options */
										$this->Email->smtpOptions = array(
										 'port'=>'465',
										 'timeout'=>'30',
										 'host' => 'ssl://smtp.gmail.com',
										 'username'=>'trigmap1@gmail.com',
										'password'=>'trigma123',
									);

										
												$this->Email->from    = 'Admin <trigmap1@gmail.com>';
												$this->Email->to      =  '<anjana.sharma@trigma.in>';
												$this->Email->subject = 'New user registered';
												$this->Email->sendAs = 'both';
												$this->Email->template = 'alldsr';
												$this->set('alldata', $alldata);
												$this->Email->send();
												$this->Session->setFlash('sending mail successfully.',"default",array('class'=>'failureMessage'));
									            $this->redirect(array('controller'=>'tasks','action'=>'/index'));
								}
							else
								{	
									$this->Session->setFlash('There is no DSR to send.',"default",array('class'=>'failureMessage'));
									 $this->redirect(array('controller'=>'tasks','action'=>'/index'));
								}
					}
		
	}
?>


