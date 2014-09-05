<?php
/** 
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * This is a placeholder class.
 * Create the same file in app/app_controller.php
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @link http://book.cakephp.org/view/957/The-App-Controller
 */
class AppController extends Controller {
    
    // include component	
    //var $components = array('Auth','Cookie','RequestHandler','Session','Common','Badword','PhpBB3','Facebook.Connect', 'Thumb','File');
    //var $components = array('Auth','Cookie','RequestHandler','Session','Common','Badword','Facebook.Connect', 'Thumb','File');
    //var $PasswordPhBB3 = null;
    //var $helpers = array('Common','Facebook.Facebook');
    
    var $components = array('Auth','Cookie','RequestHandler','Session','Common','Thumb','File','VideoEncoder', 'Uploader.Uploader');
    //var $components = array('Auth','Cookie','RequestHandler','Session','Common','Badword','Facebook.Connect', 'Thumb','File');
    //var $PasswordPhBB3 = null;
    var $helpers = array('Common','Encrypt');
    
    // access by object 
    function beforeFilter()
    {
		
		
        //echo 'here'; die;
        $this->__checkAuth();
        
		// we have classifieds expirie after 20 days, after the 20 day period these will dissapear from the system
		
		$this->sSecretKey = '29xdVi33L5W32SL2';
        $this->set('sSecretKey',$this->sSecretKey);
		
		//echo $this->_fnEncrypt('neelam kumari', $this->sSecretKey);
		
        $user_id = $this->Auth->user('id');
		
		$user_type = $this->Auth->user('type');
		
		$this->set('utype',$user_type);
		
		$_SESSION['userid'] = $user_id;
        $this->set('user_id',$user_id);
		$this->set('visitor_userid',$user_id);
        
        $controller = $this->params['controller'];            
        $this->set('controller',$controller);
        
        $action = $this->params['action'];            
        $this->set('action',$action);
        
		
        
        // get jump page array
        $this->set('dropdown_val',$this->get_setting('dropdown-paging'));
		//echo 'here'; die;
        // get paging length
        $this->paging_length = $this->get_setting('paging-length');
        // self url
        $this->set('self_url',$this->here);
        
        $this->PATH_PROFILE = Configure::read('PATH_PROFILE');
		$this->PATH_RACING = Configure::read('PATH_RACING');
		
		

		$siteurl = Configure::read('siteUrl');
		$this->set('siteurl',$siteurl);

		
        //$this->paging_length = $this->pagging_length();
		$this->set('paging_length',$this->paging_length);
		
		
		
    }
    
