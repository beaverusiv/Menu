<?php namespace Bocapa\Menu;

class MenuManager {

    protected $menus = array();

    public function create($name, $options = array(), $attributes = array())
    {
        // TODO: Sanitise $name
        $menu = new Menu($name, $options, $attributes);
        $this->menus[$name] = $menu;

        return $menu;
    }

    public function exists($name)
    {
        if(isset($this->menus[$name])) {
            return $this->menus[$name];
        }

        return null;
    }

    public function render($name)
    {
        // Get all packages' menu items
        \Event::fire('menu.generate');

        return $this->menus[$name]->render();
    }

    public function breadcrumbs()
    {
        $route = \Route::current()->getName();

        foreach($this->menus as $menu) {
            // Each route should only be in one menu. When a menu takes
            // ownership of that route no need to keep looping.
            $html = $menu->breadcrumbs($route);
            if($html) {
                return '<ol class="breadcrumb">'.$html.'</ol>';
            }
        }
    }

}