<?php
class CommonHelper extends Helper
{
    var $helpers = array ('Session','Html'); 
	 /** 
	@function:		formatString
	@description:		display the string
	@params:		NULL
	@Created by: 		
	@Modify:		NULL
	@Created Date:		
	*/	
	function formatString($string = '',$start = 0, $end = 30){

		$string = trim($string);		
		return substr($string,$start,$end);
	}
	
	/**	
	* return paging variable
	* @param $paging length
	* @return $string: length
	*/
	
	function display_items_per_page($options,$args = array())
	 {
		$url_here = $this->here;
		
		if(!empty($args))
		{
			$name_arg = array();
			foreach($this->params['named'] as $key => $named){
				$name_arg[] = $key;
			}
			
			$params = array();
			foreach($args as $key => $arg){
				if(in_array($key,$name_arg)){
					continue;
				}
				$params[] = $key.':'.$arg;
			}
			
			$url_here = $url_here.'/'.join('/',$params);
		}
		
		$url = Router::url($url_here, true);
		$ipp_array = explode(',',$options);		 
		$sessionVal = @$_SESSION['limit'];		 		
		$selectedVal = isset($this->params['url']['ipp']) ? $this->params['url']['ipp'] : (empty($sessionVal) ? $ipp_array[0] : $sessionVal);		 
		$items = '';		 
		foreach($ipp_array as $ipp_opt)
		{		   
		 $selected = $ipp_opt == $selectedVal ? 'selected' : '';		 
		 $items .= "<option $selected  value=\"$ipp_opt\">$ipp_opt</option>\n";
		}		
		return "<select class=\"paginate\" onchange=\"window.location='$url&ipp='+this[this.selectedIndex].value;return false\">$items</select>\n";	 
	}
	
	
	function doPages($page_size, $thepage, $query_string, $total=0)
	{
		//per page count
		$index_limit = $page_size;
	
		//set the query string to blank, then later attach it with $query_string
		$query='';
	
		if(strlen($query_string)>0){
			$query = "&".$query_string;
		}
	
		//get the current page number example: 3, 4 etc: see above method description
		$current = $this->get_current_page();
	
		$total_pages=ceil($total/$page_size);
		$start=max($current-intval($index_limit/2), 1);
		$end=$start+$index_limit-1;
	
		echo '<div class="paging">';
	
		if($current==1)
		{
			echo '<span class="prn">&nbsp;Previous&nbsp;</span> ';
		}
		else
		{
			$i = $current-1;
			echo "<a class='prn' title='go to page $i' rel='nofollow' href='$thepage?page= $i'>&nbsp;Previous&nbsp;</a>";
			echo "<span class='prn'></span>";
		}
		
		if($start > 1)
		{
			$i = 1;
			echo "<a title='go to page $i' href='$thepage?page= $i'>&nbsp;$i&nbsp;</a>";
		}
	
		for ($i = $start; $i <= $end && $i <= $total_pages; $i++){
			if($i==$current) {
				echo "<span>$i</span>";
			} else {
				echo "<a title='go to page $i' href='$thepage?page= $i'>&nbsp;$i&nbsp;</a>";
			}
		}
	
		if($total_pages > $end){
			$i = $total_pages;
			echo "<a title='go to page $i' href='$thepage?page= $i'>&nbsp;$i&nbsp;</a>";
		}
	
		if($current < $total_pages) {
			$i = $current+1;
			echo "<span class='prn'>...</span>";
			echo "<a class='prn' title='go to page $i' rel='nofollow' href='$thepage?page= $i'>&nbsp;Next&nbsp;</a>";			
		} else {
			echo "<span class='prn'>&nbsp;Next&nbsp;</span>";
		}
	
		//if nothing passed to method or zero, then dont print result, else print the total count below:
		if ($total != 0){
			//prints the total result count just below the paging
			echo '(total '.$total.' results)</div>';
		}	
	}//end of method doPages()

	//Both of the functions below required
	
	function check_integer($which) {
		if(isset($_REQUEST[$which])){
			if (intval($_REQUEST[$which])>0) {
				//check the paging variable was set or not,
				//if yes then return its number:
				//for example: ?page=5, then it will return 5 (integer)
				return intval($_REQUEST[$which]);
			} else {
				return false;
			}
		}
		return false;
	}//end of check_integer()

	function get_current_page() {
		if(($var=$this->check_integer('page'))) {
			//return value of 'page', in support to above method
			return $var;
		} else {
			//return 1, if it wasnt set before, page=1
			return 1;
		}
	}//end of method get_current_page()
        
		/** Get Formated Date
	   * @param 
	   * @access public
	   */
	   function getFormatDate($date=null,$format='d/m/Y')
	   {
		   return date($format,strtotime($date));
	   }
	   
	   function getFormatTime($date=null,$format='H : i : s , A')
	   {
		   return date($format,strtotime($date));
	   }
	
	/** Get readmore
	* @param $text, $url,$length 
	* @access public
	*/
	public function readmore($title, $url,$length,$text)
    	{
	    // Use the HTML helper to output
	    // formatted data:
	    $link = "";
		    
	    $textlength = strlen(strip_tags($text));		
	    $link = substr(strip_tags($text),0,$length);
	    if($textlength > $length)
	    {
		$link .= "&nbsp;&nbsp".$this->Html->link($title,$url);
	    }        
	    return $link;
	}
	
	/** Get shortname
	* @param $text,$length 
	* @access public
	*/
	public function shortword($text,$length)
    {
	    $textlength = strlen(strip_tags($text));
	    $shorttext = substr(strip_tags($text),0,$length);
		
		if($textlength > $length)
	    {
			$text = $shorttext."..";
	    }        
	    return $text;
	}
	
	public function get_video_time($video='') {
		
		App::import('Component', 'VideoEncoder');
		$VideoEncoder = new VideoEncoderComponent();
		
		return $VideoEncoder->get_duration($video);
		
	}
	
	public function getBannerPages() {
		
		$pages = array(
			"classifieds" 		=> "Classifieds",
			"events" 			=> "Events",
			"groups" 			=> "Groups",
			"jobs" 				=> "Industry Jobs",
			"users" 			=> "My Channel",
			"news" 				=> "News",
			"racings" 			=> "Racing",
			"super_channels" 	=> "Super Channels",
			"trackdays" 		=> "Trackdays"
		);
		
		return $pages;
		
	}
	
}
?>