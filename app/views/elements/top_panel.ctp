    <div id="top-panel">
	    <div id="panel">
            <ul>
                <?php
                    foreach($panel as $pheading => $dboard)
                    {
                        $main_class=$dboard['class'];
                        array_pop($dboard);
                        foreach($dboard as $subheading => $list)
                        {
                            
                            if(in_array($controller,$list['args']['display']))
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
                        }
                    }
                    
                ?>
            </ul>
        </div>
    </div>
