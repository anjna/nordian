<?php
class SlugRoute extends CakeRoute {
 
    function parse($url) {
        $params = parent::parse($url);
        
        if (empty($params)) {
            return false;
        }
        
        if($params['controller'] == 'static_pages' && $params['action'] == 'view')
        {
            $slugs = Cache::read('static_slugs');
            if (empty($slugs)) {
                App::import('Model', 'StaticPage');
                $StaticPage = new StaticPage();
                $StaticPages = $StaticPage->find('all', array(
                    'fields' => array('StaticPage.slug'),
                    'recursive' => -1
                ));
                $slugs = array_flip(Set::extract('/StaticPage/slug', $StaticPages));            
                Cache::write('static_slugs', $slugs);
            }
            if (isset($slugs[$params['slug']])) {
                return $params;
            }
        }
        
        return false;
    }
 
}?>