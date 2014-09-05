		<article class="dredcrum"><a href="#">Home</a>   » <a href="#"><strong>Dashboard</strong></a></article>
		<article class="setting-panel"><a href="#"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon-settings.png" width="24" height="25" alt="" title="Settings"></a></article>
		<article class="pageheadding"><h3><span>Dashboard</span></h3></article>
			<article class="dashboard">
				<ul>   
					
					<?php if($utype = "admin"){ ?>					
					<li><a href="<?php echo Configure::read('adminUrl'); ?>/admins"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_sme-b.png" width="54" height="61" alt=""><br>
					Manage<br>
					SME's</a></li>
					<li><a href="<?php echo Configure::read('adminUrl'); ?>/topics"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_courses-b.png" width="61" height="61" alt=""><br>
					  Manage<br>
					Session</a></li>
					<li><a href="<?php echo Configure::read('adminUrl'); ?>/feedbacks"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_subjects-b.png" width="65" height="61" alt=""><br>
					  Manage<br>
					Feedbacks</a></li>
					<li><a href="<?php echo Configure::read('adminUrl'); ?>/feedbacks"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_chapters.png" width="65" height="61" alt=""><br>
					  Manage<br>
					Task</a></li>
					<?php 
					}
                     ?>		
					<?php  if($utype != "admin")
                     {?>
                  		<li><a href="<?php echo Configure::read('adminUrl'); ?>/admins"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_sme-b.png" width="61" height="61" alt=""><br>
					Add<br>
					SME's</a></li>
					<li><a href="<?php echo Configure::read('adminUrl'); ?>/topics"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_courses-b.png" width="61" height="61" alt=""><br>
					  <br>
				View
				All Sessions</a></li>
					<li><a href="<?php echo Configure::read('adminUrl'); ?>/feedbacks"><img src="<?php echo Configure::read('siteUrl'); ?>/img/icon_subjects-b.png" width="65" height="61" alt=""><br>
					 <br>
					Give 
					Feedbacks</a></li>	
				<?php
					}
					?>				
					
				</ul>
		  </article>
