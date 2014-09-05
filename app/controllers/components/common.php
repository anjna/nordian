<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of common
 *
 * @author abhishekga
 */
class CommonComponent extends Object {

    var $name = "Common";
    var $components =array('Email'); 

    function startup(&$controller) {
         $this->controller = &$controller; 
    }
    
    /*
    *_____________________________________________________________________________
    *@Function:	is_valid_email
    *@Description:	check is email valid or not
    *@param:	email
    *@return:	true/false
    *______________________________________________________________________________
    */	
    function is_valid_email($email) {
        $result = TRUE;
        if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
            $result = FALSE;
        }
        return $result;
    }
    
    /*
    *_____________________________________________________________________________
    *@Function:	get_enc_cardnumber
    *@Description:	Return card number with last four digits only
    *@param:	card number
    *@return:	last four digit card number
    *______________________________________________________________________________
    */	
    function get_enc_cardnumber($cardnumber) {
        $len=strlen($cardnumber);
        $stlen=$len-4;
        $subStr=substr($cardnumber,$stlen,$len);
        return str_pad($subStr,$len, "X", STR_PAD_LEFT);
    }
    
    function StripSearch($var)
    {
            App::import('Model','Badword');
            $this->Badword = new Badword;
            $antispamarray = $this->Badword->find('list',array('fields'=>array('Badword.id','Badword.word')));
           
            $flgg=0;
            $pattern[0]='/\"/';
            $pattern[1]='/\(/';
            $pattern[2]='/\)/';
            $pattern[3]='/\{/';
            $pattern[4]='/\}/';
            $pattern[5]='/\[/';
            $pattern[6]='/\]/';
            $pattern[7]='/\-/';
            $pattern[8]='/\\//';
            $pattern[9]='/\\\/';
            $pattern[10]='/\^/';
            $pattern[1]='/\?/';
            $pattern[12]='/\_/';
            $pattern[13]='/\|/';
            $pattern[14]='/\*/';
            $pattern[15]='/\=/';
            $pattern[16]='/\n/';
            $pattern[17]='/\./';
            $resultAfterStrip = "";
            foreach($pattern as $pattern1)
            {    
                if(preg_match($pattern1,$var))
                {
                    if($resultAfterStrip == "")
                    {
                        $resultAfterStrip=preg_replace($pattern1,' ',$var);
                    }
                    else
                    {
                        $resultAfterStrip=preg_replace($pattern1,' ',$resultAfterStrip);
                    }    
                }
            }
            
            
            if(empty($resultAfterStrip))
            {
                $resultAfterStrip=$var;
            }
            $resultAfterStrip=' '.$resultAfterStrip.' ';
			
			$antispm = "";
            foreach($antispamarray as $antispam)
            {
                $antispam1="/\b".$antispam."\b/i";
                $resultAfterStrip1=preg_match($antispam1,$resultAfterStrip);    
                if ($resultAfterStrip1 == 0)
                {    
                }
                else
                {
                    $flgg=2;
					$antispm = $antispam;
                }    
            }			
			
            if($flgg)
            return $antispm;
            else
            return false;
    }
	
	function getCountriesList() {
		
		App::import('Model', 'Country');
		$this->Country = & new Country();
		
		$this->Country->recursive = 1;
		
		$countries = $this->Country->find('all', array('order' => 'Country.name ASC', 'contain' => false) );
		
		$countries_list = array();
		
		foreach ($countries as $country) {
			$countries_list[$country['Country']['id']] = $country['Country']['name'];	
		}
		
		return $countries_list;
		
	}
	
	function uploadVideo($videoArray = array(), $path="") {
		
		$vidName = "";
		$duration = "";
		$thumbName = "";
		if(!empty($videoArray['name']))
		{
			$file_ext = end(explode('.',$videoArray['name']));
			$file_ext = strtolower($file_ext);
			if($file_ext=='mov' || $file_ext=='avi' || $file_ext=='wmv' || $file_ext=='dat' || $file_ext=='mpeg' || $file_ext=='mpg' || $file_ext=='flv' || $file_ext=='mp4' || $file_ext=='mp2')
			{
				$this->Uploader->_data = $this->data['Myvideo'];
				if($this->data)
				{
					//echo WWW_ROOT.'videos/'; die;
					$this->data['Myvideo']['video_size'] = $videoArray['size'];
					$videoArray='';
					$this->Myvideo->set($this->data);
					$path_video=WWW_ROOT."myvideos/";
					$path_thumb=WWW_ROOT."myvideos/thumb/";
					$vidName = "Video_".time()."_".rand(0,999999).".".$file_ext;
					$filename_video=$path_video.$vidName;
					
					$this->Uploader->uploadDir = "/myvideos/";
					if(strtolower($file_ext) !='flv'){
						$vidName = "reply_vid_".time()."_".rand(0,999999).".flv";
						$fileName = $vidName;
						//convert the video to flv format if it is any other
						$in = WWW_ROOT.'myvideos/'.$fileName;
						$filename_video=$path_video.$vidName;	
						$this->VideoEncoder->convert_video($in,$filename_video, 480, 360);
						$this->VideoEncoder->set_buffering($filename_video);
					}						 
					$video_data =  $this->Uploader->upload('video', array('name'=>$vidName,'overwrite' => false,'resize' => true));

					#calculate the duration
					$thumbName = "Video_".time()."_".rand(0,999999).".jpg";
					$filename_thumb=$path_thumb.$thumbName;
											//pr($video_data); die;
					$this->VideoEncoder->grab_image($filename_video, $filename_thumb);
											/*--- Calculate Video file duration start -----------   */
					$bitrate = 128; //in kbps
					$duration = $this->VideoEncoder->get_duration($filename_video,$bitrate);
					/*--- Calculate video file duration End -----------   */
					//$this->data['Video']['id'] = $video_id;
					
					$videoArray=$vidName;
					$this->data['Myvideo']['video_duration']=$duration;
					$this->data['Myvideo']['user_id']=$userid;
					//$this->data['Video']['filesize']=$filesize;
					$this->data['Myvideo']['video_thumb'] = $thumbName;
				}
			}
			else
			{
				$this->Video->validationErrors['video'] = 'Invalid Type';
				unset($videoArray);
			}
		}
		
	}
	
	
	function getControllersList() {
		$all_controllers = $this->_getControllers();
		//pr($all_controllers);exit;
		
		$returnControllers = array();
		
		foreach ($all_controllers as $class => $actions) {
			
			$actionCounts = 0;
			$allowedActions = array();
			foreach ($actions as $action) {
				if ( substr($action,0, 6) != "admin_" ) {
					continue;
				}
				$allowedActions[] = $action;
				$actionCounts++;
			}
			
			if ( !empty($allowedActions) ) {
				$returnControllers[$class] = $allowedActions;
			}
			
		}
	
		return $returnControllers;
	}
	
	function _getControllers($controller = null)
	{
		$controllers = array();
		$conf = Configure::getInstance();
 
		$paths      = $conf->controllerPaths;
		$plugPaths  = $conf->pluginPaths;
		$pluglist   = Configure::listObjects('plugin');
		
		if ( !empty($plugPaths) && is_array($plugPaths) ) {
			
			foreach($plugPaths as $l)
			{
				foreach($pluglist as $v)
				$paths[] = $l.inflector::underscore($v).DS.'controllers';
			}	
			
		}
		
		
 
		if(!$controller)
		{
			$pluglist = array_merge(array(''), $pluglist);
			$controllerList = Configure::listObjects('controller', $paths, false);
 
			foreach($controllerList as $file)
			$controllers[$file] = $this->_getControllerMethods($file, $pluglist);
		}
		else
		{
			$controllers[$controller] = $this->_getControllerMethods($controller, $pluglist);
		}
 
		return $controllers;
	}
 
   
	function _getControllerMethods($controllerName, $plugins)
	{
		$classMethodsCleaned = array();
		$found = false;
 
		foreach($plugins as $plugin)
		{
			if(App::import('Controller', empty($plugin) ? $controllerName : $plugin.'.'.$controllerName))
			{
				$found = true;
				break;
			}
		}
 
		if(!$found) return array();
 
		$parentClassMethods = get_class_methods(get_parent_class(Inflector::camelize($controllerName).'Controller'));
		$subClassMethods    = get_class_methods(Inflector::camelize($controllerName).'Controller');
		$classMethods       = array_diff($subClassMethods, $parentClassMethods);
 
		foreach($classMethods as $method)
		{
			if($method{0} <> "_")
			{
				$classMethodsCleaned[] = $method;
			}
		}
		
		return $classMethodsCleaned;
	}
		
	
    
}
?>