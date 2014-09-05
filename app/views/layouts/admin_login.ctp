	<!DOCTYPE HTML>
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>Nordian</title>
	<!--[if IE]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if lte IE 7]>
		<script src="js/IE8.js" type="text/javascript"></script><![endif]-->
		<?php  echo $html->css(array('adminstyle'));?>
		<?php echo $javascript->link(array('jquery','common','formvalidation')); ?>
		<?php echo $scripts_for_layout; ?>
	</head>

	<body>
	
		<section class="top_header">
		  <header> <a href="#"><img src="<?php echo Configure::read('siteUrl'); ?>/img/logo.png" alt="" class="logo" /></a>
			
		  </header>
		  <article class="sab-header"></article>
		</section>
		
		<section id="wrapper">
				<?php                             
                    echo $content_for_layout;
                ?>  
		</section>

		<?php echo $this->element('admin_footer'); ?>
		
		<?php
			echo $this->element('sql_dump');
		?>
	</body>
	</html>
