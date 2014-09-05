$(document).ready(function(){
    var passForgot = $("#pass-forgot");
    var fancyLoginWrapper = $("#fancy-login-wrapper");
    var fancyLoginWrapperForgot = $("#fancy-login-forgot-wrapper");
    var fancyLoginASubscribeExpand = $("#fancy-login-subscribe-expand");
    var fancyLoginSubscribeWrapper = $("#fancy-login-subscribe-wrapper");
    var alreadyMember = $("#already-member");
    var notMemberYet = $("#not-member-yet");
    var searchAdvanced = $(".search-advanced");
    var mobileStuffWrapper = $(".mobile-stuff-wrapper");
    var defaultWrapper = $(".default-wrapper");
    var mobileStuffToggle = $('#mobile-stuff-toggle');
    var mobilePhonestoggle = $('#mobile-phones-toggle');
    var fancyCompany = $("#fancy-company");
    var backtoLogin = $("#back-to-login");
    var expandSearchAdvanced = $('#expand-search-advanced');
    $("a#login-pop").fancybox({
        'transitionOut':'none',
        'transitionIn':'none',
        'scrolling':'no',
        'centerOnScroll':true,
        'padding':0
    });
    passForgot.click(function(e) {
        fancyLoginWrapper.fadeToggle('fast', function() {
            fancyLoginWrapperForgot.fadeToggle("fast")
            });
        e.preventDefault();
    });
    backtoLogin.click(function(e) {
        fancyLoginWrapperForgot.fadeToggle('fast', function() {
            fancyLoginWrapper.fadeToggle("fast");
            });
        e.preventDefault();
    });
    notMemberYet.click(function(e) {
        if(fancyLoginWrapper.is(":visible")) {
            fancyLoginWrapper.fadeOut('fast', function() {
                fancyLoginASubscribeExpand.slideDown("fast");
                fancyLoginSubscribeWrapper.fadeIn("fast");
                })
        } else {
            fancyLoginWrapperForgot.fadeOut('fast', function() {
                fancyLoginASubscribeExpand.slideDown("fast");
                fancyLoginSubscribeWrapper.fadeIn("fast");
                })
        }
        notMemberYet.fadeOut('fast', function() {
            alreadyMember.fadeIn('fast');
            });
        fancyCompany.show();
        e.preventDefault();
    });
    alreadyMember.click(function(e) {
        fancyLoginSubscribeWrapper.fadeOut('fast', function() {
            fancyLoginASubscribeExpand.slideUp("fast");
            fancyLoginWrapper.fadeIn("fast");
            });
        alreadyMember.fadeToggle('fast', function() {
            notMemberYet.fadeToggle('fast');
            });
        fancyCompany.hide();
        e.preventDefault();
    });
    $('#register-trigger').click(function(e) {
        $('#login-pop').click();
        fancyLoginWrapper.hide();
        fancyLoginWrapperForgot.hide();
        fancyLoginASubscribeExpand.show();
        fancyLoginSubscribeWrapper.show();
        notMemberYet.hide();
        alreadyMember.show();
        fancyCompany.show();
        e.preventDefault();
    });
    $('#login-pop').click(function (e) {
        fancyLoginWrapper.show();
        fancyLoginWrapperForgot.hide();
        fancyLoginASubscribeExpand.hide();
        fancyLoginSubscribeWrapper.hide();
        notMemberYet.show();
        alreadyMember.hide();
        fancyCompany.hide();
        e.preventDefault();
    });
    expandSearchAdvanced.click(function(e) {
        searchAdvanced.slideToggle();
        e.preventDefault();
    });
    mobileStuffToggle.click(function(e) {
        searchAdvanced.slideUp("fast", function() {
            defaultWrapper.fadeToggle('fast', function() {
                mobileStuffWrapper.fadeToggle("fast");
                })
            });
        e.preventDefault();
    });
    mobilePhonestoggle.click(function(e) {
        searchAdvanced.slideUp("fast", function() {
            mobileStuffWrapper.fadeToggle('fast', function() {
                defaultWrapper.fadeToggle("fast");
                })
            });
        e.preventDefault();
    });
    $(".sub").click(function(){
        if($(this).attr("id") == "with-subscription") {
            $(".with-without-subscription .jqTransformSelectWrapper").show();
        } else {
            $(".with-without-subscription .jqTransformSelectWrapper").hide();
        }
    });
    if($("#with-subscription").attr("checked")) {
        $(".with-without-subscription .jqTransformSelectWrapper").show();
    }
    $("form.jqtransform").jqTransform();
    $('input.form-text').placeholder();
});

function addEvent(element,eventType,lamdaFunction,useCapture){
    if(element.addEventListener){
        element.addEventListener(eventType,lamdaFunction,useCapture);
        return true
        }else if(element.attachEvent){
        var r=element.attachEvent('on'+eventType,lamdaFunction);
        return r
        }else{
        return false
        }
    }
function knackerEvent(eventObject){
    if(eventObject&&eventObject.stopPropagation){
        eventObject.stopPropagation()
        }
        if(window.event&&window.event.cancelBubble){
        window.event.cancelBubble=true
        }
        if(eventObject&&eventObject.preventDefault){
        eventObject.preventDefault()
        }
        if(window.event){
        window.event.returnValue=false
        }
    }
function cancelEventSafari(){
    return false
    }
    function getElementStyle(elementID,CssStyleProperty){
    var element=document.getElementById(elementID);
    if(element.currentStyle){
        return element.currentStyle[toCamelCase(CssStyleProperty)]
        }else if(window.getComputedStyle){
        var compStyle=window.getComputedStyle(element,'');
        return compStyle.getPropertyValue(CssStyleProperty)
        }else{
        return''
        }
    }
