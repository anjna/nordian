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
	class ChapterQuestionsController extends AppController
	{
	
		// admin model
		var $name = 'ChapterQuestions';
		
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
			$this->Auth->allow('questionlisting');
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
		    $this->ChapterQuestion->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('ChapterQuestion has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'chapter_questions','action'=>'/index'));
	 
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
				$this->redirect(array('controller'=>'chapter_questions','action'=>'/index'));
			}
	
			$this->ChapterQuestion->id=$id;
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
	
			$this->ChapterQuestion->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Chapter Question has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'chapter_questions','action'=>'/index'));
	 
		}// end of function admin_changestatus
                
			
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for ChapterQuestions listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_index($id=null,$fieldname=null){		
		    $user_id = $this->Auth->user('id');		
			$utype = $this->Auth->user('type');		
		    // if admin is login
		    $submit_value='Add ChapterQuestion';
            $this->layout = 'admin_inner';
			
			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
			App::import('Model','Chapter');
			$this->Chapter = new Chapter;
			$chapterlist = 	$this->Chapter->find('list');
            $this->set('chapterlist',$chapterlist);
		    if(!empty($this->data) && $this->data['ChapterQuestion']['formtype']=='data')
			{                    
					
				if($this->ChapterQuestion->validates())
				{
					$this->data['ChapterQuestion']['admin_id'] = $user_id;
					
					//$this->data['ChapterQuestion']['description'] = $this->_fnEncrypt($this->data['ChapterQuestion']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
					
					$this->data['ChapterQuestion']['option1'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option1'], $this->sSecretKey);
					$this->data['ChapterQuestion']['option2'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option2'], $this->sSecretKey);
					$this->data['ChapterQuestion']['option3'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option3'], $this->sSecretKey);
					$this->data['ChapterQuestion']['option4'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option4'], $this->sSecretKey);
					
					
					
			
					if($this->ChapterQuestion->save($this->data['ChapterQuestion'])) {
						if(empty($this->data['ChapterQuestion']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Chapter Question has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Chapter Question has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'chapter_questions','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the ChapterQuestion please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
			
            $conditions=array();
		    if(isset($this->data['ChapterQuestion']['keyword']) && !empty($this->data['ChapterQuestion']['keyword']) ) {
				$keyword = $this->data['ChapterQuestion']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
		    
			// condition on course
			$course_id = "";
			if(isset($this->data['ChapterQuestion']['course_id']) && !empty($this->data['ChapterQuestion']['course_id']) ) {
				$course_id = $this->data['ChapterQuestion']['course_id'];
		    }
		    
		    if(isset($this->params['named']['course_id']) && !empty($this->params['named']['course_id']) ) {
				$course_id = $this->params['named']['course_id'];
		    }
			
			 
			 if(isset($course_id) && !empty($course_id) ) {
				$this->data['ChapterQuestion']['course_id']= trim($course_id);
				$conditions['ChapterQuestion.course_id']= $course_id;  
		    }
			
			
			// condition on subject_id
			$subject_id = "";
			if(isset($this->data['ChapterQuestion']['subject_id']) && !empty($this->data['ChapterQuestion']['subject_id']) ) {
				$subject_id = $this->data['ChapterQuestion']['subject_id'];
		    }
		    
		    if(isset($this->params['named']['subject_id']) && !empty($this->params['named']['subject_id']) ) {
				$subject_id = $this->params['named']['subject_id'];
		    }
			
			 
			 if(isset($subject_id) && !empty($subject_id) ) {
				$this->data['ChapterQuestion']['subject_id']= trim($subject_id);
				$conditions['ChapterQuestion.subject_id']= $subject_id;  
		    }
			
			// condition on chapter_id
			
			// condition on subject_id
			$chapter_id = "";
			if(isset($this->data['ChapterQuestion']['chapter_id']) && !empty($this->data['ChapterQuestion']['chapter_id']) ) {
				$chapter_id = $this->data['ChapterQuestion']['chapter_id'];
		    }
		    
		    if(isset($this->params['named']['chapter_id']) && !empty($this->params['named']['chapter_id']) ) {
				$chapter_id = $this->params['named']['chapter_id'];
		    }

			if(!empty($id))
			{
				$fieldtype = 'ChapterQuestion.'.$fieldname;
				$conditions[$fieldtype] = $id;
			}
			
			
			 if(isset($chapter_id) && !empty($chapter_id) ) {
				$this->data['ChapterQuestion']['chapter_id']= trim($chapter_id);
				$conditions['ChapterQuestion.chapter_id']= $chapter_id;  
		    }
			
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['ChapterQuestion']['keyword']= trim($keyword);
							$conditions['OR']['ChapterQuestion.question LIKE']="%".$keyword."%";
                                               
							$this->set('keyword', $keyword);
		    }
			
            if($utype != 'admin')
			$conditions['ChapterQuestion.admin_id']= $user_id;  
			
			//pr($conditions);
			$count = 0;
			if(isset($this->data['ChapterQuestion']['subject_id']) || isset($this->data['ChapterQuestion']['keyword'])){
				$count = $this->ChapterQuestion->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			
			
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('ChapterQuestion.question'=>'asc'),'conditions' => $conditions,'contain'=>array('Course','Subject','Chapter'));
		    $allChapterQuestions = $this->paginate('ChapterQuestion');
			//pr($allChapterQuestions); die;
		    $this->set('allChapterQuestions', $allChapterQuestions);		    
		    $this->set('submit_value',$submit_value);
			$this->set('course_id',$course_id);
			$this->set('subject_id',$subject_id);
			$this->set('chapter_id',$chapter_id);
		}
        
		/*_____________________________________________________________________________
		*	@Function       :   admin_index
		*	@Description    :   for ChapterQuestions listing and for add/update
		*	@param          :   id
		*	@return         :   None
		*/
		
		function admin_add($id=null){		
		    $user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Chapter Question';
            $this->layout = 'admin_inner';
			
			$label = "Add Chapter Question";
			App::import('Model','Chapter');
			$this->Chapter = new Chapter;
			$chapterlist = 	$this->Chapter->find('list');
            $this->set('chapterlist',$chapterlist);

			App::import('Model','Course');
			$this->Course = new Course;
			$courselist = 	$this->Course->find('list');
			//print_r($subjectlist);
			$this->set('courselist',$courselist);
			
		    if(!empty($this->data) && $this->data['ChapterQuestion']['formtype']=='data')
			{                    
				//pr($this->data); die;
				$this->ChapterQuestion->set($this->data);
				if($this->ChapterQuestion->validates())
				{
					$this->data['ChapterQuestion']['admin_id'] = $user_id;
					
					//$this->data['ChapterQuestion']['description'] = $this->_fnEncrypt($this->data['ChapterQuestion']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
					
					$this->data['ChapterQuestion']['option1'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option1'], $this->sSecretKey);
					$this->data['ChapterQuestion']['option2'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option2'], $this->sSecretKey);
					$this->data['ChapterQuestion']['option3'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option3'], $this->sSecretKey);
					$this->data['ChapterQuestion']['option4'] = $this->_fnEncrypt($this->data['ChapterQuestion']['option4'], $this->sSecretKey);
					
					
					
			
					if($this->ChapterQuestion->save($this->data['ChapterQuestion'])) {
						if(empty($this->data['ChapterQuestion']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Chapter Question has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Chapter Question has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'chapter_questions','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the ChapterQuestion please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->ChapterQuestion->validationErrors;
						//print_r($errors); die;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->ChapterQuestion->find("first",array('conditions'=>array('ChapterQuestion.id'=>$id),'contain' => array('Chapter')));
					$submit_value='Update Chapter Question';
					$label='Update Chapter Question';
				}					
			}
		    
           	    
		    $this->set('submit_value',$submit_value);
			$this->set('label',$label);
		}
		
		
		function questionlisting($chapterId=null)
		{
				
				$this->layout = '';
				$this->autoRender="";
				
				App::import('Model','ChapterQuestion');
				$this->ChapterQuestion = new ChapterQuestion;
			
				$cquestions = $this->ChapterQuestion->find('all',array('conditions'=>array('ChapterQuestion.chapter_id'=>$chapterId),'order'=>'ChapterQuestion.modified DESC'));
				
				$data = array();
				foreach($cquestions as $key => $question){
					$data[$key]['ChapterId'] = $question['ChapterQuestion']['id'];
					$data[$key]['CourseId'] = $question['ChapterQuestion']['course_id'];
					$data[$key]['SubjectId'] = $question['ChapterQuestion']['subject_id'];
					$data[$key]['ChapterId'] = $question['ChapterQuestion']['chapter_id'];
					$data[$key]['ChapterQuestion'] = $question['ChapterQuestion']['question'];	
					$data[$key]['Chapterop1'] = $question['ChapterQuestion']['option1'];	
					$data[$key]['Chapterop2'] = $question['ChapterQuestion']['option2'];	
					$data[$key]['Chapterop3'] = $question['ChapterQuestion']['option3'];	
					$data[$key]['Chapterop4'] = $question['ChapterQuestion']['option4'];	
					$data[$key]['ChapterAnswer'] = $question['ChapterQuestion']['answer'];	
					$data[$key]['Created'] = $question['ChapterQuestion']['created'];	
					$data[$key]['Modified'] = $question['ChapterQuestion']['modified'];						
					$data[$key]['status'] = $question['ChapterQuestion']['status'];						
				}
				
				//pr($data); die;
				$res= $data;
				$json_result=json_encode($res);				
				return htmlspecialchars_decode($json_result, ENT_QUOTES);
		}
}
?>