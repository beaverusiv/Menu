<?php namespace Bocapa\Menu\Composers;

use Illuminate\View\View;

class BackendViewComposer {
    public function compose(View $view)
    {
        $dashboard_options = [
            'a' => ['route' => 'dashboard.route'],
            'text-prepend' => '<i class="fa fa-dashboard"></i>'
        ];

        $menu = Menu::create('backend', ['ul' => ['class' => 'sidebar-menu']]);
        $menu->addItem('Dashboard', $dashboard_options);
    }
}