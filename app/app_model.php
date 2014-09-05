<?php
class AppModel extends Model {
	var $actsAs = array('Containable');
	var $components = array('Session');
	var $badwordnotification = null;
	var $updatefld = null;
	var $badwords = array();
	
	/*_____________________________________________________________________________
    *	@Function:	beforeSave
    *	@Description: sanitized $this->data
    *	@param:	$filename
    *	@return: $filename
	*/
	function beforeSave(){
		$schemaData = $this->schema();		
		// get type of each field 
		$fieldType = array();
		$fieldName = array();
        $this->updatefld = '';
		foreach($schemaData as $key=>$data){         
			$fieldType[$key] = $data['type'];
			$fieldName[] = $key;
            
            $checkfield = array('status','is_active');
            if(in_array($key,$checkfield)){
                $this->updatefld = $key;
            }
		}
		$this->badwordnotification = 0;
		$this->badwords = array();
        
        App::import('Component', 'CommonComponent');
		$this->Common = new CommonComponent();
            
		foreach($this->data[$this->alias] as $key=>$value)
		{
			if(in_array($key,$fieldName)){
				if($fieldType[$key] == 'text' || $fieldType[$key] == 'string')
				{
					
					/*
					 $antispan = $this->Common->StripSearch($value);
					
					if($antispan){
						$this->badwordnotification = 1;
						$this->badwords[] = $antispan;  
					}
					*/
					$this->data[$this->alias][$key] = $value;
				}
				else{
					//$this->data[$this->alias][$key] = htmlentities($value);
				}
			}
			else
			continue;
		}		
		
		$pid = @$this->data[$this->alias]['id'];
		
		if(empty($pid)){
			$this->operation($pid);
		}
		
		return $this->data;
	}
	
	
	function afterSave(){
		$pid = @$this->data[$this->alias]['id'];
		if(empty($pid)){			
			$pid = $this->getInsertID();					
		}
		
		$this->operation($pid);
	}
	
	
	function operation($pid=null){
		
		App::import('Component','EmailComponent');
		$this->Email = new EmailComponent;
		
		App::import('Component', 'SessionComponent');
		$Session = new SessionComponent();
			
			
		//echo $this->badwordnotification; die;
		if($this->badwordnotification)
		{
			
			//___Import emailTemplate Model and get template                        
			App::import('Model','EmailTemplate');
			$this->EmailTemplate = new EmailTemplate;

			$siteUrl = Configure::read('siteUrl');
			$modelName = $this->alias;
			//$pid = $this->data[$this->alias]['id'];
			
			
			$uemail = CakeSession::read('Auth.User.email');			
			$uname = CakeSession::read('Auth.User.firstname');
			
			if($pid){			
				App::import('Model',$modelName);
				$this->$modelName = new $modelName;
				$this->$modelName->id=$pid;                    
				$this->$modelName->saveField($this->updatefld,0);
			}
			
			$template = $this->EmailTemplate ->find('first',array('conditions'=>array("EmailTemplate.slug"=>'bad-word'),'fields' =>array( 'EmailTemplate.description','EmailTemplate.title','EmailTemplate.subject')));
			
			$data=$template['EmailTemplate']['description'];
			
			
			$bdwds = array_unique($this->badwords);
			$bdwds = implode(',',$bdwds);
			$bwdcode = base64_encode($bdwds);
			$data=str_replace('{BADWORD}',$bdwds,$data);
			
			
			$customrd = array(
						   'Event'=> $siteUrl.'admin/events/view/'.$pid,
						   'Classified'=> $siteUrl.'admin/classifieds/view/'.$pid
						);
			
			$approved_rq=$siteUrl.'admin/admins/approvalonbadword/'.$modelName.'/'.$this->updatefld.'/'.$pid.'/'.$bwdcode.'/'.base64_encode($uemail);
			
			$cancel_rq=$siteUrl.'admin/admins/declinedbadword/'.$modelName.'/'.$this->updatefld.'/'.$pid.'/'.$bwdcode.'/'.base64_encode($uemail);
			
			
			
			$data=str_replace('{USER}',$uname,$data);
			
			
			
			
			$data=str_replace('{VIEW}',$customrd[$modelName],$data);
			$data=str_replace('{APPROVED}',$approved_rq,$data);
			$data=str_replace('{CANCEL}',$cancel_rq,$data);
			
			
			
			$this->Email->to = 'gyanp.sdei@gmail.com';
			$this->Email->from = 'gyanp.sdei@gmail.com';
			$this->Email->sendAs= 'html';
			$this->Email->subject = $template['EmailTemplate']['subject'];				
			$this->Email->htmlMessage = $data;              
			$this->Email->send($data);
			
			
			
			
			$Session->write('badwrdMsg','<div class="successMessage">Your content has been added successfully but due to badwords, it needs approval from administrator</div>');
			//$Session->write('badMsg','Your content has been added successfully but due to badwords, it needs approval from administrator');	
			
			unset($this->data[$modelName]['data']);                       
		}
		else
		{
			$Session->delete('badwrdMsg');
			$Session->delete('badMsg');
		}
		
	}
}
?>