	function isAuthorized() {
		return true;
	}
		
		
    /*
    *_____________________________________________________________________________
    *@Function:	__authCheck
    *@Description:	check panel Admin/User
    *@param:	None
    *@return:	none
    *______________________________________________________________________________
    */	
    function __checkAuth()
    {        
        // Setup the field for auth
        if(!empty($this->params['admin']))
        {
            $this->admin_panel();
            $this->Auth->userModel = 'Admin';
                  $this->Auth->fields = array(
                     'username' => 'email',
                     'password' => 'password'
                );
                $this->Auth->loginAction = array(
                      'controller' => 'admins',
                      'action'     => 'login',
                      'admin'=> true
                );
                $this->Auth->loginRedirect = array(
                    'controller' => 'admins',
                    'action' => 'dashboard',
                    'admin'=> true
                );
                // Where the auth will redirect user after logout
                $this->Auth->logoutRedirect = array(
                      'controller' => 'admins',
                      'action'     => 'login',
                      'admin'=> true
                );
				$this->Auth->autoRedirect = false;
        }
        else
        {
               /*
			   $this->Auth->userModel = 'User';
                $this->Auth->userScope = array('User.is_active'=>'1');
                $this->Auth->userScope = array('User.is_verified'=>'1');	
                $this->Auth->fields = array(
                    'username' => 'email',
                    'password' => 'password'
                );
                $this->Auth->loginAction = array(
                    'controller' => 'users',
                    'action' => 'login'
                );
                //$this->Auth->loginRedirect = array('controller' => 'users', 'action' => 'login');
                $this->Auth->loginRedirect = array(
                    'controller' => 'users',
                    'action' => 'dashboard'
                );
                $this->Auth->logoutRedirect = array(
                   'controller' => 'users',
                    'action' => 'login'
                );
				
				$this->Auth->autoRedirect = false;
				*/
        }
		
    }
	
	
	/**
	 * AES 128 Encryption
	**/
	function _fnEncrypt($sValue, $sSecretKey)
	{
		return rtrim(
			base64_encode(
				mcrypt_encrypt(
					MCRYPT_RIJNDAEL_128,
					$sSecretKey, $sValue, 
					MCRYPT_MODE_ECB, 
					mcrypt_create_iv(
						mcrypt_get_iv_size(
							MCRYPT_RIJNDAEL_128, 
							MCRYPT_MODE_ECB
						), 
					MCRYPT_RAND)
				)
			), "\0"
		);
	}
	
	
	/**
	 * AES 128 Decryption
	**/
	function _fnDecrypt($sValue, $sSecretKey)
	{
		return rtrim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_128, 
				$sSecretKey, 
				base64_decode($sValue), 
				MCRYPT_MODE_ECB,
				mcrypt_create_iv(
					mcrypt_get_iv_size(
						MCRYPT_RIJNDAEL_128,
						MCRYPT_MODE_ECB
					), 
					MCRYPT_RAND
				)
			), "\0"
		);
	}
    
    
    /**			
    * set admin panel
    * @param none
    * @return $string: none
    */
    
    function admin_panel(){
        
        // initial right panel and top menu            
        $panel = array(
                        'SME\'s' => array(
                            'Listing' => array(
                                'controller' => 'admins','action' => 'index'
                                ,'args'=>array('class'=>'group','display'=>array('admins'))
                            ),
                            'class'=>'user'
                        )
						
						,
                        'Course Management' => array(
							'Listing' => array(
								'controller' => 'topics','action' => 'index'
								,'args'=>array('class'=>'manage_page','display'=>array('email_templates'))
							),
							'class'=>'folder_table'                               
						)
						
						,
                        'Subject Management' => array(
							'Listing' => array(
								'controller' => 'subjects','action' => 'index'
								,'args'=>array('class'=>'manage_page','display'=>array('email_templates'))
							),
							'class'=>'folder_table'                               
						)
						,
                        'Chapter Management' => array(
							'Listing' => array(
								'controller' => 'chapters','action' => 'index'
								,'args'=>array('class'=>'manage_page','display'=>array('email_templates'))
							),
							'class'=>'folder_table'                               
						)
						,
						 'Summary Management' => array(
							'Listing' => array(
								'controller' => 'summaries','action' => 'index'
								,'args'=>array('class'=>'manage_page','display'=>array('email_templates'))
							),
							'class'=>'folder_table'                               
						)
						,
                        'ChapterQuestion Management' => array(
							'Listing' => array(
								'controller' => 'chapter_questions','action' => 'index'
								,'args'=>array('class'=>'manage_page','display'=>array('email_templates'))
							),
							'class'=>'folder_table'                               
						)
                        ,
                        'Settings' => array(
                            'Listing' => array(
                                    'controller' => 'settings','action' => 'index'
                                    ,'args'=>array('class'=>'manage_page','display'=>array('settings'))
                            ),
                            'class'=>'manage'                             
						)
						,
                        'Email Templates' => array(
							'Listing' => array(
								'controller' => 'email_templates','action' => 'index'
								,'args'=>array('class'=>'manage_page','display'=>array('email_templates'))
							),
							'class'=>'folder_table'                               
						)
						,
                        'Logout' => array(
							'Logout' => array(
								'controller' => 'admins','action' => 'logout'
								,'args'=>array('class'=>'logout','display'=>array('logout'))
							),
                            'class'=>'folder_table'                               
						),
                    );
        $this->set('panel',$panel);
    }
    
    /**	
    * get setting variable value	
    * @param $slug
    * @return $string: setting value	
    */
    public function get_setting($slug=null) {
        App::import('Model','Setting');
        $this->Setting = new Setting;
        $setting = $this->Setting->find('first',array('conditions'=>array('Setting.slug'=>$slug)));
        return $setting['Setting']['value'];
    }
			
    /**	
	* get pagin length	
	* @param $slug
	* @return $string: paging length
	*/
   
	function pagging_length($default=500)
	{
       //Configure::write('debug',2);
		$limit = $this->paging_length;
		//$change_limit = $limit;
		if($this->Session->read('limit')){ // if session is set                
			$limit = $this->Session->read('limit');
			if(isset($this->params['url']['ipp']) && $limit != $this->params['url']['ipp']){                    
               $this->Session->write('limit',$this->params['url']['ipp']);
               $limit = $this->params['url']['ipp'];            
			}
        }
		else if(isset($this->params['url']['ipp'])){    // if data is set
			$this->Session->write('limit',$this->params['url']['ipp']);
			$limit = $this->params['url']['ipp'];
		}
		else{ // if you call first time page
			$this->Session->write('limit',$limit);
			//$limit = $change_limit;
		}
       
		// only for all            
		if((isset($this->params['url']['ipp']) && $this->params['url']['ipp'] == 'All') || $limit == 'All'){                
			$limit = $default;
		}
       
		return $limit;
	}
   
    /*_____________________________________________________________________________
    *	@Function:	uploadImage
    *	@Description: uploading images
    *	@param:		None
    *	@return:        
    *  
    */	
    function uploadImage($imgArr,$tumbarray,$path='profile', $prefix=true)
    {
        // _INITALIZATION
        $imageType = $imgArr['type'];
        $imageTypeArr = explode('/',$imageType);
        $validImage = $this->File->validateImage($imageTypeArr[1]);
        $uploadImg = array();
        if($validImage == true){
            if($path=='profile'){
                $this->File->destPath =  WWW_ROOT.$this->PATH_PROFILE;
            }else if($path=='gallery'){
                $this->File->destPath =  WWW_ROOT.GALLERY_PATH;
            } else if($path=='racing'){
			$this->File->destPath =  WWW_ROOT.$this->PATH_RACING;
			}else if($path=='circuit'){
			$this->File->destPath =  WWW_ROOT.'img/circuit';
			}else if($path=='image'){
			$this->File->destPath =  WWW_ROOT.'img/reports/images';
			}else if($path=='rider'){
			$this->File->destPath =  WWW_ROOT.'img/riderImage';
			}else if($path=='riderflag'){
			$this->File->destPath =  WWW_ROOT.'img/riderflagImage';
			}
			else if($path=='classifiedimage'){
			$this->File->destPath =  WWW_ROOT.'img/classifiedimage';
			}
			else if($path=='groups'){
			$this->File->destPath =  WWW_ROOT.'img/groups';
			}
			else {
                $this->File->destPath =  WWW_ROOT.$this->PATH_DEAL;
            }
            
            
            $extDot = explode(".",$imgArr['name']);
			$ext = $extDot[count($extDot)-1];
            $fileName = time()."_".$this->File->clean_string(substr($imgArr['name'],0,strlen($imgArr['name'])-(strlen($ext) + 1))).".".$ext;
            
            //$fileName = time()."_".substr($imgArr['name'],0,-4).'.jpg';
            
            
            $this->File->setFilename($fileName);
            
			/*if(count($tumbarray)>0){
                foreach($tumbarray as $thumbarr){
                    $folder=$thumbarr['folder'];
                    $mime ='';
                    $file = $fileName;
                    $size=array($thumbarr['w'],$thumbarr['h']);
                    $result = $this->Upload->upload($imgArr, $this->File->destPath.'/'.$folder.'/','img_'.$thumbarr['w'].'_'.$thumbarr['h'].'_'.$file, array('type' => 'resize', 'size' => $size, 'output' => 'jpg'));
                }
            }*/
            
			$file = $this->File->uploadFile($imgArr['name'],$imgArr['tmp_name']);

			if($file) {
				
				foreach($tumbarray as $thumbarr){
                    
					$folder=$thumbarr['folder'];
                    $mime ='';
                    
					$size=array($thumbarr['w'],$thumbarr['h']);
					/*
                    $result = $this->Upload->upload(
						$imgArr,
						$this->File->destPath.'/'.$folder.'/',
						'img_'.$thumbarr['w'].'_'.$thumbarr['h'].'_'.$file,
						array('type' => 'resize', 'size' => $size, 'output' => 'jpg')
					);*/
					
					$fileSize = getimagesize($this->File->destPath.'/'.$file);
					
					$mime='';
					
					if ( $prefix ) {
						
						//@copy($this->File->destPath.'/'.$file , $this->File->destPath.'/'.$folder.'/'.'img_'.$thumbarr['w'].'_'.$thumbarr['h'].'_'.$file);
						@copy($this->File->destPath.'/'.$file , $this->File->destPath.'/'.$folder.'/'.'img_'.$thumbarr['h'].'_'.$thumbarr['h'].'_'.$file);
						//$this->Thumb->getResized('img_'.$thumbarr['w'].'_'.$thumbarr['h'].'_'.$file, $mime, $this->File->destPath.'/'.$folder.'/', $thumbarr['w'], $thumbarr['h'], 'FFFFFF', true, true, $this->File->destPath.'/'.$folder.'/', false);
					        $this->Thumb->getResized('img_'.$thumbarr['h'].'_'.$thumbarr['h'].'_'.$file, $mime, $this->File->destPath.'/'.$folder.'/', $thumbarr['w'], $thumbarr['h'], 'FFFFFF', true, true, $this->File->destPath.'/'.$folder.'/', false);
					}
					else {
						
						@copy($this->File->destPath.'/'.$file , $this->File->destPath.'/'.$folder.'/'.$file);
						
						$this->Thumb->getResized($file, $mime, $this->File->destPath.'/'.$folder.'/', $thumbarr['w'], $thumbarr['h'], 'FFFFFF', true, true, $this->File->destPath.'/'.$folder.'/', false);
						
					}

                }
				
			//	exit;
				
			}
//pr($uploadImg);die;
            $uploadImg[0]=1;
            $uploadImg[1]=$fileName;
            return $uploadImg;
        }
        else{
            $uploadImg[0]=0;
            $uploadImg[1]="Please select a valid image type";
            return $uploadImg;
        }
    }
    
    /*_____________________________________________________________________________
    *	@Function:	checkImage
    *	@Description: validate images
    *	@param:		None
    *	@return:        
    */	
    function checkImage($imgArr)
    {
        // _INITALIZATION
        $imageType = $imgArr['type'];
        $imageTypeArr = explode('/',$imageType);
        $validImage = $this->File->validateImage($imageTypeArr[1]);
        
        
        if($validImage == true){
            $uploadImg[0]=1;
            return $uploadImg;
        }
        else{
            $uploadImg[0]=0;
            $uploadImg[1]="Please select a valid image type";
            return $uploadImg;
        }
    }
    
    /**	
    * Generate random string of given length	
    * @param $length
    * @return $string: Random string	
    */
    public static function get_random_string($length = 15) {
        $string = '';
        for ($x = 1; $x <= $length; $x++) {
            switch ( rand(1, 3) ) {
                //  Add a random digit, 0-9
                case 1:
                    $string .= rand(0, 9);
                    break;
                //  Add a random upper-case letter
                case 2:
                    $string .= chr( rand(65, 90) );
                    break;
                //  Add a random lower-case letter
                case 3:
                    $string  .= chr( rand(97, 122) );
                    break;
                }
        }  
        return $string;
    }
	
	
	function RandNumber($e)
	{	
		for($i=0;$i<$e;$i++){
		$rand =  $rand .  rand(0, 9); 
		}
		return $rand;   
	}
		
  //function to send mail
    function sendMail($to,$subject,$message){      

  	$name = 'B2TMeeting';
    	/* load CakePHP Email component */
    	App::uses('CakeEmail', 'Network/Email');
    	/* instantiate CakeEmail class */
    	$Email = new CakeEmail(); 
	$top = '<!DOCTYPE HTML>
    	<html>
    	<head>
    	<meta charset="utf-8">
    	</head>
    	<body style="margin:0;padding:0;">
    	<div style="width:600px;margin:0 auto;">
    	<div>';
    	$low='<p style="line-height: 1.2em;">Regards,</p>
    	<p style="line-height: 1.2em;">Nordian</p>
    	</div>
    	</div>
    	</body>
    	</html>';
	$to =$to;
   	$message=$top.'<p>'.$message.'</p>'.$low;
    	$Email = new CakeEmail();
    	$this->layout=false;
    	$Email->emailFormat('html');
    	$Email->template = 'confirm';
    	$Email->from(array(FROMEMAIL => 'Nordian'));
    	$Email->to($to);
    	$Email->subject($subject);
    	$Email->send($message);
    	return true;
    }
	
	
	
}
