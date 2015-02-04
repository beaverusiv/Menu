<?php namespace Bocapa\Menu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->package('bocapa/menu');

        \App::singleton('menu', function()
        {
            return new MenuManager;
        });

        \View::composer('base.backend', 'BackendViewComposer');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
