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
	class SummariesController extends AppController
	{
	
		// admin model
		var $name = 'Summaries';
		
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
			$this->Auth->allow('summarylisting');
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
		    $this->Summary->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('Summary has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'summaries','action'=>'/index'));
	 
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
				$this->redirect(array('controller'=>'summaries','action'=>'/index'));
			}
	
			$this->Summary->id=$id;
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
	
			$this->Summary->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Summary has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'summaries','action'=>'/index'));
	 
		}// end of function admin_changestatus
                
			
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for Summaries listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null,$fieldname=null){		
		    $user_id = $this->Auth->user('id');	
			$utype = $this->Auth->user('type');				
		    // if admin is login
		    $submit_value='Add Summary';
            $this->layout = 'admin_inner';
			
			
			App::import('Model','Chapter');
			$this->Chapter = new Chapter;
			$chapterlist = 	$this->Chapter->find('list');
            $this->set('chapterlist',$chapterlist);
			
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
			
		    if(!empty($this->data) && $this->data['Summary']['formtype']=='data')
			{                    
					
				if($this->Summary->validates())
				{
					$this->data['Summary']['admin_id'] = $user_id;
					
					//$this->data['Summary']['description'] = $this->_fnEncrypt($this->data['Summary']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
					$this->data['Summary']['description'] = $this->_fnEncrypt($this->data['Summary']['description'], $this->sSecretKey);
					
					if($this->Summary->save($this->data['Summary'])) {
						if(empty($this->data['Summary']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Summary has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Summary has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'summaries','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Summary please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
			
            $conditions=array();
		    if(isset($this->data['Summary']['keyword']) && !empty($this->data['Summary']['keyword']) ) {
				$keyword = $this->data['Summary']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
		    
			
			if(!empty($id))
			{
				$fieldtype = 'Summary.'.$fieldname;
				$conditions[$fieldtype] = $id;
			}
			
			// condition on course
			$course_id = "";
			if(isset($this->data['Summary']['course_id']) && !empty($this->data['Summary']['course_id']) ) {
				$course_id = $this->data['Summary']['course_id'];
		    }
		    
		    if(isset($this->params['named']['course_id']) && !empty($this->params['named']['course_id']) ) {
				$course_id = $this->params['named']['course_id'];
		    }
			
			 
			 if(isset($course_id) && !empty($course_id) ) {
				$this->data['Summary']['course_id']= trim($course_id);
				$conditions['Summary.course_id']= $course_id;  
		    }
			
			
			// condition on subject_id
			$subject_id = "";
			if(isset($this->data['Summary']['subject_id']) && !empty($this->data['Summary']['subject_id']) ) {
				$subject_id = $this->data['Summary']['subject_id'];
		    }
		    
		    if(isset($this->params['named']['subject_id']) && !empty($this->params['named']['subject_id']) ) {
				$subject_id = $this->params['named']['subject_id'];
		    }
			
			 
			 if(isset($subject_id) && !empty($subject_id) ) {
				$this->data['Summary']['subject_id']= trim($subject_id);
				$conditions['Summary.subject_id']= $subject_id;  
		    }
			
			// condition on chapter_id
			
			// condition on subject_id
			$chapter_id = "";
			if(isset($this->data['Summary']['chapter_id']) && !empty($this->data['Summary']['chapter_id']) ) {
				$chapter_id = $this->data['Summary']['chapter_id'];
		    }
		    
		    if(isset($this->params['named']['chapter_id']) && !empty($this->params['named']['chapter_id']) ) {
				$chapter_id = $this->params['named']['chapter_id'];
		    }
			
			 
			 if(isset($chapter_id) && !empty($chapter_id) ) {
				$this->data['Summary']['chapter_id']= trim($chapter_id);
				$conditions['Summary.chapter_id']= $chapter_id;  
		    }
			
			
			
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['Summary']['keyword']= trim($keyword);
							$conditions['OR']['Summary.name LIKE']="%".$keyword."%";
                                               
							$this->set('keyword', $keyword);
		    }
			
			//echo $utype;
			if($utype != 'admin')
            $conditions['Summary.admin_id']= $user_id; 
			
			//pr($conditions);
			$count = 0;
			if(isset($this->data['Summary']['subject_id']) || isset($this->data['Summary']['keyword'])){
				$count = $this->Summary->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Summary.description'=>'asc'),'conditions' => $conditions,'contain'=>array('Course','Subject','Chapter'));
		    $allSummaries = $this->paginate('Summary');
			//pr($allSummaries); die;
		    $this->set('allSummaries', $allSummaries);		    
		    $this->set('submit_value',$submit_value);
			$this->set('course_id',$course_id);
			$this->set('subject_id',$subject_id);
			$this->set('chapter_id',$chapter_id);
		}
        
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for Summaries listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_add($id=null){		
		    $user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Summary';
            $this->layout = 'admin_inner';
			
			$label = "Add Summary";
			
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
			App::import('Model','Chapter');
			$this->Chapter = new Chapter;
			$chapterlist = 	$this->Chapter->find('list');
            $this->set('chapterlist',$chapterlist);
		    if(!empty($this->data) && $this->data['Summary']['formtype']=='data')
			{              
				
				$this->Summary->set($this->data);
				if($this->Summary->validates())
				{
					$this->data['Summary']['admin_id'] = $user_id;
					
					//$this->data['Summary']['description'] = $this->_fnEncrypt($this->data['Summary']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
					//$this->data['Summary']['admin_id'] = $user_id;
					$this->data['Summary']['description'] = $this->_fnEncrypt($this->data['Summary']['description'], $this->sSecretKey);
					//print_r($this->data['Summary']); die;
					if($this->Summary->save($this->data['Summary'])) {
						if(empty($this->data['Summary']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Summary has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Summary has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'summaries','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Summary please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Summary->validationErrors;
						//print_r($errors); die;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->Summary->find("first",array('conditions'=>array('Summary.id'=>$id),'contain' => array('Chapter')));
					$submit_value='Update Summary';
					$label = "Update Summary";

				}					
			}
		        
		    $this->set('submit_value',$submit_value);
			$this->set('label',$label);
		}
		
		function summarylisting($chapterId=null,$subjectId=null)
		{
				
				$this->layout = '';
				$this->autoRender="";
				
				App::import('Model','Summary');
				$this->Summary = new Summary;
			
				$summaries = $this->Summary->find('all',array('conditions'=>array('Summary.chapter_id'=>$chapterId,'Summary.subject_id'=>$subjectId),'order'=>'Summary.modified DESC'));
				//pr($summaries); die;
				$data = array();
				foreach($summaries as $key => $summary){
					$data[$key]['ChapterId'] = $summary['Summary']['id'];
					$data[$key]['CourseId'] = $summary['Summary']['course_id'];
					$data[$key]['SubjectId'] = $summary['Summary']['subject_id'];
					$data[$key]['ChapterId'] = $summary['Summary']['chapter_id'];
					$data[$key]['SummaryId'] = $summary['Summary']['id'];	
					
					$data[$key]['SummaryDescription'] = $summary['Summary']['description'];	
					
					$data[$key]['Created'] = $summary['Summary']['created'];	
					$data[$key]['Modified'] = $summary['Summary']['modified'];						
					$data[$key]['status'] = $summary['Summary']['status'];						
				}
				
				//pr($data); die;
				$res= $data;
				$json_result=json_encode($res);				
				return htmlspecialchars_decode($json_result, ENT_QUOTES);
		}
}
?>