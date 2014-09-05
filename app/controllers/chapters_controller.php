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
	class ChaptersController extends AppController
	{
	
		// admin model
		var $name = 'Chapters';
		
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
			$this->Auth->allow('chapterlisting');
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
		    $this->Chapter->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('Chapter has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'chapters','action'=>'/index'));
	 
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
				$this->redirect(array('controller'=>'chapters','action'=>'/index'));
			}
	
			$this->Chapter->id=$id;
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
	
			$this->Chapter->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Chapter has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'chapters','action'=>'/index'));
	 
		}// end of function admin_changestatus
                
			
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for Chapters listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null,$fieldname=null){		
		    $user_id = $this->Auth->user('id');		
			$utype = $this->Auth->user('type');	
		    // if admin is login
		    $submit_value='Add Chapter';
            $this->layout = 'admin_inner';
			
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
			App::import('Model','Subject');
			$this->Subject = new Subject;
			$subjectlist = 	$this->Subject->find('list');
            $this->set('subjectlist',$subjectlist);
		    if(!empty($this->data) && $this->data['Chapter']['formtype']=='data')
			{                    
					
				if($this->Chapter->validates())
				{
					$this->data['Chapter']['admin_id'] = $user_id;
					
			
					if($this->Chapter->save($this->data['Chapter'])) {
						if(empty($this->data['Chapter']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Chapter has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Chapter has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'chapters','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Chapter please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
					    
            $conditions=array();
			
		    if(isset($this->data['Chapter']['keyword']) && !empty($this->data['Chapter']['keyword']) ) {
				$keyword = $this->data['Chapter']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
			
			// condition on course
			$course_id = "";
			if(isset($this->data['Chapter']['course_id']) && !empty($this->data['Chapter']['course_id']) ) {
				$course_id = $this->data['Chapter']['course_id'];
		    }
		    
		    if(isset($this->params['named']['course_id']) && !empty($this->params['named']['course_id']) ) {
				$course_id = $this->params['named']['course_id'];
		    }
			
			 
			 if(isset($course_id) && !empty($course_id) ) {
				$this->data['Chapter']['course_id']= trim($course_id);
				$conditions['Chapter.course_id']= $course_id;  
		    }
			
			
			// condition on subject_id
			$subject_id = "";
			if(isset($this->data['Chapter']['subject_id']) && !empty($this->data['Chapter']['subject_id']) ) {
				$subject_id = $this->data['Chapter']['subject_id'];
		    }
		    
		    if(isset($this->params['named']['subject_id']) && !empty($this->params['named']['subject_id']) ) {
				$subject_id = $this->params['named']['subject_id'];
		    }
			
			 
			 if(isset($subject_id) && !empty($subject_id) ) {
				$this->data['Chapter']['subject_id']= trim($subject_id);
				$conditions['Chapter.subject_id']= $subject_id;  
		    }
			
			
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['Chapter']['keyword']= trim($keyword);
							$conditions['OR']['Chapter.name LIKE']="%".$keyword."%";
                                               
							$this->set('keyword', $keyword);
		    }
             
			if(!empty($id))
			{
				$fieldtype = 'Chapter.'.$fieldname;
				$conditions[$fieldtype] = $id;
			}
			if($utype != 'admin')
			$conditions['Chapter.admin_id']= $user_id;  
			//pr($conditions);
			$count = 0;
			if(isset($this->data['Chapter']['subject_id']) || isset($this->data['Chapter']['keyword'])){
				$count = $this->Chapter->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			
			
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Chapter.name'=>'asc'),'conditions' => $conditions,'contain'=>array('Summary','ChapterQuestion','Subject','Course'));
		    $allChapters = $this->paginate('Chapter');
			//pr($allChapters); die;
		    $this->set('allChapters', $allChapters);		    
		    $this->set('submit_value',$submit_value);
			$this->set('course_id',$course_id);
			$this->set('subject_id',$subject_id);
		}
        
		
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for Chapters listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_add($id=null){		
		    $user_id = $this->Auth->user('id');	
			$label = "Add Chapter";
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
		    // if admin is login
		    $submit_value='Add Chapter';
            $this->layout = 'admin_inner';
			
			
			App::import('Model','Subject');
			$this->Subject = new Subject;
			$subjectlist = 	$this->Subject->find('list');
            $this->set('subjectlist',$subjectlist);
		    if(!empty($this->data) && $this->data['Chapter']['formtype']=='data')
			{                    
				$this->Chapter->set($this->data);	
				if($this->Chapter->validates())
				{
					$this->data['Chapter']['admin_id'] = $user_id;
					
					$this->data['Chapter']['description'] = $this->_fnEncrypt($this->data['Chapter']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
			
					if($this->Chapter->save($this->data['Chapter'])) {
						if(empty($this->data['Chapter']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Chapter has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Chapter has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'chapters','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Chapter please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Chapter->validationErrors;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->Chapter->find("first",array('conditions'=>array('Chapter.id'=>$id),'contain' => array('Subject')));
					$submit_value='Update Chapter';
					$label = "Edit Chapter";
				}					
			}	    
               
		    $this->set('submit_value',$submit_value);
			 $this->set('label',$label);
		}
		
		function chapterlisting($subjectId=null)
		{
				
				$this->layout = '';
				$this->autoRender="";
				
				App::import('Model','Chapter');
				$this->Chapter = new Chapter;
			
				$chapters = $this->Chapter->find('all',array('conditions'=>array('Chapter.subject_id'=>$subjectId),'order'=>'Chapter.modified DESC'));
				
				$data = array();
				foreach($chapters as $key => $chapter){
					$data[$key]['ChapterId'] = $chapter['Chapter']['id'];
					$data[$key]['CourseId'] = $chapter['Chapter']['course_id'];
					$data[$key]['SubjectId'] = $chapter['Chapter']['subject_id'];
					$data[$key]['ChapterName'] = $chapter['Chapter']['name'];	
					$data[$key]['Created'] = $chapter['Chapter']['created'];	
					$data[$key]['Modified'] = $chapter['Chapter']['modified'];						
					$data[$key]['status'] = $chapter['Chapter']['status'];						
				}
				
				//pr($data); die;
				$res= $data;
				$json_result=json_encode($res);				
				return htmlspecialchars_decode($json_result, ENT_QUOTES);
		}
}
?>