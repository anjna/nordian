function validateForm(form, rules) {
  //clear out any old errors
  jQuery("#jsErrors").html("");
  jQuery("#jsErrors").slideUp();
  jQuery(".error-message").hide();
  
  //loop through the validation rules and check for errors
  jQuery.each(rules, function(field) {
    var val = jQuery.trim(jQuery("#" + field).val());
    var storageVar;
    var pwd = 0;
    jQuery.each(this, function() {
      //console.log(this['rule']);
      
      //check if the input exists
      if (jQuery("#" + field).attr("id") != undefined) {
        var valid = true;
        id = jQuery("#" + field).attr("id");
        
        // check password ################# Custom validation ########################
        if(id == 'UserPassword' && $('#UserRetypepassword').val() && $('#UserPassword').val()!='' && pwd == 0)
        {
            if($('#UserPassword').val() != $('#UserRetypepassword').val())
            {
                pwd = 1;
                jQuery("#jsErrors").append("<li>Password does not matched with Retypepassword</li>");
            }
        }
        // ################################# End of validation ########################3
        
        if (this['allowEmpty'] && val == '') {
          //do nothing
        } else if (this['rule'].match(/^range/)) {
          var range = this['rule'].split('|');
          if (val < parseInt(range[1])) {
            valid = false;
          }
          if (val > parseInt(range[2])) {
            valid = false;
          }
        } else if (this['negate']) {
          if (val.match(eval(this['rule']))) {
            valid = false;
          }
        } else if (!val.match(eval(this['rule']))) {
          valid = false;
        }
        /*if(!val.match(eval(this['rule']))){
          alert("rule not matched");
        }else{
          alert("rule matched"+this['message']);
        }*/
        if (!valid) {
        //alert(this['message']);
           if(id==storageVar)
           {return;}
          //add the error message
          jQuery("#jsErrors").append("<li>" + this['message'] + "</li>");
          storageVar = id;
          //highlight the label
          //jQuery("label[for='" + field + "']").addClass("error");
          jQuery("#" + field).parent().addClass("error");
        }
      }
    });
  });
 
  if(jQuery("#jsErrors").html() != "") {
   // validCaptcha();
    var data = jQuery("#jsErrors").html();
    var temp = "<article class='wrong-email'><img src='/img/icon_wrong-email.png' width='22' height='22' alt=''> <div class='error'><ul>"+data+"</ul></div></article>";
    jQuery("#jsErrors").empty();
    jQuery("#jsErrors").append(temp); 
    jQuery("#jsErrors").wrapInner("<div class='errors'></div>");
    jQuery("#jsErrors").slideDown();
    jQuery(".failureMessage").hide();
    jQuery(".successMessage").hide();
    
    $('html, body').animate( { scrollTop: 155 }, '0');   
    return false;
  }
  return true;
}


  function validCaptcha()
  {
      if($('#recaptcha_response_field').val()=='')
      {		   
          jQuery("#jsErrors").append("<li>Please enter valid key for word verification..</li>");		
      }		
  }
