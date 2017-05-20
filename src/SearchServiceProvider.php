<?php

namespace browner12\larasearch;

use browner12\larasearch\Console\IndexCommand;
use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerSearchManager();

        $this->registerSearchDriver();

        $this->publishResources();

        $this->registerConsoleCommands();
    }

    /**
     * Register the search manager instance.
     *
     * @return void
     */
    protected function registerSearchManager()
    {
        $this->app->singleton('search.manager', function ($app) {
            return new SearchManager($app);
        });
    }

    /**
     * Register the search driver instance.
     *
     * @return void
     */
    protected function registerSearchDriver()
    {
        $this->app->singleton(Searcher::class, function ($app) {
            return $app->make('search.manager')->driver();
        });
    }

    /**
     * Publish the resources.
     *
     * @return void
     */
    protected function publishResources()
    {
        $this->publishes([
            __DIR__ . '/config/search.php' => config_path('search.php'),
        ], 'config');
    }

    /**
     * Register the search console commands.
     *
     * @return void
     */
    protected function registerConsoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                IndexCommand::class,
            ]);
        }
    }
}
