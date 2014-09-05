	// JavaScript Document
		function isValidChar(objValue)
			{
					if(objValue.value!="")
					{
						  var  strError	="";	
						  var charpos = objValue.value.search("[^A-Za-z0-9 ]"); 
						  var At=objValue.value.charAt(0);
						  if(isNaN(objValue.value.charAt(0))==0)
						  {
							  
							  return false;
						  }
						  else if(objValue.value.length > 0 &&  charpos >= 0)  
						  {
								if(!strError || strError.length ==0) 
								{ 
									return false;
									  //strError ="Only alpha-numeric characters allowed !!"; 
								}//if 
								
								return false; 
						  }
					}
					return true;
				
			}
	
			function isValidZip(objValue)
			{
				if(objValue.value!="")
				{
					var  strError	="";	
					var charpos = objValue.value.search("[^A-Za-z0-9- ]"); 
					var At=objValue.value.charAt(0);
					if(isNaN(objValue.value.charAt(0))==0){
						return false;
					}
					else if(objValue.value.length > 0 &&  charpos >= 0){
						if(!strError || strError.length ==0){ 
							return false;
							//strError ="Only alpha-numeric characters allowed !!"; 
						}//if 
						return false; 
					}
				}
				return true;
			}
	
			function isInteger (s)
			{
			var i;
			if (isInteger.arguments.length == 1) return 0;
			else return (isInteger.arguments[1] == true);
			
			for (i = 0; i < s.length; i++)
			{
				var c = s.charAt(i);
			
				if (!isDigit(c)) return false;
			}
			
			return true;
			}
			
			function isProperText(objValue)
			{
				if(objValue.value!="")
				{
					var  strError	="";				
					var charpos = objValue.value.search("[^A-Za-z ]"); 
					if(objValue.value.length > 0 &&  charpos >= 0) 
					{ 
					  if(!strError || strError.length ==0) 
					{ 
					  strError = "Only alphabetic characters allowed !!"; 
					}//if                             
				 //   alert(strError + "\n ( Error character position " + eval(charpos+1)+")"); 
				
					return false; 
				  }//if
					
				}
				return true;
			}
			function isValidEmailFormat(objValue)
			{
				
				if(objValue.value!="")
				{
					var  strError	="";
					 if(!validateEmailv2(objValue.value)) 
					 { 
						 strError ="Enter a valid email address!! "; 
						
						 return false;
					}
	
				}
				return true;
			}
			
			function isDateMMDDYY(objValue)
			{
				if(objValue.value!="")
				{
					if (isDate(objValue.value)==false){
					
					return false
				}
	
					
				}
				return true;
			}
			
			function isDateDDMMYY(objValue)
			{
				if(objValue.value!="")
				{
					if (isDate2(objValue.value)==false)
					{
						
						return false			
					}
					
				}
				return true;
			}
			
			function isValidCellNo(objValue)
			{
				if(objValue.value!="")
				{
					var  strError	="";
					var charpos = objValue.value.search(/\d{3}\-\d{3}\-\d{4}/); 
				  
					  if(objValue.value.length > 0 &&  charpos ==-1) 
					 { 
						if(!strError || strError.length ==0) 
						{ 
						  strError = "Phone number you entered is not valid.\r\nPlease enter a phone number with the format xxx-xxx-xxxx."; 
						}
						
						return false; 
					 }//if 
				 
					
				}
				return true;
			}
		
			function isValidEmailFormat(email){
				
				if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value))
				{
					return (true);
				}
				return false;
			}
				
			
			
		function isValidEmailFormat_old(email)
		{
			if(email.length <= 0)
			{
			  return true;
			}
			
			var splitted = email.match("^(.+)@(.+)$");
			if(splitted == null) return false;
			
			if(splitted[1] != null )
			{
			 
				var regexp_user=/^\"?[\w-_\.]*\"?$/;
			  if(splitted[1].match(regexp_user) == null) return false;
			}
			if(splitted[2] != null)
			{
			  var regexp_domain=/^[\w-\.]*\.[A-Za-z]{2,4}$/;
			  if(splitted[2].match(regexp_domain) == null) 
			  {
				var regexp_ip =/^\[\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}\]$/;
				if(splitted[2].match(regexp_ip) == null) return false;
			  }// if
			  return true;
			}
				return false;
		}
	
	
	var dtCh= "/";
	var minYear=1900;
	var maxYear=2200;
	
	function isInteger2(s){
		var i;
		for (i = 0; i < s.length; i++){   
			// Check that current character is number.
			var c = s.charAt(i);
			if (((c < "0") || (c > "9"))) return false;
		}
		// All characters are numbers.
		return true;
	}
	
	function stripCharsInBag(s, bag){
		var i;
		var returnString = "";
		// Search through string's characters one by one.
		// If character is not in bag, append to returnString.
		for (i = 0; i < s.length; i++){   
			var c = s.charAt(i);
			if (bag.indexOf(c) == -1) returnString += c;
		}
		return returnString;
	}
	
	function daysInFebruary (year){
		// February has 29 days in any year evenly divisible by four,
		// EXCEPT for centurial years which are not also divisible by 400.
		return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
	}
	function DaysArray(n) {
		for (var i = 1; i <= n; i++) {
			this[i] = 31
			if (i==4 || i==6 || i==9 || i==11) {this[i] = 30}
			if (i==2) {this[i] = 29}
	   } 
	   return this
	}
	
	function isDate(dtStr)
	{
		var daysInMonth = DaysArray(12)
		var pos1=dtStr.indexOf(dtCh)
		var pos2=dtStr.indexOf(dtCh,pos1+1)
		var strMonth=dtStr.substring(0,pos1)
		var strDay=dtStr.substring(pos1+1,pos2)
		var strYear=dtStr.substring(pos2+1)
		strYr=strYear
		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
		for (var i = 1; i <= 3; i++) {
			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
		}
		month=parseInt(strMonth)
		day=parseInt(strDay)
		year=parseInt(strYr)
		if (pos1==-1 || pos2==-1){
			
			return false
		}
		if (strMonth.length<1 || month<1 || month>12){
			
			return false
		}
		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
			
			return false
		}
		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
			
			return false
		}
		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger2(stripCharsInBag(dtStr, dtCh))==false){
			
			return false
		}
	return true
	}
	
	
	
	
	function isDate2(dtStr)
	{
		var daysInMonth = DaysArray(12)
		var pos1=dtStr.indexOf(dtCh)
		var pos2=dtStr.indexOf(dtCh,pos1+1)
		var strMonth=dtStr.substring(pos1+1,pos2)
		var strDay=dtStr.substring(0,pos1)
		var strYear=dtStr.substring(pos2+1)
		strYr=strYear
		if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
		if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
		for (var i = 1; i <= 3; i++) {
			if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
		}
		month=parseInt(strMonth)
		day=parseInt(strDay)
		year=parseInt(strYr)
		if (pos1==-1 || pos2==-1){
			
			return false
		}
		if (strMonth.length<1 || month<1 || month>12){
			
			return false
		}
		if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
			
			return false
		}
		if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
			
			return false
		}
		if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger2(stripCharsInBag(dtStr, dtCh))==false){
		
			return false
		}
	return true
	}
	
	//FOR HIDE AND SHOW 
	function toggleSearch(whichLayer)
	{
		if (document.getElementById)
		{
		// this is the way the standards work
		var style2 = document.getElementById(whichLayer).style;
			
			if(style2.display == "block"){
				style2.display = "none";
			}else{
				style2.display = "block";
			}
		}
	}
	//COMPARE PASSWORDS FIELDS
	function chkPWD(first, second) {
		var el, msg = '';
			if (first.value == '' || /^\s+$/.test(first.value)) {
			msg = 'Please enter a password.';
			el = first;
			}
			else if (second.value == '' || /^\s+$/.test(second.value)) {
			msg = 'Please re-enter your password.';
			el = second;
			}
			else if (second.value != first.value) {
			msg = 'Please ensure that your password & confirmed password are the same.';
			el = second;
			}
			if (msg) {
			alert(msg);
			el.focus();
			el.select();
			return false;
			}
		return true;
	}
	
	//Check file extention
	
		//extArray = new Array(".jpg", ".png", ".bmp"); //example file extentions
		extArray = new Array(".csv");
		
		function limitAttach(file) {
			allowSubmit = false;
			file	= file.value;
			
			if (!file) return;
				while (file.indexOf("\\") != -1)
					file = file.slice(file.indexOf("\\") + 1);
					ext = file.slice(file.indexOf(".")).toLowerCase();
					
					for (var i = 0; i < extArray.length; i++) {
						if (extArray[i] == ext) { allowSubmit = true; break;
					}
				}
			if (allowSubmit) return true;
			else
			alert("Please only upload files that end in types:  "
			+ (extArray.join("  ")) + "\nPlease select a new "
			+ "file to upload and submit again.");
			return false;
		}
	// check valid website link 
	function isValidwebsite(website){
		if(/http:\/\/[w]{3}\.[A-Za-z0-9]+\.[A-Za-z]{2,3}/.test(website.value)){
		  return true;	
		}
		else{ 
			return false;
		}	
	}
	
	function goBack(val){
		window.location.href = val;
	}
	
	/** Change to delete image to red **/
	function changeToRedImage(obj){
		obj.src='/img/close-icon-active.png'; 
	}
	function changeToBlackImage(obj){
		obj.src='/img/close-icon-deactive.png';	
	}

    /*
	* Checked/Unchecked all check box
	*
	*  Arguments(..)
	*  id    => checkAll
	*  class =>  grid-checkbox
	*/
	$(function(){
		$("#checkAll").click(function (i,e) {
			checkAllOptions();
		});
		$(".grid-checkbox").click(function(){
			var totalCheckbox = 0;
			var checkedBox = 0;
			$("input[type=checkbox][class=grid-checkbox]").each(function(i,e) {
				totalCheckbox = totalCheckbox + 1;
				if($(this).is(':checked'))
				{
					checkedBox = checkedBox + 1;
				}
			});		
			if(totalCheckbox==checkedBox && checkedBox!=0){
				$('#checkAll').attr({checked:"checked"});
			}
			else{$('#checkAll').attr({checked:""});}
	
		})
	})
	
	function checkAllOptions()
	{	
		if($('#checkAll').attr("checked"))
		{	
			$("input[type=checkbox]").each(function(i,e) {
				$(this).attr({checked:"checked"});
			});
		}
		else
		{
			$("input[type=checkbox]").each(function(i,e) {
			   $(this).attr({checked:""});
			});
		}	
	}
	
	// activate and deactivate and also delete
    function isSelected(frm,field,actType,msg)
	{	
	  document.getElementById('submit').value=actType;
		var isAnySelected=false;	
		//if single row is exists
		if(field.value!=undefined){
			if(field.checked==true)
				isAnySelected=true;			
		}else{	
			for (i = 0; i < field.length; i++)
				if(field[i].checked ==true){			
					isAnySelected=true;
				}
			}
			if(isAnySelected==false){
			alert('Please select atleast one record');
			return false;
			}
			else if(actType=='del'){
			  if(!confirm(msg))
				return false;
			}
			else if(actType=='active'){
			  if(!confirm(msg))
				return false;
			}
			else if(actType=='inactive'){
			  if(!confirm(msg))
				return false;
			}
            else if(actType=='approve'){
			  if(!confirm(msg))
				return false;
			}
			else if(actType=='disapprove'){
			  if(!confirm(msg))
				return false;
			}
			else if(actType=='verify'){
			  if(!confirm(msg))
				return false;
			}
			else if(actType=='un-verify'){
			  if(!confirm(msg))
				return false;
			}
			
	}
	/*
	// get Hotel/flight/ferryboat/car drop down
	function getDetail(id)
	{
		var postUrl = '/packages/getAllDetails/'+id; 
		$.ajax({
		  cache:false,
		  async: false,
		  type: "GET",
		  url: postUrl,
		  success: function(msg){
				//alert(msg);
			  //result = (msg=='true') ? true : false;
				$('td #dropdownChanges').html(" ");
				$('td #dropdownChanges').html(msg);		  
//			  $('#changes').html(msg);
		  }
		});
	}
	*/
		function update_div(href,id){
                var dat='';
                
                day_view_link = $('a.session_date');
                
                $.each(day_view_link, function(key, value) {
                    
                    link_color = $(value).css('color');
                    
                    if(link_color=='rgb(221, 51, 56)'){
                        //alert(($(this).html()));
                        dat = $(this).html();
                    }
                    
                });
                
			    $.ajax({
                   type: "POST",
                   url: href+"/"+dat,
                   success: function(msg)
                   {
                        $('.dayview').html(msg);
                        
                        $('div.tabs li a').removeClass('selected');
                        
                        
                        $('div.tabs li a.'+id).addClass('selected');
                   }            
               });
		}

                //Function for dynamic theme
                function getCookie(c_name)
                {
                                var i,x,y,ARRcookies=document.cookie.split(";");
                                for (i=0;i<ARRcookies.length;i++)
                                {
                                                x=ARRcookies[i].substr(0,ARRcookies[i].indexOf("="));
                                                y=ARRcookies[i].substr(ARRcookies[i].indexOf("=")+1);
                                                x=x.replace(/^\s+|\s+$/g,"");
                                                if (x==c_name)
                                                {
                                                                return unescape(y);
                                                }
                                }
                }
                //Function for dynamic theme
                
                // Function for allow only numeric key press
                function getNumericKey(e){
                                key = e.charCode;
                                bk = 0;
                                
                                if(typeof(key)=="undefined"){
                                    key = e.keyCode;
                                    bk=8;
                                }
                                
                                if(key>47&&key<=57 || key==bk){
                                    
                                    return true;
                                }
                                else{
                                    return false;
                                }
                }// Function for allow only numeric key press
                
var Loading = {
        init:function(msg) {
                if ( msg == undefined) {
                   msg = 'Please wait while uploading...'
                }
                
                $('body').append('<div class="ajax_overlay"></div><span id="ajaxLoadingImage"><img src="/img/loadingAnimation.gif" alt="" /> <br /> '+msg+'</span>');
        },
        showLoading:function() {
                $('.ajax_overlay, #ajaxLoadingImage').show();
        },
        hideLoading:function() {
                $('.ajax_overlay, #ajaxLoadingImage').hide();
        }
}