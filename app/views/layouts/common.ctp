    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    
    <title><?php echo $title_for_layout; ?></title>
    
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <?php
    if(isset($keywords_for_layout))
    {
        echo $this->Html->meta('keywords',$keywords_for_layout);
    }
    if(isset($description_for_layout))
    {
        echo $this->Html->meta('description',$description_for_layout);
    }
    ?>
    
    <?php  echo $html->css('style');?>
    <?php echo $javascript->link(array('jquery','common','formvalidation','jquery.validate')); ?>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <?php echo $scripts_for_layout; ?>
    </head>
    <body>
        <?php
            if($session->read('Auth.User.id'))
            {
                // header
                echo $this->element('home_header');
            }
            else
            {   // header
                echo $this->element('header');
            }
        ?>
       <!-- Banner Starts -->
        <section class="banner_full" style="min-height:400px !important;">
            <section class="banner_wrap">
                <section class="banner_txt">
                    <section class="form_align">
                    <?php
                        // content 
                        //if ($session->check('Message.flash')) { echo $session->flash(); }
                        echo $content_for_layout;
                    ?>
                    <section class="clear"></section>
                    </section>
               </section>
            </section>
         </section>
        
        <?php echo $this->element('footer'); ?>
        <?php
        echo $this->element('sql_dump');
    ?>
    </body>
    </html>