function toCamelCase(CssProperty){
    var stringArray=CssProperty.toLowerCase().split('-');
    if(stringArray.length==1){
        return stringArray[0]
        }
        var ret=(CssProperty.indexOf("-")==0)?stringArray[0].charAt(0).toUpperCase()+stringArray[0].substring(1):stringArray[0];
    for(var i=1;i<stringArray.length;i++){
        var s=stringArray[i];
        ret+=s.charAt(0).toUpperCase()+s.substring(1)
        }
        return ret
    }
    function disableTestLinks(){
    var pageLinks=document.getElementsByTagName('a');
    for(var i=0;i<pageLinks.length;i++){
        if(pageLinks[i].href.match(/[^#]#$/)){
            addEvent(pageLinks[i],'click',knackerEvent,false)
            }
        }
    }
function createCookie(name,value,days){
    var expires='';
    if(days){
        var date=new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires='; expires='+date.toGMTString()
        }
        document.cookie=name+'='+value+expires+'; path=/'
    }
    function readCookie(name){
    var cookieCrumbs=document.cookie.split(';');
    var nameToFind=name+'=';
    for(var i=0;i<cookieCrumbs.length;i++){
        var crumb=cookieCrumbs[i];
        while(crumb.charAt(0)==' '){
            crumb=crumb.substring(1,crumb.length)
            }
            if(crumb.indexOf(nameToFind)==0){
            return crumb.substring(nameToFind.length,crumb.length)
            }
        }
    return null
}
function eraseCookie(name){
    createCookie(name,'',-1)
    }
    addEvent(window,'load',init,false);
function init(){
    var formInputs=document.getElementsByTagName('input');
    for(var i=0;i<formInputs.length;i++){
        var theInput=formInputs[i];
        if(theInput.type=='text'&&theInput.className.match(/\bcleardefault\b/)){
            addEvent(theInput,'focus',clearDefaultText,false);
            addEvent(theInput,'blur',replaceDefaultText,false);
            if(theInput.value!=''){
                theInput.defaultText=theInput.value
                }
            }
    }
}
function clearDefaultText(e){
    var target=window.event?window.event.srcElement:e?e.target:null;
    if(!target)return;
    if(target.value==target.defaultText){
        target.value=''
        }
    }
function replaceDefaultText(e){
    var target=window.event?window.event.srcElement:e?e.target:null;
    if(!target)return;
    if(target.value==''&&target.defaultText){
        target.value=target.defaultText
        }
    }(function($){
    var defaultOptions={
        preloadImg:true
    };

    var jqTransformImgPreloaded=false;
    var jqTransformPreloadHoverFocusImg=function(strImgUrl){
        strImgUrl=strImgUrl.replace(/^url\((.*)\)/,'$1').replace(/^\"(.*)\"$/,'$1');
        var imgHover=new Image();
        imgHover.src=strImgUrl.replace(/\.([a-zA-Z]*)$/,'-hover.$1');
        var imgFocus=new Image();
        imgFocus.src=strImgUrl.replace(/\.([a-zA-Z]*)$/,'-focus.$1')
        };

    var jqTransformGetLabel=function(objfield){
        var selfForm=$(objfield.get(0).form);
        var oLabel=objfield.next();
        if(!oLabel.is('label')){
            oLabel=objfield.prev();
            if(oLabel.is('label')){
                var inputname=objfield.attr('id');
                if(inputname){
                    oLabel=selfForm.find('label[for="'+inputname+'"]')
                    }
                }
        }
    if(oLabel.is('label')){
    return oLabel.css('cursor','pointer')
    }
    return false
};

var jqTransformHideSelect=function(oTarget){
    var ulVisible=$('.jqTransformSelectWrapper ul:visible');
    ulVisible.each(function(){
        var oSelect=$(this).parents(".jqTransformSelectWrapper:first").find("select").get(0);
        if(!(oTarget&&oSelect.oLabel&&oSelect.oLabel.get(0)==oTarget.get(0))){
            $(this).hide()
            }
        })
};

var jqTransformCheckExternalClick=function(event){
    if($(event.target).parents('.jqTransformSelectWrapper').length===0){
        jqTransformHideSelect($(event.target))
        }
    };

var jqTransformAddDocumentListener=function(){
    $(document).mousedown(jqTransformCheckExternalClick)
    };

var jqTransformReset=function(f){
    var sel;
    $('.jqTransformSelectWrapper select',f).each(function(){
        sel=(this.selectedIndex<0)?0:this.selectedIndex;
        $('ul',$(this).parent()).each(function(){
            $('a:eq('+sel+')',this).click()
            })
        });
    $('a.jqTransformCheckbox, a.jqTransformRadio',f).removeClass('jqTransformChecked');
    $('input:checkbox, input:radio',f).each(function(){
        if(this.checked){
            $('a',$(this).parent()).addClass('jqTransformChecked')
            }
        })
};

$.fn.jqTransInputButton=function(){};

$.fn.jqTransInputText=function(){};

$.fn.jqTransCheckBox=function(){
    return this.each(function(){
        if($(this).hasClass('jqTransformHidden')){
            return
        }
        var $input=$(this);
        var inputSelf=this;
        var oLabel=jqTransformGetLabel($input);
        oLabel&&oLabel.click(function(){
            aLink.trigger('click')
            });
        var aLink=$('<a href="#" class="jqTransformCheckbox"></a>');
        $input.addClass('jqTransformHidden').wrap('<span class="jqTransformCheckboxWrapper"></span>').parent().prepend(aLink);
        $input.change(function(){
            this.checked&&aLink.addClass('jqTransformChecked')||aLink.removeClass('jqTransformChecked');
            return true
            });
        aLink.click(function(){
            if($input.attr('disabled')){
                return false
                }
                $input.trigger('click').trigger("change");
            return false
            });
        this.checked&&aLink.addClass('jqTransformChecked')
        })
    };

$.fn.jqTransRadio=function(){
    return this.each(function(){
        if($(this).hasClass('jqTransformHidden')){
            return
        }
        var $input=$(this);
        var inputSelf=this;
        oLabel=jqTransformGetLabel($input);
        oLabel&&oLabel.click(function(){
            aLink.trigger('click')
            });
        var aLink=$('<a href="#" class="jqTransformRadio" rel="'+this.name+'"></a>');
        $input.addClass('jqTransformHidden').wrap('<span class="jqTransformRadioWrapper"></span>').parent().prepend(aLink);
        $input.change(function(){
            inputSelf.checked&&aLink.addClass('jqTransformChecked')||aLink.removeClass('jqTransformChecked');
            return true
            });
        aLink.click(function(){
            if($input.attr('disabled')){
                return false
                }
                $input.trigger('click').trigger('change');
            $('input[name="'+$input.attr('name')+'"]',inputSelf.form).not($input).each(function(){
                $(this).attr('type')=='radio'&&$(this).trigger('change')
                });
            return false
            });
        inputSelf.checked&&aLink.addClass('jqTransformChecked')
        })
    };

$.fn.jqTransTextarea=function(){
    return this.each(function(){
        var textarea=$(this);
        if(textarea.hasClass('jqtransformdone')){
            return
        }
        textarea.addClass('jqtransformdone');
        oLabel=jqTransformGetLabel(textarea);
        oLabel&&oLabel.click(function(){
            textarea.focus()
            });
        var strTable='<table cellspacing="0" cellpadding="0" border="0" class="jqTransformTextarea">';
        strTable+='<tr><td id="jqTransformTextarea-tl"></td><td id="jqTransformTextarea-tm"></td><td id="jqTransformTextarea-tr"></td></tr>';
        strTable+='<tr><td id="jqTransformTextarea-ml">&nbsp;</td><td id="jqTransformTextarea-mm"><div></div></td><td id="jqTransformTextarea-mr">&nbsp;</td></tr>';
        strTable+='<tr><td id="jqTransformTextarea-bl"></td><td id="jqTransformTextarea-bm"></td><td id="jqTransformTextarea-br"></td></tr>';
        strTable+='</table>';
        var oTable=$(strTable).insertAfter(textarea).hover(function(){
            !oTable.hasClass('jqTransformTextarea-focus')&&oTable.addClass('jqTransformTextarea-hover')
            },function(){
            oTable.removeClass('jqTransformTextarea-hover')
            });
        textarea.focus(function(){
            oTable.removeClass('jqTransformTextarea-hover').addClass('jqTransformTextarea-focus')
            }).blur(function(){
            oTable.removeClass('jqTransformTextarea-focus')
            }).appendTo($('#jqTransformTextarea-mm div',oTable));
        this.oTable=oTable;
        if($.browser.safari){
            $('#jqTransformTextarea-mm',oTable).addClass('jqTransformSafariTextarea').find('div').css('height',textarea.height()).css('width',textarea.width())
            }
        })
};

$.fn.jqTransSelect=function(){
    return this.each(function(index){
        var $select=$(this);
        if($select.hasClass('jqTransformHidden')){
            return
        }
        if($select.attr('multiple')){
            return
        }
        var oLabel=jqTransformGetLabel($select);
        var $wrapper=$select.addClass('jqTransformHidden').wrap('<div class="jqTransformSelectWrapper"></div>').parent().css({
            zIndex:10-index
            });
        $wrapper.prepend('<div><span></span><a href="#" class="jqTransformSelectOpen"></a></div><ul></ul>');
        var $ul=$('ul',$wrapper).css('width',$select.width()).hide();
        $('option',this).each(function(i){
            var oLi=$('<li><a href="#" index="'+i+'">'+$(this).html()+'</a></li>');
            $ul.append(oLi)
            });
        $ul.find('a').click(function(){
            $('a.selected',$wrapper).removeClass('selected');
            $(this).addClass('selected');
            if($select[0].selectedIndex!=$(this).attr('index')&&$select[0].onchange){
                $select[0].selectedIndex=$(this).attr('index');
                $select[0].onchange()
                }
                $select[0].selectedIndex=$(this).attr('index');
            $('span:eq(0)',$wrapper).html($(this).html());
            $ul.hide();
            return false
            });
        $('a:eq('+this.selectedIndex+')',$ul).click();
        $('span:first',$wrapper).click(function(){
            $("a.jqTransformSelectOpen",$wrapper).trigger('click')
            });
        oLabel&&oLabel.click(function(){
            $("a.jqTransformSelectOpen",$wrapper).trigger('click')
            });
        this.oLabel=oLabel;
        var oLinkOpen=$('a.jqTransformSelectOpen',$wrapper).click(function(){
            if($ul.css('display')=='none'){
                jqTransformHideSelect()
                }
                if($select.attr('disabled')){
                return false
                }
                $ul.slideToggle('fast',function(){
                var offSet=($('a.selected',$ul).offset().top-$ul.offset().top);
                $ul.animate({
                    scrollTop:offSet
                })
                });
            return false
            });
        var iSelectWidth=$select.outerWidth();
        var oSpan=$('span:first',$wrapper);
        var newWidth=(iSelectWidth>oSpan.innerWidth())?iSelectWidth+oLinkOpen.outerWidth():$wrapper.width();
        $wrapper.css('width',newWidth);
        $ul.css('width',newWidth-2);
        oSpan.css({
            width:iSelectWidth
        });
        $ul.css({
            display:'block',
            visibility:'hidden'
        });
        var iSelectHeight=($('li',$ul).length)*($('li:first',$ul).height());
        (iSelectHeight<$ul.height())&&$ul.css({
            height:iSelectHeight,
            'overflow':'hidden'
        });
        $ul.css({
            display:'none',
            visibility:'visible'
        })
        })
    };

$.fn.jqTransform=function(options){
    var opt=$.extend({},defaultOptions,options);
    return this.each(function(){
        var selfForm=$(this);
        if(selfForm.hasClass('jqtransformdone')){
            return
        }
        selfForm.addClass('jqtransformdone');
        $('input:submit, input:reset, input[type="button"]',this).jqTransInputButton();
        $('input:text, input:password',this).jqTransInputText();
        $('input:checkbox',this).jqTransCheckBox();
        $('input:radio',this).jqTransRadio();
        $('textarea',this).jqTransTextarea();
        if($('select',this).jqTransSelect().length>0){
            jqTransformAddDocumentListener()
            }
            selfForm.bind('reset',function(){
            var action=function(){
                jqTransformReset(this)
                };

            window.setTimeout(action,10)
            })
        })
    }
})(jQuery);
(function(b){
    var m,t,u,f,D,j,E,n,z,A,q=0,e={},o=[],p=0,d={},l=[],G=null,v=new Image,J=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,W=/[^\.]\.(swf)\s*$/i,K,L=1,y=0,s="",r,i,h=false,B=b.extend(b("<div/>")[0],{
        prop:0
    }),M=b.browser.msie&&b.browser.version<7&&!window.XMLHttpRequest,N=function(){
        t.hide();
        v.onerror=v.onload=null;
        G&&G.abort();
        m.empty()
        },O=function(){
        if(false===e.onError(o,q,e)){
            t.hide();
            h=false
            }else{
            e.titleShow=false;
            e.width="auto";
            e.height="auto";
            m.html('<p id="fancybox-error">The requested content cannot be loaded.<br />Please try again later.</p>');
            F()
            }
        },I=function(){
    var a=o[q],c,g,k,C,P,w;
    N();
    e=b.extend({},b.fn.fancybox.defaults,typeof b(a).data("fancybox")=="undefined"?e:b(a).data("fancybox"));
    w=e.onStart(o,q,e);
    if(w===false)h=false;
    else{
        if(typeof w=="object")e=b.extend(e,w);
        k=e.title||(a.nodeName?b(a).attr("title"):a.title)||"";
        if(a.nodeName&&!e.orig)e.orig=b(a).children("img:first").length?b(a).children("img:first"):b(a);
        if(k===""&&e.orig&&e.titleFromAlt)k=e.orig.attr("alt");
        c=e.href||(a.nodeName?b(a).attr("href"):a.href)||null;
        if(/^(?:javascript)/i.test(c)||c=="#")c=null;
        if(e.type){
            g=e.type;
            if(!c)c=e.content
                }else if(e.content)g="html";
        else if(c)g=c.match(J)?"image":c.match(W)?"swf":b(a).hasClass("iframe")?"iframe":c.indexOf("#")===0?"inline":"ajax";
        if(g){
            if(g=="inline"){
                a=c.substr(c.indexOf("#"));
                g=b(a).length>0?"inline":"ajax"
                }
                e.type=g;
            e.href=c;
            e.title=k;
            if(e.autoDimensions)if(e.type=="html"||e.type=="inline"||e.type=="ajax"){
                e.width="auto";
                e.height="auto"
                }else e.autoDimensions=false;
            if(e.modal){
                e.overlayShow=true;
                e.hideOnOverlayClick=false;
                e.hideOnContentClick=false;
                e.enableEscapeButton=false;
                e.showCloseButton=false
                }
                e.padding=parseInt(e.padding,10);
            e.margin=parseInt(e.margin,10);
            m.css("padding",e.padding+e.margin);
            b(".fancybox-inline-tmp").unbind("fancybox-cancel").bind("fancybox-change",function(){
                b(this).replaceWith(j.children())
                });
            switch(g){
                case"html":
                    m.html(e.content);
                    F();
                    break;
                case"inline":
                    if(b(a).parent().is("#fancybox-content")===true){
                    h=false;
                    break
                }
                b('<div class="fancybox-inline-tmp" />').hide().insertBefore(b(a)).bind("fancybox-cleanup",function(){
                    b(this).replaceWith(j.children())
                    }).bind("fancybox-cancel",function(){
                    b(this).replaceWith(m.children())
                    });
                b(a).appendTo(m);
                    F();
                    break;
                case"image":
                    h=false;
                    b.fancybox.showActivity();
                    v=new Image;
                    v.onerror=function(){
                    O()
                    };

                v.onload=function(){
                    h=true;
                    v.onerror=v.onload=null;
                    e.width=v.width;
                    e.height=v.height;
                    b("<img />").attr({
                        id:"fancybox-img",
                        src:v.src,
                        alt:e.title
                        }).appendTo(m);
                    Q()
                    };

                v.src=c;
                break;
                case"swf":
                    e.scrolling="no";
                    C='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+e.width+'" height="'+e.height+'"><param name="movie" value="'+c+'"></param>';
                    P="";
                    b.each(e.swf,function(x,H){
                    C+='<param name="'+x+'" value="'+H+'"></param>';
                    P+=" "+x+'="'+H+'"'
                    });
                C+='<embed src="'+c+'" type="application/x-shockwave-flash" width="'+e.width+'" height="'+e.height+'"'+P+"></embed></object>";
                m.html(C);
                    F();
                    break;
                case"ajax":
                    h=false;
                    b.fancybox.showActivity();
                    e.ajax.win=e.ajax.success;
                    G=b.ajax(b.extend({},e.ajax,{
                    url:c,
                    data:e.ajax.data||{},
                    error:function(x){
                        x.status>0&&O()
                        },
                    success:function(x,H,R){
                        if((typeof R=="object"?R:G).status==200){
                            if(typeof e.ajax.win=="function"){
                                w=e.ajax.win(c,x,H,R);
                                if(w===false){
                                    t.hide();
                                    return
                                }else if(typeof w=="string"||typeof w=="object")x=w
                                    }
                                    m.html(x);
                            F()
                            }
                        }
                }));
            break;
        case"iframe":
            Q()
            }
        }else O()
    }
},F=function(){
    var a=e.width,c=e.height;
    a=a.toString().indexOf("%")>-1?parseInt((b(window).width()-e.margin*2)*parseFloat(a)/100,10)+"px":a=="auto"?"auto":a+"px";
    c=c.toString().indexOf("%")>-1?parseInt((b(window).height()-e.margin*2)*parseFloat(c)/100,10)+"px":c=="auto"?"auto":c+"px";
    m.wrapInner('<div style="width:'+a+";height:"+c+";overflow: "+(e.scrolling=="auto"?"auto":e.scrolling=="yes"?"scroll":"hidden")+';position:relative;"></div>');
    e.width=m.width();
    e.height=m.height();
    Q()
    },Q=function(){
    var a,c;
    t.hide();
    if(f.is(":visible")&&false===d.onCleanup(l,p,d)){
        b.event.trigger("fancybox-cancel");
        h=false
        }else{
        h=true;
        b(j.add(u)).unbind();
        b(window).unbind("resize.fb scroll.fb");
        b(document).unbind("keydown.fb");
        f.is(":visible")&&d.titlePosition!=="outside"&&f.css("height",f.height());
        l=o;
        p=q;
        d=e;
        if(d.overlayShow){
            u.css({
                "background-color":d.overlayColor,
                opacity:d.overlayOpacity,
                cursor:d.hideOnOverlayClick?"pointer":"auto",
                height:b(document).height()
                });
            if(!u.is(":visible")){
                M&&b("select:not(#fancybox-tmp select)").filter(function(){
                    return this.style.visibility!=="hidden"
                    }).css({
                    visibility:"hidden"
                }).one("fancybox-cleanup",function(){
                    this.style.visibility="inherit"
                    });
                u.show()
                }
            }else u.hide();
    i=X();
    s=d.title||"";
    y=0;
    n.empty().removeAttr("style").removeClass();
    if(d.titleShow!==false){
        if(b.isFunction(d.titleFormat))a=d.titleFormat(s,l,p,d);else a=s&&s.length?d.titlePosition=="float"?'<table id="fancybox-title-float-wrap" cellpadding="0" cellspacing="0"><tr><td id="fancybox-title-float-left"></td><td id="fancybox-title-float-main">'+s+'</td><td id="fancybox-title-float-right"></td></tr></table>':'<div id="fancybox-title-'+d.titlePosition+'">'+s+"</div>":false;
        s=a;
        if(!(!s||s==="")){
            n.addClass("fancybox-title-"+d.titlePosition).html(s).appendTo("body").show();
            switch(d.titlePosition){
                case"inside":
                    n.css({
                    width:i.width-d.padding*2,
                    marginLeft:d.padding,
                    marginRight:d.padding
                    });
                y=n.outerHeight(true);
                    n.appendTo(D);
                    i.height+=y;
                    break;
                case"over":
                    n.css({
                    marginLeft:d.padding,
                    width:i.width-d.padding*2,
                    bottom:d.padding
                    }).appendTo(D);
                    break;
                case"float":
                    n.css("left",parseInt((n.width()-i.width-40)/2,10)*-1).appendTo(f);
                    break;
                default:
                    n.css({
                    width:i.width-d.padding*2,
                    paddingLeft:d.padding,
                    paddingRight:d.padding
                    }).appendTo(f)
                    }
                }
    }
n.hide();
if(f.is(":visible")){
    b(E.add(z).add(A)).hide();
    a=f.position();
    r={
        top:a.top,
        left:a.left,
        width:f.width(),
        height:f.height()
        };

    c=r.width==i.width&&r.height==i.height;
    j.fadeTo(d.changeFade,0.3,function(){
        var g=function(){
            j.html(m.contents()).fadeTo(d.changeFade,1,S)
            };

        b.event.trigger("fancybox-change");
        j.empty().removeAttr("filter").css({
            "border-width":d.padding,
            width:i.width-d.padding*2,
            height:e.autoDimensions?"auto":i.height-y-d.padding*2
            });
        if(c)g();
        else{
            B.prop=0;
            b(B).animate({
                prop:1
            },{
                duration:d.changeSpeed,
                easing:d.easingChange,
                step:T,
                complete:g
            })
            }
        })
}else{
    f.removeAttr("style");
    j.css("border-width",d.padding);
    if(d.transitionIn=="elastic"){
        r=V();
        j.html(m.contents());
        f.show();
        if(d.opacity)i.opacity=0;
        B.prop=0;
        b(B).animate({
            prop:1
        },{
            duration:d.speedIn,
            easing:d.easingIn,
            step:T,
            complete:S
        })
        }else{
        d.titlePosition=="inside"&&y>0&&n.show();
        j.css({
            width:i.width-d.padding*2,
            height:e.autoDimensions?"auto":i.height-y-d.padding*2
            }).html(m.contents());
        f.css(i).fadeIn(d.transitionIn=="none"?0:d.speedIn,S)
        }
    }
}
},Y=function(){
    if(d.enableEscapeButton||d.enableKeyboardNav)b(document).bind("keydown.fb",function(a){
        if(a.keyCode==27&&d.enableEscapeButton){
            a.preventDefault();
            b.fancybox.close()
            }else if((a.keyCode==37||a.keyCode==39)&&d.enableKeyboardNav&&a.target.tagName!=="INPUT"&&a.target.tagName!=="TEXTAREA"&&a.target.tagName!=="SELECT"){
            a.preventDefault();
            b.fancybox[a.keyCode==37?"prev":"next"]()
            }
        });
if(d.showNavArrows){
    if(d.cyclic&&l.length>1||p!==0)z.show();
    if(d.cyclic&&l.length>1||p!=l.length-1)A.show()
        }else{
    z.hide();
    A.hide()
    }
},S=function(){
    if(!b.support.opacity){
        j.get(0).style.removeAttribute("filter");
        f.get(0).style.removeAttribute("filter")
        }
        e.autoDimensions&&j.css("height","auto");
    f.css("height","auto");
    s&&s.length&&n.show();
    d.showCloseButton&&E.show();
    Y();
    d.hideOnContentClick&&j.bind("click",b.fancybox.close);
    d.hideOnOverlayClick&&u.bind("click",b.fancybox.close);
    b(window).bind("resize.fb",b.fancybox.resize);
    d.centerOnScroll&&b(window).bind("scroll.fb",b.fancybox.center);
    if(d.type=="iframe")b('<iframe id="fancybox-frame" name="fancybox-frame'+(new Date).getTime()+'" frameborder="0" hspace="0" '+(b.browser.msie?'allowtransparency="true""':"")+' scrolling="'+e.scrolling+'" src="'+d.href+'"></iframe>').appendTo(j);
    f.show();
    h=false;
    b.fancybox.center();
    d.onComplete(l,p,d);
    var a,c;
    if(l.length-1>p){
        a=l[p+1].href;
        if(typeof a!=="undefined"&&a.match(J)){
            c=new Image;
            c.src=a
            }
        }
    if(p>0){
    a=l[p-1].href;
    if(typeof a!=="undefined"&&a.match(J)){
        c=new Image;
        c.src=a
        }
    }
},T=function(a){
    var c={
        width:parseInt(r.width+(i.width-r.width)*a,10),
        height:parseInt(r.height+(i.height-r.height)*a,10),
        top:parseInt(r.top+(i.top-r.top)*a,10),
        left:parseInt(r.left+(i.left-r.left)*a,10)
        };

    if(typeof i.opacity!=="undefined")c.opacity=a<0.5?0.5:a;
    f.css(c);
    j.css({
        width:c.width-d.padding*2,
        height:c.height-y*a-d.padding*2
        })
    },U=function(){
    return[b(window).width()-d.margin*2,b(window).height()-d.margin*2,b(document).scrollLeft()+d.margin,b(document).scrollTop()+d.margin]
    },X=function(){
    var a=U(),c={},g=d.autoScale,k=d.padding*2;
    c.width=d.width.toString().indexOf("%")>-1?parseInt(a[0]*parseFloat(d.width)/100,10):d.width+k;
    c.height=d.height.toString().indexOf("%")>-1?parseInt(a[1]*parseFloat(d.height)/100,10):d.height+k;
    if(g&&(c.width>a[0]||c.height>a[1]))if(e.type=="image"||e.type=="swf"){
        g=d.width/d.height;
        if(c.width>a[0]){
            c.width=a[0];
            c.height=parseInt((c.width-k)/g+k,10)
            }
            if(c.height>a[1]){
            c.height=a[1];
            c.width=parseInt((c.height-k)*g+k,10)
            }
        }else{
        c.width=Math.min(c.width,a[0]);
        c.height=Math.min(c.height,a[1])
        }
        c.top=parseInt(Math.max(a[3]-20,a[3]+(a[1]-c.height-40)*0.5),10);
c.left=parseInt(Math.max(a[2]-20,a[2]+(a[0]-c.width-40)*0.5),10);
return c
},V=function(){
    var a=e.orig?b(e.orig):false,c={};

    if(a&&a.length){
        c=a.offset();
        c.top+=parseInt(a.css("paddingTop"),10)||0;
        c.left+=parseInt(a.css("paddingLeft"),10)||0;
        c.top+=parseInt(a.css("border-top-width"),10)||0;
        c.left+=parseInt(a.css("border-left-width"),10)||0;
        c.width=a.width();
        c.height=a.height();
        c={
            width:c.width+d.padding*2,
            height:c.height+d.padding*2,
            top:c.top-d.padding-20,
            left:c.left-d.padding-20
            }
        }else{
    a=U();
    c={
        width:d.padding*2,
        height:d.padding*2,
        top:parseInt(a[3]+a[1]*0.5,10),
        left:parseInt(a[2]+a[0]*0.5,10)
        }
    }
return c
},Z=function(){
    if(t.is(":visible")){
        b("div",t).css("top",L*-40+"px");
        L=(L+1)%12
        }else clearInterval(K)
        };

b.fn.fancybox=function(a){
    if(!b(this).length)return this;
    b(this).data("fancybox",b.extend({},a,b.metadata?b(this).metadata():{})).unbind("click.fb").bind("click.fb",function(c){
        c.preventDefault();
        if(!h){
            h=true;
            b(this).blur();
            o=[];
            q=0;
            c=b(this).attr("rel")||"";
            if(!c||c==""||c==="nofollow")o.push(this);
            else{
                o=b("a[rel="+c+"], area[rel="+c+"]");
                q=o.index(this)
                }
                I()
            }
        });
return this
};

b.fancybox=function(a,c){
    var g;
    if(!h){
        h=true;
        g=typeof c!=="undefined"?c:{};

        o=[];
        q=parseInt(g.index,10)||0;
        if(b.isArray(a)){
            for(var k=0,C=a.length;k<C;k++)if(typeof a[k]=="object")b(a[k]).data("fancybox",b.extend({},g,a[k]));else a[k]=b({}).data("fancybox",b.extend({
                content:a[k]
                },g));o=jQuery.merge(o,a)
            }else{
            if(typeof a=="object")b(a).data("fancybox",b.extend({},g,a));else a=b({}).data("fancybox",b.extend({
                content:a
            },g));
            o.push(a)
            }
            if(q>o.length||q<0)q=0;
        I()
        }
    };

b.fancybox.showActivity=function(){
    clearInterval(K);
    t.show();
    K=setInterval(Z,66)
    };

b.fancybox.hideActivity=function(){
    t.hide()
    };

b.fancybox.next=function(){
    return b.fancybox.pos(p+1)
    };

b.fancybox.prev=function(){
    return b.fancybox.pos(p-1)
    };

b.fancybox.pos=function(a){
    if(!h){
        a=parseInt(a);
        o=l;
        if(a>-1&&a<l.length){
            q=a;
            I()
            }else if(d.cyclic&&l.length>1){
            q=a>=l.length?0:l.length-1;
            I()
            }
        }
};

b.fancybox.cancel=function(){
    if(!h){
        h=true;
        b.event.trigger("fancybox-cancel");
        N();
        e.onCancel(o,q,e);
        h=false
        }
    };

b.fancybox.close=function(){
    function a(){
        u.fadeOut("fast");
        n.empty().hide();
        f.hide();
        b.event.trigger("fancybox-cleanup");
        j.empty();
        d.onClosed(l,p,d);
        l=e=[];
        p=q=0;
        d=e={};

        h=false
        }
        if(!(h||f.is(":hidden"))){
        h=true;
        if(d&&false===d.onCleanup(l,p,d))h=false;
        else{
            N();
            b(E.add(z).add(A)).hide();
            b(j.add(u)).unbind();
            b(window).unbind("resize.fb scroll.fb");
            b(document).unbind("keydown.fb");
            j.find("iframe").attr("src",M&&/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank");
            d.titlePosition!=="inside"&&n.empty();
            f.stop();
            if(d.transitionOut=="elastic"){
                r=V();
                var c=f.position();
                i={
                    top:c.top,
                    left:c.left,
                    width:f.width(),
                    height:f.height()
                    };

                if(d.opacity)i.opacity=1;
                n.empty().hide();
                B.prop=1;
                b(B).animate({
                    prop:0
                },{
                    duration:d.speedOut,
                    easing:d.easingOut,
                    step:T,
                    complete:a
                })
                }else f.fadeOut(d.transitionOut=="none"?0:d.speedOut,a)
                }
            }
};

b.fancybox.resize=function(){
    u.is(":visible")&&u.css("height",b(document).height());
    b.fancybox.center(true)
    };

b.fancybox.center=function(a){
    var c,g;
    if(!h){
        g=a===true?1:0;
        c=U();
        !g&&(f.width()>c[0]||f.height()>c[1])||f.stop().animate({
            top:parseInt(Math.max(c[3]-20,c[3]+(c[1]-j.height()-40)*0.5-d.padding)),
            left:parseInt(Math.max(c[2]-20,c[2]+(c[0]-j.width()-40)*0.5-d.padding))
            },typeof a=="number"?a:200)
        }
    };

b.fancybox.init=function(){
    if(!b("#fancybox-wrap").length){
        b("body").append(m=b('<div id="fancybox-tmp"></div>'),t=b('<div id="fancybox-loading"><div></div></div>'),u=b('<div id="fancybox-overlay"></div>'),f=b('<div id="fancybox-wrap"></div>'));
        D=b('<div id="fancybox-outer"></div>').append('<div class="fancybox-bg" id="fancybox-bg-n"></div><div class="fancybox-bg" id="fancybox-bg-ne"></div><div class="fancybox-bg" id="fancybox-bg-e"></div><div class="fancybox-bg" id="fancybox-bg-se"></div><div class="fancybox-bg" id="fancybox-bg-s"></div><div class="fancybox-bg" id="fancybox-bg-sw"></div><div class="fancybox-bg" id="fancybox-bg-w"></div><div class="fancybox-bg" id="fancybox-bg-nw"></div>').appendTo(f);
        D.append(j=b('<div id="fancybox-content"></div>'),E=b('<a id="fancybox-close"></a>'),n=b('<div id="fancybox-title"></div>'),z=b('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),A=b('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>'));
        E.click(b.fancybox.close);
        t.click(b.fancybox.cancel);
        z.click(function(a){
            a.preventDefault();
            b.fancybox.prev()
            });
        A.click(function(a){
            a.preventDefault();
            b.fancybox.next()
            });
        b.fn.mousewheel&&f.bind("mousewheel.fb",function(a,c){
            if(h)a.preventDefault();
            else if(b(a.target).get(0).clientHeight==0||b(a.target).get(0).scrollHeight===b(a.target).get(0).clientHeight){
                a.preventDefault();
                b.fancybox[c>0?"prev":"next"]()
                }
            });
    b.support.opacity||f.addClass("fancybox-ie");
    if(M){
        t.addClass("fancybox-ie6");
        f.addClass("fancybox-ie6");
        b('<iframe id="fancybox-hide-sel-frame" src="'+(/^https/i.test(window.location.href||"")?"javascript:void(false)":"about:blank")+'" scrolling="no" border="0" frameborder="0" tabindex="-1"></iframe>').prependTo(D)
        }
    }
};

b.fn.fancybox.defaults={
    padding:10,
    margin:40,
    opacity:false,
    modal:false,
    cyclic:false,
    scrolling:"auto",
    width:560,
    height:340,
    autoScale:true,
    autoDimensions:true,
    centerOnScroll:false,
    ajax:{},
    swf:{
        wmode:"transparent"
    },
    hideOnOverlayClick:true,
    hideOnContentClick:false,
    overlayShow:true,
    overlayOpacity:0.7,
    overlayColor:"#777",
    titleShow:true,
    titlePosition:"float",
    titleFormat:null,
    titleFromAlt:false,
    transitionIn:"fade",
    transitionOut:"fade",
    speedIn:300,
    speedOut:300,
    changeSpeed:300,
    changeFade:"fast",
    easingIn:"swing",
    easingOut:"swing",
    showCloseButton:true,
    showNavArrows:true,
    enableEscapeButton:true,
    enableKeyboardNav:true,
    onStart:function(){},
    onCancel:function(){},
    onComplete:function(){},
    onCleanup:function(){},
    onClosed:function(){},
    onError:function(){}
};

b(document).ready(function(){
    b.fancybox.init()
    })
})(jQuery);
(function(d){
    function g(a){
        var b=a||window.event,i=[].slice.call(arguments,1),c=0,h=0,e=0;
        a=d.event.fix(b);
        a.type="mousewheel";
        if(a.wheelDelta)c=a.wheelDelta/120;
        if(a.detail)c=-a.detail/3;
        e=c;
        if(b.axis!==undefined&&b.axis===b.HORIZONTAL_AXIS){
            e=0;
            h=-1*c
            }
            if(b.wheelDeltaY!==undefined)e=b.wheelDeltaY/120;
        if(b.wheelDeltaX!==undefined)h=-1*b.wheelDeltaX/120;
        i.unshift(a,c,h,e);
        return d.event.handle.apply(this,i)
        }
        var f=["DOMMouseScroll","mousewheel"];
    d.event.special.mousewheel={
        setup:function(){
            if(this.addEventListener)for(var a=f.length;a;)this.addEventListener(f[--a],g,false);else this.onmousewheel=g
                },
        teardown:function(){
            if(this.removeEventListener)for(var a=f.length;a;)this.removeEventListener(f[--a],g,false);else this.onmousewheel=null
                }
            };

d.fn.extend({
    mousewheel:function(a){
        return a?this.bind("mousewheel",a):this.trigger("mousewheel")
        },
    unmousewheel:function(a){
        return this.unbind("mousewheel",a)
        }
    })
})(jQuery);

/**
 * jQuery.placeholder - Placeholder plugin for input fields
 * Written by Blair Mitchelmore (blair DOT mitchelmore AT gmail DOT com)
 * Licensed under the WTFPL (http://sam.zoy.org/wtfpl/).
 * Date: 2008/10/14
 *
 * @author Blair Mitchelmore
 * @version 1.0.1
 *
 **/
new function($) {
    $.fn.placeholder = function(settings) {
        settings = settings || {};
        var key = settings.dataKey || "placeholderValue";
        var attr = settings.attr || "placeholder";
        var className = settings.className || "placeholder";
        var values = settings.values || [];
        var block = settings.blockSubmit || false;
        var blank = settings.blankSubmit || false;
        var submit = settings.onSubmit || false;
        var value = settings.value || "";
        var position = settings.cursor_position || 0;


        return this.filter(":input").each(function(index) {
            $.data(this, key, values[index] || $(this).attr(attr));
        }).each(function() {
            if ($.trim($(this).val()) === "")
                $(this).addClass(className).val($.data(this, key));
        }).focus(function() {
            if ($.trim($(this).val()) === $.data(this, key))
                $(this).removeClass(className).val(value)
                if ($.fn.setCursorPosition) {
                  $(this).setCursorPosition(position);
                }
        }).blur(function() {
            if ($.trim($(this).val()) === value)
                $(this).addClass(className).val($.data(this, key));
        }).each(function(index, elem) {
            if (block)
                new function(e) {
                    $(e.form).submit(function() {
                        return $.trim($(e).val()) != $.data(e, key)
                    });
                }(elem);
            else if (blank)
                new function(e) {
                    $(e.form).submit(function() {
                        if ($.trim($(e).val()) == $.data(e, key))
                            $(e).removeClass(className).val("");
                        return true;
                    });
                }(elem);
            else if (submit)
                new function(e) { $(e.form).submit(submit); }(elem);
        });
    };
}(jQuery);