<?php namespace Bocapa\Menu;

class Menu {

    protected $items = array();

    protected $options;

    protected $name;

    public function __construct($name, $options = array())
    {
        $this->name = $name;

        $this->options = $options;

        return $this;
    }

    public function &addItem($name, $options)
    {
        $item = new MenuItem($name, $options);
        $this->items[] = $item;

        return $item;
    }

    public function render()
    {
        $attributes = isset($this->options['ul']) ? \HTML::attributes($this->options['ul']) : '';
        $menu_html = "<ul{$attributes}>";

        foreach($this->items as $item) {
            $menu_html .= $item->render();
        }

        $menu_html .= "</ul>";

        return $menu_html;
    }

    public function breadcrumbs($route)
    {
        foreach($this->items as $item) {
            $item_html = $item->contains($route);
            if($item_html) {
                return $item_html;
            }
        }
    }

}