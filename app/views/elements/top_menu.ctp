   <?php
    $action_array = array(
                              'Dashboard'=>array('controller'=>'admins','action'=>'admin_dashboard','options'=>array()),
                            
                              'Settings'=>array('controller'=>'settings','action'=>'admin_index','options'=>array()),
                              'Change Password'=>array('controller'=>'admins','action'=>'admin_changepassword','options'=>array()),                              
                              'Log Out'=>array('controller'=>'admins','action'=>'admin_logout','options'=>array()),
                        );
    ?>

    <div id="topmenu">
        <ul>
            
            <?php                  
                        foreach($action_array as $label => $action_arr)
                        {                      
                            if(!empty($action_arr['controller']) && !empty($action_arr['action'])){
                              $url = array('controller'=>$action_arr['controller'],'action'=>$action_arr['action']);
                            }
                            else{
                              $url = 'javascript:void(0)';
                            }
                            $class = '';
                            
                            if(isset($action_arr['controller']) && isset($action_arr['action'])){
                              if(($action_arr['controller'] == $controller && $action_arr['action'] == $action) || ($action_arr['controller'] == $controller && in_array($action,$action_arr['options']))){
                                  $class = 'current';
                              }
                            }
                    ?>
                    <li class="<?php echo $class; ?>">
                    <?php
                           echo $html->link($label,$url,array('escape'=>false));
                     ?>
                    </li>
                    <?php
                        }
                    ?>
        </ul>
    </div>