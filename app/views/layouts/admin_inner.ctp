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
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
	<?php echo $javascript->link(array('common')); ?>

	<?php echo $scripts_for_layout; ?>
	</head>

	<body>
		<section class="top_header">
		  <header> <a href="dashboard.html"><img src="<?php echo Configure::read('siteUrl'); ?>/img/logo.png" alt="" class="logo" /></a>
			<aside class="right_header">Exam Preperation App<br>
			  <span><b>Welcome:</b> <em>
			  <?php				
				echo $_SESSION['Auth']['Admin']['fullname'];
			  ?></em></span></aside>
		  </header>
		</section>
		<section id="wrapper">
		  <section class="shadow">
			<nav>
			  <ul>
				<li><a href="<?php echo Configure::read('adminUrl'); ?>"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_home.png" width="37" height="38" alt=""><br>
				  Home</a></li>	
				<li><a href="<?php echo Configure::read('adminUrl'); ?>/admins"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_sme.png" width="42" height="38" alt=""><br>
				 SME's</a></li>
				<li><a href="<?php echo Configure::read('adminUrl'); ?>/topics"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_courses.png" width="40" height="38" alt=""><br>
				  Session</a></li>
				  <li><a href="<?php echo Configure::read('adminUrl'); ?>/tasks"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_chapters.png" width="30" height="38" alt=""><br>
				  Task Management</a></li>
			<!--	<li><a href="<?php// echo Configure::read('adminUrl'); ?>/subjects"><img src="<?php //echo Configure::read('siteUrl'); ?>/img/icon_subjects.png" width="38" height="38" alt=""><br>
				 Feedback</a></li>!-->
				<aside><a href="<?php echo Configure::read('adminUrl'); ?>/admins/logout"><img src="<?php echo Configure::read('siteUrl'); ?>/img/img_logout.png" width="24" height="23" alt=""><br>
				  Logout</a></aside>
			  </ul>
			</nav>
				<!-- This code user for editor -->
				<script>
					var getId = "";
				</script>
				<!-- End -->
	
				<?php      
					echo $content_for_layout;
				?> 
			</section>
		</section>
		<?php
		//	echo $this->element('sql_dump');
		?>
		<?php echo $this->element('admin_footer'); ?>
	</body>
	</html>
