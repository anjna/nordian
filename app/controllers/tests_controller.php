<?php
   
	class TestsController extends AppController
	{
        	var $name = "Tests";
                //var $uses = array(');
		var $helpers = array('Form');

		function beforeFilter()
		{
			parent::beforeFilter();	
		}

    		public function index()
		{
			$this->layout = "";
			$view = $this->Test->find('all');
   			$this->set('alldata', $view);		
		}

		public function add($id=null)
		{
			$this->layout = "";
			if(isset($this->data))	
			{	
	
				//print_r($this->data['Test']['name']);	
				$this->Test->save($this->data['Test']);
				$this->redirect('/tests/index');
				
			}

			$this->data=$this->Test->find("first",array("conditions" => array("Test.id" =>$id)));				
					
	

		}
		public function delete($id)
		{

			$this->layout= "";
			$this->Test->delete($id);
			$this->redirect('/tests/index');

		}
		function changestatus($id=null,$status=null)
		{
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'tests','action'=>'/index'));
			}
	
			$this->Test->id=$id;
			$is_active='';
			
			if($status=='enable'){
				$is_active='1';
				$message='enabled';
			
			}elseif($status=='disable'){
				$is_active='0';
				$message='disabled';
			
			}else{
				$this->redirect(array('controller'=>'tests','action'=>'/index'));
			}
	
			$this->Test->saveField('status',$is_active);       		
		    $this->redirect(array('controller'=>'tests','action'=>'/index'));
	 
		}
		function changeselectedstatus($id=null,$status=null)
		{
		$this->layout = " ";
		if(isset($this->data))	
		{
		$allusers=$this->data['Test']['allusers'];	
		$this->set('alluser', $allusers);		
		}
			if(empty($id) || empty($status)){
				$this->redirect(array('controller'=>'tests','action'=>'/index'));
			}
	
			$this->Test->id=$id;
			$is_active='';
			
			if($status=='enable'){
				$is_active='1';
				$message='enabled';
			
			}elseif($status=='disable'){
				$is_active='0';
				$message='disabled';
			
			}else{
				$this->redirect(array('controller'=>'tests','action'=>'/index'));
			}
	
			$this->Test->saveField('status',$is_active);       		
		    $this->redirect(array('controller'=>'tests','action'=>'/index'));
	 
		}
		
		
		function multipleactionstatus()
		{
		
			if(isset($this->data))
			{
				//print_r($_POST);
				$status = ($_POST['submit'] == 'Enable') ? 1 : 0;
				//die;
				foreach($this->data['Test']['allusers'] as $ids)
				{
				
						$this->Test->id = $ids;
						$this->Test->saveField('status',$status);      
				}
				
					$this->redirect(array('controller'=>'tests','action'=>'/index'));
			
			}
	 
		}
		
	}
			
?>
