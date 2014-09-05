    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    <title><?php echo $title_for_layout; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php  echo $html->css('style');?>
    <?php //echo $javascript->link(array('jquery','common','formvalidation','jquery.validate')); ?>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php echo $scripts_for_layout; ?>
    </head>
    <body style="z-index:0;">
        <?php echo $this->element('header'); ?>
        <section class="banner_full">
            <section class="banner_wrap">
               <section class="banner_l">
                  <section class="banner_txt">
                      <h3 class="orange_head"> <img src="/img/featured.png">Page Not Found!</h3>
                  </section>
               </section>
            </section>
         </section>
        <section class="container_full">
            
            <section class="container_wrap">
                
                <div style="height:300px;">
                <h1>The page cannot be found.</h1>
                
                <br />
                <br />
                <p>
                      The Error 404 "Page not found" is the error page displayed whenever someone asks for a page that's simply not available on your site. The reason for this is that there may be a link on your site that was wrong or the page might have been recently removed from the site. As there is no web page to display, the web server sends a page that simply says "404 Page not found".
                      <br /><br />
                      The 404 error message is an HTTP (Hypertext Transfer Protocol) standard status code. This "Not Found" response code indicates that although the client could communicate to the server, the server could not find what was requested or it was configured not to fulfill the request.
                      <br /><br />
                      The 404 "Not Found" error is not the same as the "Server Not Found" error which you see whenever a connection to the destination server could not be established at all.
                </p>
                
              </div>
                    
            </section>
            
        </section>
        
        <div class="clear"></div>
    
        
       
        <?php //echo $this->element('video_section'); ?>
        <?php echo $this->element('footer'); ?> 
          <?php
      //  echo $this->element('sql_dump');
    ?>   
    </body>
    </html>
