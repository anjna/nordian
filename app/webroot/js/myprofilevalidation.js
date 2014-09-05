   // nickname
   // name
    $("#nickname_link").click(function () {
       $('#nickname_form').toggle();            
       if($('#nickname_form').is(':visible'))
       {
           $("#nickname_link").text('Hide');						
       }
       else
       {
           $("#nickname_link").text('Change');
       }
    });
    
    $("#account_status_link").click(function () {
       $('#accountstatus_form').toggle();            
       if($('#accountstatus_form').is(':visible'))
       {
           $("#account_status_link").text('Hide');						
       }
       else
       {
           $("#account_status_link").text('Change');
       }
    });
    
    
    $().ready(function()
    {
        jQuery.validator.addMethod("nicknameValidation", function(name, element) {                    
                //name = name.replace(/\s+/g, "");                    
                val = name.match(/^[a-zA-Z0-9]+$/i);
                result = (val) ? true : false;
                
                if(!result){
                  $("#nicknameopts").hide();
                  return result;
                }
                else{
                   var xhr = null;
            
                  /* if there is a previous ajax search, then we abort it and then set xhr to null */
                  if( xhr != null ) {
                          xhr.abort();
                          xhr = null;
                  }
                  
                  xhr = $.ajax({
                        type: "POST",
                        url: "/users/check_nickname/"+name,
                        data: $("#frmnickname").serialize(),
                        success: function(msg){                    
                            if(!msg){
                                return false;
                            }
                            $("#nicknameopts").html(msg);
                        }
                    });
                }
                return result;
        }, "Only alphabets,numbers are allowed");
        // validate signup form on keyup and submit
        $("#frmnickname").validate({
            rules: {							
                'data[User][nickname]': {
                        required: true,
                        nicknameValidation: true
                }
            },
            messages: {							           
                'data[User][nickname]': {
                        required: 'Please enter nickname',
                        nicknameValidation: 'Only alphabets,numbers are allowed for nickname'
                }
            }
        })            
    });
    
    $("#frmnickname").submit(function(){
        if($("#frmnickname").validate().form())
        {
            var xhr = null;
            
            /* if there is a previous ajax search, then we abort it and then set xhr to null */
            if( xhr != null ) {
                    xhr.abort();
                    xhr = null;
            }
            
            xhr = $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmnickname").serialize(),
                success: function(msg){                   
                    if(msg == 'false'){                        
                    }
                    else{
                     $('#nickname_form').hide();                    
                     $('#change_nickname').text(msg);                   
                     $("#nickname_link").text('Change');
                    }
                }                
            });
        }
       return false;
    });
    
    
    $("#frmaccountstatus").submit(function(){
        if($("#frmaccountstatus").validate().form())
        {
            var xhr = null;
            
            /* if there is a previous ajax search, then we abort it and then set xhr to null */
            if( xhr != null ) {
                    xhr.abort();
                    xhr = null;
            }
            
            xhr = $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmaccountstatus").serialize(),
                success: function(msg){                   
                    if(msg == 'false'){                        
                    }
                    else{
                     $('#accountstatus_form').hide();                   
                     $("#account_status_link").text('Change');
                    }
                    
                    if ( $('#UserIsVisible').is(':checked') ) {
                     $('#myaccountstatus').html('Active');
                    }
                    else {
                     $('#myaccountstatus').html('Temporarily Suspended');
                    }
                }                
            });
        }
       return false;
    });
    
    
    
    
    // name
    $("#name_link").click(function () {
       $('#name_form').toggle();            
       if($('#name_form').is(':visible'))
       {
           $("#name_link").text('Hide');						
       }
       else
       {
           $("#name_link").text('Change');
       }
    });
    
    $().ready(function()
    {
        jQuery.validator.addMethod("nameValidation", function(name, element) {                    
                name = name.replace(/\s+/g, "");                    
                val = name.match(/^[a-zA-Z '~]+$/i);
                result = (val) ? true : false;                   
                return result;                    
        }, "Only alphabets are allowed");
        // validate signup form on keyup and submit
        $("#frmname").validate({
            rules: {							
                'data[User][firstname]': {
                        required: true,
                        nameValidation: true
                },
                'data[User][lastname]': {
                        required : true,                           
                        nameValidation: true
                }  
            },
            messages: {							           
                'data[User][firstname]': {
                        required: 'Please enter firstname',
                        nameValidation: 'Only alphabets are allowed for firstname'
                },
                'data[User][lastname]': {
                        required : 'Please enter lastname',                           
                        nameValidation: 'Only alphabets are allowed for lastname'
                } 
            }
        })            
    });
    
    $("#frmname").submit(function(){
        if($("#frmname").validate().form())
        {            
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmname").serialize(),
                success: function(msg){                   
                    if(!msg){
                        return false;
                    }
                    $('#name_form').hide();
                    $('#change_name').text(msg);
                    $('.username').text(msg);
                    $("#name_link").text('Change');
                }                
            });
        }
       return false;
    });
    
    // picture
    $("#pic_link").click(function () {
       $('#pic_form').toggle();            
       if($('#pic_form').is(':visible'))
       {
           $("#pic_link").text('Hide');						
       }
       else
       {
           $("#pic_link").text('Change');
       }
    });
    
    $().ready(function()
    {
        jQuery.validator.addMethod("imageValidation", function(name, element) {
                var ext = name.split('.').pop().toLowerCase();                
                var allow = new Array('gif','png','jpg','jpeg');
                if(jQuery.inArray(ext, allow) == -1) {                    
                   return false;
                }
                else
                {                    
                    return true;
                }                   
        }, "gif,jpg,jpeg,png image only");
        
        // validate signup form on keyup and submit
        $("#frmpic").validate({
            rules: {							
                'data[User][pic]': {
                        required: true,
                        imageValidation: true
                }
            },
            messages: {							           
                'data[User][pic]': {
                        required: 'Please select image',
                        imageValidation: 'Please choose gif,jpg,jpeg,png image only.'
                } 
            }
        })            
    });
    
    
    // password				
    $("#password_link").click(function () {
       $('#password_form').toggle();            
       if($('#password_form').is(':visible'))
       {
           $("#password_link").text('Hide');						
       }
       else
       {
           $("#password_link").text('Change');
       }
    });
    
    $(document).ready(function()
    {
        /*
        $.validator.addMethod("check_password", function(value, element) {                    
                $.ajax({                        
                    cache :false,
                    async : false,
                    type: "POST",
                    url: "/users/check_password/"+value,                        
                    success: function(msg)
                    {                           
                        result = (parseInt(msg) == 1) ? true : false;
                    }
               });                    
                return result;                
          }, "Invalid old password");
        */
        
        // validate signup form on keyup and submit
        $("#frmpassword").validate({
            debug: true,
            rules: {
                /*
                'data[User][oldpassword]':
                {
                    required: true,                    
                    check_password: true
                },*/
                'data[User][newpassword]':
                {
                    required: true,
                    minlength: 6                         
                },
                'data[User][confirmpassword]':
                {
                    required: true,                        
                    equalTo: "#UserNewpassword"
                },
            },
            messages: {
                /*
                'data[User][oldpassword]':
                {
                    'required' : 'Please enter old password',                    
                    check_password : 'Invalid old password'
                },
                */
                'data[User][newpassword]':
                {
                    required: 'Please enter new password',
                    minlength: 'New password must consist of at least 6 characters'              
                },
                'data[User][confirmpassword]':
                {
                    required: 'Please enter confirm password',                        
                    equalTo: "Confirm password should be same the old password"
                },
            },
            onkeyup: false,
            onblur: true
        })            
    });
    
    $("#frmpassword").submit(function(){
        if($("#frmpassword").validate().form())
        { 
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmpassword").serialize(),
                success: function(msg){                    
                    if(!msg){
                        return false;
                    }
                    $('#password_form').hide();								
                    $("#password_link").text('Change');
                }                
            });
        }
        return false;
    });
    
    // email				
    $("#email_link").click(function () {
       $('#email_form').toggle();            
       if($('#email_form').is(':visible'))
       {
           $("#email_link").text('Hide');						
       }
       else
       {
           $("#email_link").text('Change');
       }
    });
    $().ready(function()
    {
        $.validator.addMethod("check_uniqueemail", function(value, element) {                    
                $.ajax({                        
                    cache :false,
                    async : false,
                    type: "POST",
                    url: "/users/check_uniqueemail/"+value,
                    
                    success: function(msg)
                    {
                     alert(msg);
                        result = (msg=='true') ? true : false;
                    }
               });
                return result;                
          }, "Email already exists.");
        
        // validate signup form on keyup and submit
        $("#frmemail").validate({
            debug: true,
            rules: {                    
                'data[User][email]':
                {
                    required: true,
                    email: true,
                    check_uniqueemail: true
                }
            },
            messages: {
                'data[User][email]':
                {
                    'required' : 'Please enter emailId',
                    'data[User][email]' : 'Please enter valid email',
                    check_uniqueemail : 'Email already exists.'
                }                    
            },
            onkeyup: false,
            onblur: true
        })            
    });
    
    $("#frmemail").submit(function(){
        if($("#frmemail").validate().form())
        { 
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmemail").serialize(),
                success: function(msg){                    
                    if(!msg){
                        return false;
                    }
                    $('#email_form').hide();								
                    $("#email_link").text('Change');
                }                
            });
        }
        return false;
    });
    
    // email				
    $("#bikes_link").click(function () {
       $('#bikes_form').toggle();            
       if($('#bikes_form').is(':visible'))
       {
           $("#bikes_link").text('Hide');						
       }
       else
       {
           $("#bikes_link").text('Change');
       }
   });
    
    
    $("#frmbikes").submit(function(){
        if($("#frmbikes").validate().form())
        { 
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmbikes").serialize(),
                success: function(msg){                    
                    if(msg == 'select'){
                        alert('New member will be able to input upto 3 bikes/makes.');
                        return false;
                    }
                    $('#bikes_form').hide();								
                    $("#bikes_link").text('Change');
                }                
            });
        }
        return false;
    });
    
    
    // region				
    $("#region_link").click(function () {
       $('#region_form').toggle();            
       if($('#region_form').is(':visible'))
       {
           $("#region_link").text('Hide');						
       }
       else
       {
           $("#region_link").text('Change');
       }
    });			
    
    $().ready(function()
    {					
        // validate signup form on keyup and submit
        $("#frmregion").validate({
            debug: true,
            rules: {                    
                'data[User][region_id]':
                {
                    required: true,								
                }
            },
            messages: {
                'data[User][region_id]':
                {
                    'required' : 'Please select region',
                }                    
            },
            onkeyup: false,
            onblur: true
        })            
    });
    
    $("#frmregion").submit(function(){
        if($("#frmregion").validate().form())
        { 
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmregion").serialize(),
                success: function(msg){                    
                    if(!msg){
                        return false;
                    }
                    $('#region_form').hide();
                    $('#change_region').text(msg);
                    $("#region_link").text('Change');
                }                
            });
        }
        return false;
    });
    
    // region				
    $("#country_link").click(function () {
       $('#country_form').toggle();            
       if($('#country_form').is(':visible'))
       {
           $("#country_link").text('Hide');						
       }
       else
       {
           $("#country_link").text('Change');
       }
    });	
    
     $().ready(function()
    {					
        // validate signup form on keyup and submit
        $("#frmcountry").validate({
            debug: true,
            rules: {                    
                'data[User][country_id]':
                {
                    required: true,								
                }
            },
            messages: {
                'data[User][country_id]':
                {
                    'required' : 'Please select country',
                }                    
            },
            onkeyup: false,
            onblur: true
        })            
    });
    
    $("#frmcountry").submit(function(){
        if($("#frmcountry").validate().form())
        { 
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmcountry").serialize(),
                success: function(msg){                    
                    if(!msg){
                        return false;
                    }                    
                    $('#country_form').hide();
                    $('#change_country').text(msg);
                    $("#country_link").text('Change');
                }                
            });
        }
        return false;
    });
    
    // address				
    $("#address_link").click(function () {
       $('#address_form').toggle();            
       if($('#address_form').is(':visible'))
       {
           $("#address_link").text('Hide');						
       }
       else
       {
           $("#address_link").text('Change');
       }
    });				
    
    $().ready(function()
    {
        // validate signup form on keyup and submit
        $("#frmaddress").validate({
            rules: {
                'data[User][address1]': "required",                    
                'data[User][city]': "required"
            },
            messages: {
                'data[User][address1]': "Location is required",                    
                'data[User][city]': "City is required"
            }
        })            
    });
    
     $("#frmaddress").submit(function(){
        if($("#frmaddress").validate().form())
        { 
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmaddress").serialize(),
                success: function(msg){                    
                    if(!msg){
                        return false;
                    }
                    $('#address_form').hide();
                    $('#change_address').text(msg);
                    $("#address_link").text('Change');
                }                
            });
        }
        return false;
    });
     
     
     
    // name
    $("#aboutme_link").click(function () {
       $('#aboutme_form').toggle();            
       if($('#aboutme_form').is(':visible'))
       {
           $("#aboutme_link").text('Hide');						
       }
       else
       {
           $("#aboutme_link").text('Change');
       }
    });
    
    $("#frmaboutme").submit(function(){
        if($("#frmaboutme").validate().form())
        {            
            $.ajax({
                type: "POST",
                url: "/users/myaccount_setting",
                data: $("#frmaboutme").serialize(),
                success: function(msg){                   
                    if(!msg){
                        return false;
                    }
                    $('#aboutme_form').hide();
                    $('#change_aboutme').text(msg);                   
                    $("#aboutme_link").text('Change');
                }                
            });
        }
       return false;
    }); 