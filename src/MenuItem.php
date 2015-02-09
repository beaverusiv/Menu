<?php namespace Bocapa\Menu;

class MenuItem {

    protected $name;

    protected $options;

    protected $children = array();

    public function __construct($name, $options)
    {
        $this->name = $name;

        $this->options = $options;

        if(isset($this->options['a']['route'])) {
            $this->options['a']['href'] = route($this->options['a']['route']);
        }
    }

    public function addItem($name, $options)
    {
        $new_item = new MenuItem($name, $options);
        $this->children[] = $new_item;

        return $new_item;
    }

    public function render()
    {
        if($this->opt('hidden')) return "";

        $item_html = "<li{$this->attr('li')}>";

        $item_html .= "<a{$this->attr('a')}>".$this->opt('text-prepend').$this->name.$this->opt('text-append')."</a>";

        if(count($this->children)) {
            $item_html .= "<ul{$this->attr('ul')}>";
            foreach($this->children as $child) {
                $item_html .= $child->render();
            }
            $item_html .= "</ul>";
        }

        $item_html .= "</li>";

        return $item_html;
    }

    public function contains($route)
    {
        // Base case: The route is within this item
        if(isset($this->options['a']['route']) && $route == $this->options['a']['route']) {
            return '<li><a href="'.route($route, \Route::current()->parameters()).'" class="active">'.$this->name.'</a></li>';
        }

        // Next loop children
        // Base case: No children
        if(empty($this->children)) {
            return "";
        }
        foreach($this->children as $child) {
            $breadcrumbs = $child->contains($route);
            if($breadcrumbs) {
                $href = isset($this->options['a']['href']) ? $this->options['a']['href'] : "#";
                return '<li><a href="'.$href.'">'.$this->name.'</a></li>'.$breadcrumbs;
            }
        }

        // Not within this item or any of its children
        return "";
    }

    private function opt($index)
    {
        return isset($this->options[$index]) ? $this->options[$index] : '';
    }

    private function attr($element)
    {
        // Doesn't exist or malformed
        // TODO: Malformed should throw error
        if(!isset($this->options[$element]) || !is_array($this->options[$element])) {
            return '';
        }

        // If outputting an anchor, doesn't need route
        if('a' == $element) {
            $temp = $this->options['a'];
            unset($temp['route']);

            return \HTML::attributes($temp);
        }

        return \HTML::attributes($this->options[$element]);
    }

}