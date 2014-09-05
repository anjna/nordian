    <!DOCTYPE HTML>
	<?php echo $facebook->html(); ?> 
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
        // header
        echo $this->element('header');
        ?>
        <!--Banner Starts-->
        <section class="banner_full">
        <?php
            // content 
            if ($session->check('Message.flash')) { echo $session->flash(); }
            echo $content_for_layout;
        ?>
        </section>
        
    
        <?php echo $this->element('video_section'); ?>
        <?php echo $this->element('footer'); ?>
        <?= $facebook->init(); ?>
        <?php
        echo $this->element('sql_dump'); ?>       
    </body>
    </html>
