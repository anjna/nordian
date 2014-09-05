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
	class CoursesController extends AppController
	{
	
		// admin model
		var $name = 'Courses';
		
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
		    $this->Course->delete($id);
		    //setting sucess message
		    $this->Session->setFlash('Course has been deleted successfully.','default',array('class'=>'successMessage'));
		    $this->redirect(array('controller'=>'courses','action'=>'/index'));
	 
		}// end of function admin_delete
		
        /*_____________________________________________________________________________
		*	@Function:	admin_changestatus
		*	@Description:	activate/deactivate records from static_page table
		*	@param:		$id, status
		*	@return:
		  ¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯¯
		*/
		function admin_viewusers()
		{
		$this->layout = '';
		if($type=="sme")
			{
			$view = $this->Course->find('all');
   			$this->set('alldata', $view);		
			$this->redirect('/courses/admin_add');
			}
        }	
		function admin_changestatus($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'courses','action'=>'/index'));
			}
	
			$this->Course->id=$id;
			$is_active='';
			
			if($status=='enable'){
				$is_active='enable';
				$message='enabled';
			
			}elseif($status=='disable'){
				$is_active='disable';
				$message='disabled';
			
			}else{
				$this->redirect(array('controller'=>'courses','action'=>'/index'));
			}
	
			$this->Course->saveField('status',$is_active);

		    //setting sucess message
		    $this->Session->setFlash('<div class="successMessage">Course has been '.$message.' successfully.</div>');            		
		    $this->redirect(array('controller'=>'courses','action'=>'/index'));
	 
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
		    $submit_value='Add Course';
                         $this->layout = 'admin_inner';
            

			//pr($this->params);	
		    if(!empty($this->data) && $this->data['Course']['formtype']=='data')
			{                    
					
				if($this->Course->validates())
				{
					$this->data['Course']['admin_id'] = $user_id;
					
					$this->data['Course']['description'] = $this->_fnEncrypt($this->data['Course']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
			
					if($this->Course->save($this->data['Course'])) {
						if(empty($this->data['Course']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Course has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Course has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'courses','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Course please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
		    }
			
		    
            $conditions=array();
		    if(isset($this->data['Course']['keyword']) && !empty($this->data['Course']['keyword']) ) {
				$keyword = $this->data['Course']['keyword'];
		    }
		    
		    if(isset($this->params['named']['keyword']) && !empty($this->params['named']['keyword']) ) {
				$keyword = $this->params['named']['keyword'];
		    }
			
			
		    //pr($this->params); die;
			if(isset($this->data['Course']['cid']) && !empty($this->data['Course']['cid']) ) {
				$cid = $this->data['Course']['cid'];
		    }
		    
		    if(isset($this->params['named']['cid']) && !empty($this->params['named']['cid']) ) {
				$cid = $this->params['named']['cid'];
		    }
			
			
		    //condition for searching users
		    if(isset($keyword) && !empty($keyword) ) {
			    $this->data['Course']['keyword']= trim($keyword);
							$conditions['OR']['Course.name LIKE']="%".$keyword."%";
                            $conditions['OR']['Course.description LIKE']="%".$keyword."%";                         
							$this->set('keyword', $keyword);
		    }
            
			 if(isset($cid) && !empty($cid) ) {
			    $this->data['Course']['cid']= trim($cid);
							$conditions['Course.id']= $cid;                   
							
		    }
			
			//echo $this->paging_length;
			if($utype != 'admin')
			$conditions['Course.admin_id']= $user_id;  
			
		    $this->paginate=array('limit' => $this->paging_length, 'page' => 1, 'order'=>array('Course.modified'=>'DESC'),'conditions' => $conditions,'contain'=>array('Subject','Chapter','Summary','ChapterQuestion'));
		    $allCourses = $this->paginate('Course');
			
			//pr($conditions);
			$count = 0;
			if(isset($this->data['Course']['cid']) || isset($this->data['Course']['keyword'])){
				$count = $this->Course->find('count',array('conditions' => $conditions));
			}
			$this->set('count',$count);
			//pr($allCourses); die;
		    $this->set('allCourses', $allCourses);		    
			
			$courselist = $this->Course->find('list');
			$this->set('courselist', $courselist);	
			//die;
		    $this->set('submit_value',$submit_value);
			
			$this->set('cid', @$cid);
			$this->set('id', @$id);
		}
        
		
		function admin_add($id=null){
		
			 $user_id = $this->Auth->user('id');		
		    // if admin is login
		    $submit_value='Add Course';
			$label = "Add Course";
            $this->layout = 'admin_inner';
                    
		    if(!empty($this->data) && $this->data['Course']['formtype']=='data')
			{                    
				$this->Course->set($this->data);
				if($this->Course->validates())
				{
					$this->data['Course']['admin_id'] = $user_id;
					
					$this->data['Course']['description'] = $this->_fnEncrypt($this->data['Course']['description'], $this->sSecretKey);
					//echo "Encrypred: ".$crypted."</br>";
					
					//$sSecretKey = "secret_key";
					
					//$newClear = $this->_fnDecrypt($crypted, $this->sSecretKey);
					//echo "Decrypred: ".$newClear."</br>";
			
			
					if($this->Course->save($this->data['Course'])) {
						if(empty($this->data['Course']['id'])){
						    $this->Session->setFlash('<div class="successMessage"> Course has been added successfully.</div>');
						}else{
						    $this->Session->setFlash('<div class="successMessage"> Course has been updated successfully.</div>');
						}
						$this->redirect(array('controller'=>'courses','action'=>'/index'));
					}
					else {
						$this->Session->setFlash('There was a problem saving the Course please review the errors below and try again.',"default",array('class'=>'failureMessage'));
					}
				}
				else{
						$errors = $this->Course->validationErrors;
						$this->set('errors',$errors);
				}
		    }
			else
			{

				if(!empty($id)){
					$this->data=$this->Course->find("first",array('conditions'=>array('Course.id'=>$id),'contain' => array('Subject')));
					
					$this->set('subcount',count($this->data['Subject']));
					$submit_value='Update Course';
					$label = "Edit Course";
				}					
			}
			
			if(!empty($id)){
					App::import('Model', 'Subject');
					$this->Subject = new Subject();
		
					$totalsubject =$this->Subject->find("count",array('conditions'=>array('Subject.course_id'=>$id)));
					$this->set('totalsubject',$totalsubject);
			}
			
			
			$this->set('id', @$id);
			$this->set('submit_value',$submit_value);
			$this->set('label',$label);
		}
}
?>
