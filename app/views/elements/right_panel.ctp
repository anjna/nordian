    <div id="sidebar">
	    <ul>
            <?php
                foreach($panel as $pheading => $dboard)
                {
			$main_class=$dboard['class'];
			array_pop($dboard);
                ?>
                    <li class="outer_list">
                        <h3><a href="#" class="<?php echo $main_class;?>"><?php echo $pheading; ?></a></h3>
                        <ul>
                            <?php                        
                                foreach($dboard as $subheading => $list)
                                {
                                    if(!empty($list['controller']) && !empty($list['action'])){
                                        $url = array('controller'=>$list['controller'],'action'=>$list['action']);
                                    }
                                    else{
                                      $url = 'javascript:void(0)';
                                    }
                                    ?>
                                <li>
                                    <?php echo $html->link($subheading,$url,array('class'=>$list['args']['class'],'escape'=>false)); ?>                                    
                                </li>                        
                            <?php
                                }                            
                            ?>
                        </ul>
                    </li>
            <?php
                }
            ?>
		</ul>       
    </div>
