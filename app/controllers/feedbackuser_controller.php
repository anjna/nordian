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
	class SubjectsController extends AppController
	{
	
		// admin model
		var $name = 'Subjects';
		
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
			$this->Auth->allow('admin_getsubject','admin_getdropsubject','admin_getdropchapter','subjectlisting','generatejson');
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
		    $this->Subject->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('Subject has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'subjects','action'=>'/index'));
	 
		}// end of function admin_delete
		
        /*_____________________________________________________________________________
		*	@Function:	admin_changestatus
		*	@Description:	activate/deactivate records from static_page table
		*	@param:		$id, status
		*	@return:
		  ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
		*/
	
		function admin_changeisactive($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'subjects','action'=>'/index'));
			}
	
			$this->Subject->id=$id;
			$is_active='';
			
			if($status=='ready'){
				$is_active='ready';
				$message='ready';
			
			}elseif($status=='inprogress'){
				$is_active='inprogress';
				$message='inprogress';
			
			}else{
				$this->redirect(array('controller'=>'subjects','action'=>'/index'));
			}
	
			$this->Subject->saveField('is_active',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Subject has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'subjects','action'=>'/index'));
	 
		}// end of function admin_changestatus
        
		function admin_changestatus($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'subjects','action'=>'/index'));
			}
	
			$this->Subject->id=$id;
			$is_active='';
			
			
			
			if($status=='publish'){
				$is_active='publish';
				$message='publish';
			
			}elseif($status=='unpublish'){
				$is_active='unpublish';
				$message='unpublish';
			
			}else{
				$this->redirect(array('controller'=>'subjects','action'=>'/index'));
			}
	
			$this->Subject->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Subject has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'subjects','action'=>'/index'));
	 
		}// end of function admin_changestatus
		
		
		function admin_publishsubject($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'subjects','action'=>'/index'));
			}
	
			$this->Subject->id=$id;
			$is_active='';
			
			if($status=='publish'){
				$is_active='publish';
				$message='published';
			
			}elseif($status=='unpublish'){
				$is_active='unpublish';
				$message='unpublished';
			
			}else{
				$this->redirect(array('controller'=>'subjects','action'=>'/index'));
			}
	
			$this->Subject->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Subject has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'subjects','action'=>'/index'));
	 
		}// end of function admin_changestatus
		
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for Subjects listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($gid=null,$fieldname=null){		
		    $user_id = $this->Auth->user('id');		
			$utype = $this->Auth->user('type');	
		    // if admin is login
		    $submit_value='Add Subject';
            $this->layout = 'admin_inner';
           
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
		    if(!empty($this->data) && $this->data['Subject']['formtype']=='data')
			{                    
					
				if($this->Subject->validates())
				{
					$this->data['Subject']['admin_id'] = $user_id;
					
					$this->data['Subject']['description'] = $this->_fnEncrypt($this->data['Subject']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
			
					if($this->Subject->save($this->data['Subject'])) {
						if(empty($this->data['Subject']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Subject has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Subject has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'subjects','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Subject please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
			else
			{

				if(!empty($gid)){
					$this->data=$this->Subject->find("first",array('conditions'=>array('Subject.id'=>$gid),'contain' => false));
					$submit_value='Update Subject';
				}					
			}
		    
            $conditions=array();
		    if(isset($this->data['Subject']['keyword']) && !empty($this->data['Subject']['keyword']) ) {
				$keyword = $this->data['Subject']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
			
			if(!empty($id))
			{
				$fieldtype = 'Subject.'.$fieldname;
				$conditions[$fieldtype] = $id;
			}
			
			 //pr($this->params); die;
			$coursename = 'All Subjects';
			if(!empty($gid)){
				$conditions['Subject.course_id'] = $gid;	
				
				$courseInfo = $this->Course->find('first',array('conditions'=>array('Course.id'=>$gid)));
				$coursename = $courseInfo['Course']['name'];
				$cid = $gid;				
			}
			$this->set('coursename', $coursename);
			$cid = "";
			if(isset($this->data['Subject']['cid']) && !empty($this->data['Subject']['cid']) ) {
				$cid = $this->data['Subject']['cid'];
		    }
		    
		    if(isset($this->params['named']['cid']) && !empty($this->params['named']['cid']) ) {
				$cid = $this->params['named']['cid'];
		    }
			
			 
			 if(isset($cid) && !empty($cid) ) {
							$this->data['Subject']['cid']= trim($cid);
							$conditions['Subject.course_id']= $cid;                   
							
		    }
			
		   
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['Subject']['keyword']= trim($keyword);
							$conditions['OR']['Subject.name LIKE']="%".$keyword."%";
                            $conditions['OR']['Subject.description LIKE']="%".$keyword."%";                         
							$this->set('keyword', $keyword);
		    }
			if($utype != 'admin')
            $conditions['Subject.admin_id']= $user_id;  
			//pr($conditions);
			$count = 0;
			if(isset($this->data['Subject']['cid']) || isset($this->data['Subject']['keyword'])){
				$count = $this->Subject->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Subject.name'=>'asc'),'conditions' => $conditions,'contain'=>array('Course','Chapter','Summary','ChapterQuestion'));
		    $allsubjects = $this->paginate('Subject');
			
			//pr($allsubjects); die;
		    $this->set('allsubjects', $allsubjects);		    
		    $this->set('submit_value',$submit_value);
			$this->set('cid',$cid);
		}
        
		
		function admin_add($id=null){
		
			 $user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Subject';
            $this->layout = 'admin_inner';
			$label = "Add Subject";
			App::import('Model','Admin');
			$this->Admin = new Admin;
			$smelist = 	$this->Admin->find('list',array('fields'=>array('id','fullname'),'conditions'=>array('Admin.type !=' => 'admin')));
			//print_r($subjectlist);
			$this->set('smelist',$smelist);
			
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
            
		    if(!empty($this->data) && $this->data['Subject']['formtype']=='data')
			{   

				if(!isset($this->data['Admin']))
				{
					$this->Subject->validationErrors['Admin'] = 'Please assign the SME for adding subject!';
				}
				
				if(isset($this->data['Subject']['existsubject']))
				{
					unset($this->data['Subject']['extcode']);
					unset($this->data['Subject']['intcode']);
					unset($this->data['Subject']['name']);
					unset($this->data['Subject']['description']);
				}
				
				$this->Subject->set($this->data);				
				
				//pr($subjectdata);
				
				if($this->Subject->validates())
				{
					
					if(!isset($this->data['Subject']['existsubject']) && $this->data['Subject']['type'] == "create")
					{
						$this->data['Subject']['admin_id'] = $user_id;					
						$this->data['Subject']['description'] = $this->_fnEncrypt($this->data['Subject']['description'], $this->sSecretKey);
						$this->Subject->save($this->data['Subject']);
						$subject_id = empty($this->data['Subject']['id']) ? $this->Subject->getLastInsertID() : $this->data['Subject']['id'];
					}
					else
					{
						if(empty($this->data['Subject']['id'])){
							$subject_id = $this->data['Subject']['existsubject'];
							
							$subjectdata = $this->Subject->findById($subject_id);
							
							$this->data['Subject']['extcode'] = $subjectdata['Subject']['extcode'];
							$this->data['Subject']['intcode'] = $subjectdata['Subject']['intcode'];
							$this->data['Subject']['name'] = $subjectdata['Subject']['name'];
							$this->data['Subject']['description'] = $subjectdata['Subject']['description'];
							$this->data['Subject']['description'] = $this->_fnEncrypt($this->data['Subject']['description'], $this->sSecretKey);
							$this->Subject->save($this->data['Subject']);
							$subject_id = $this->Subject->getLastInsertID();	
							
							$course_id = $this->data['Subject']['course_id'];
							//pr($this->data);
				
							$sid = $this->data['Subject']['existsubject'];
							$subjectdata = $this->Subject->find('first',array('conditions'=>array('Subject.id'=>$sid),'contain'=>array('Chapter','Summary','ChapterQuestion')));
							
							App::import('Model','Chapter');
							$this->Chapter = new Chapter;
			
							App::import('Model','Summary');
							$this->Summary = new Summary;
							
							App::import('Model','ChapterQuestion');
							$this->ChapterQuestion = new ChapterQuestion;
							
							if(isset($this->data['Subject']['copy']) && !empty($this->data['Subject']['copy']))
							{
								if($this->data['Subject']['copy'][0] == 'all'){
									$chapter = $subjectdata['Chapter'];

									foreach($chapter as $chap){
										$data = $chap;
										$data['id'] = null;
										$data['subject_id'] = $subject_id;
										$data['course_id'] = $course_id;
										$this->Chapter->save($data);
									}
									
									$summary = $subjectdata['Summary'];
									foreach($summary as $sum){
										$data = $sum;
										$data['id'] = null;
										$data['subject_id'] = $subject_id;
										$data['course_id'] = $course_id;
										$this->Summary->save($data);
									}
											
									$cquesion = $subjectdata['ChapterQuestion'];
									foreach($cquesion as $cq){
										$data = $cq;
										$data['id'] = null;
										$data['subject_id'] = $subject_id;
										$data['course_id'] = $course_id;
										$this->ChapterQuestion->save($data);
									}		
								
								}
								else{
								
									$getarr = $this->data['Subject']['copy'];	
									foreach($getarr as $arr)
									{
										if($arr == "c"){
											$chapter = $subjectdata['Chapter'];
											foreach($chapter as $chap){
												$data = $chap;
												$data['id'] = null;
												$data['subject_id'] = $subject_id;
												$data['course_id'] = $course_id;
												$this->Chapter->save($data);
											}								
										}
										if($arr == "cs"){
											$chapter = $subjectdata['Chapter'];
											foreach($chapter as $chap){
												$data = $chap;
												$data['id'] = null;
												$data['subject_id'] = $subject_id;
												$data['course_id'] = $course_id;
												$this->Chapter->save($data);
											}
											$summary = $subjectdata['Summary'];
											foreach($summary as $sum){
												$data = $sum;
												$data['id'] = null;
												$data['subject_id'] = $subject_id;
												$data['course_id'] = $course_id;
												$this->Summary->save($data);
											}
											
										}
										
										if($arr == "cq"){
											$chapter = $subjectdata['Chapter'];
											foreach($chapter as $chap){
												$data = $chap;
												$data['id'] = null;
												$data['subject_id'] = $subject_id;
												$data['course_id'] = $course_id;
												$this->Chapter->save($data);
											}
											$cquesion = $subjectdata['ChapterQuestion'];
											foreach($cquesion as $cq){
												$data = $cq;
												$data['id'] = null;
												$data['subject_id'] = $subject_id;
												$data['course_id'] = $course_id;
												$this->ChapterQuestion->save($data);
											}
											
										}
										
										
									}					
								}
							}
							
							
							
						}
						else
						$subject_id = $this->data['Subject']['id'];	
					}					
					if($subject_id) {
					
					
						App::import('Model','AdminSubject');
						$this->AdminSubject = new AdminSubject;
						
						//$subject_id = !empty($this->data['Subject']['id']) ? $this->data['Subject']['id'] : $this->Subject->getLastInsertID();
						
						if(!empty($this->data['Admin']['id'])){
							// $this->AdminSubject->deleteAll(array('AdminSubject.admin_id'=>$admin_id));
						}
						
						
						foreach($this->data['Admin'] as $adms){								
							$adminsub = array();
							$adminsub['AdminSubject']['id'] = null;
							$adminsub['AdminSubject']['subject_id'] = $subject_id;
							$adminsub['AdminSubject']['course_id'] = $this->data['Subject']['course_id'];
							$adminsub['AdminSubject']['admin_id'] = $adms;									
							$this->AdminSubject->save($adminsub);
						} 
								
					
						if(empty($this->data['Subject']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Subject has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Subject has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'subjects','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Subject please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Subject->validationErrors;
						//print_r($errors); die;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->Subject->find("first",array('conditions'=>array('Subject.id'=>$id),'contain' => array('AdminSubject')));
					
				
					$adminsubjects = @$this->data['AdminSubject'];
					$data['Admin'] = array();
					foreach($adminsubjects as $admins)
					{
						$data['Admin'][] = $admins['admin_id'];
					}
					$this->data['Admin'] = $data['Admin'];
					unset($this->data['AdminSubject']);
					$submit_value='Update Subject';
					$label = "Update Subject";
				}					
			}
		
			 $this->set('submit_value',$submit_value);
			 $this->set('label',$label);
			
		}
		
		function admin_getsubject($courseId=null){
				$this->layout = 'ajax';
				App::import('Model','Subject');
				$this->Subject = new Subject;
			
				$subjects = $this->Subject->find('all',array('conditions'=>array('Subject.course_id'=>$courseId)));
				
				$this->set('subjects',$subjects);
				
		}
		
		function admin_getdropsubject($courseId=null){
				$this->layout = 'ajax';
				App::import('Model','Subject');
				$this->Subject = new Subject;
			
				$subjects = $this->Subject->find('list',array('conditions'=>array('Subject.course_id'=>$courseId)));
				//pr($subjects); die;
				$this->set('subjects',$subjects);
				
		}
		
		function admin_getdropchapter($subjectId=null){
				$this->layout = 'ajax';
				App::import('Model','Chapter');
				$this->Chapter = new Chapter;
			
				$chapters = $this->Chapter->find('list',array('conditions'=>array('Chapter.subject_id'=>$subjectId)));
				//pr($subjects); die;
				$this->set('chapters',$chapters);
				
		}
		
		function subjectlisting($courseId=null)
		{
				
				$this->layout = '';
				$this->autoRender="";
				
				App::import('Model','Subject');
				$this->Subject = new Subject;
			
				$subjects = $this->Subject->find('all',array('conditions'=>array('Subject.course_id'=>13),'order'=>'Subject.modified DESC','contain'=>array('Chapter','Summary','ChapterQuestion','Course')));
				
				//pr($subjects);
				
				$data = array();
				foreach($subjects as $key => $subject){
					$data[$key]['CourseId'] = $subject['Course']['id'];
					$data[$key]['CourseName'] = $subject['Course']['name'];
					$data[$key]['SubId'] = $subject['Subject']['id'];
					$data[$key]['SubName'] = $subject['Subject']['name'];	
					$data[$key]['SubIntCode'] = $subject['Subject']['intcode'];	
					$data[$key]['SubExtCode'] = $subject['Subject']['extcode'];						
					$data[$key]['SubDescription'] = $subject['Subject']['description'];	
					$data[$key]['SubCreated'] = $subject['Subject']['created'];	
					$data[$key]['SubModified'] = $subject['Subject']['modified'];						
					
				}
				
				//pr($data); die;
				$res= $data;
				$json_result=json_encode($res);				
				return htmlspecialchars_decode($json_result, ENT_QUOTES);
		}
		
		
		function generatejson($courseId=null)
		{
				
				$this->layout = '';
				$this->autoRender="";
				
				App::import('Model','Subject');
				$this->Subject = new Subject;
			
				$subjects = $this->Subject->find('all',array('conditions'=>array('Subject.course_id'=>13),'order'=>'Subject.modified DESC','contain'=>array('Chapter','Summary','ChapterQuestion','Course')));
				
				
				$json_result=json_encode($subjects);				
				return htmlspecialchars_decode($json_result, ENT_QUOTES);
		
		}
		
}
?>