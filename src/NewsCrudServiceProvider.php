<?php

namespace Sevenpluss\NewsCrud;

use Illuminate\Support\ServiceProvider;

/**
 * Class NewsCrudServiceProvider
 * @package Sevenpluss\NewsCrud
 */
class NewsCrudServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        $configPathCrud = __DIR__ . '/../config/news-crud.php';
        $this->publishes([
            $configPathCrud => config_path('news-crud.php'),
        ], 'config');
        $this->mergeConfigFrom($configPathCrud, 'config');


        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/news-crud'),
        ], 'lang');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'news');


        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('vendor/news-crud'),
        ], 'assets');


        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/news-crud'),
        ], 'views');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'news');


        $this->publishes([
            __DIR__ . '/../database' => database_path(),
        ], 'database');
        $this->loadMigrationsFrom(__DIR__ . '/../database');


        $routeConfig = [
            'namespace' => 'Sevenpluss\NewsCrud\Http\Controllers\Web',
            'middleware' => ['web'],
        ];

        $this->getRouter()->group($routeConfig, function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        });


        $routeConfig = [
            'namespace' => 'Sevenpluss\NewsCrud\Http\Controllers\Api',
            'middleware' => [
                'api',
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            ],
            'prefix' => 'api'
        ];

        $this->getRouter()->group($routeConfig, function () {
            $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerPackages();
        $this->registerRepositories();
    }

    /**
     * @return \Illuminate\Routing\Router
     */
    protected function getRouter():\Illuminate\Routing\Router
    {
        return $this->app['router'];
    }

    /**
     * @return void
     */
    protected function registerPackages(): void
    {
        $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(\TwigBridge\ServiceProvider::class);

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        $loader->alias('Twig', \TwigBridge\Facade\Twig::class);
    }

    /**
     * @return void
     */
    protected function registerRepositories(): void
    {
        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\CategoryRepositoryInterface::class,
            \Sevenpluss\NewsCrud\Repositories\CategoryRepository::class, true);

        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\PostRepositoryInterface::class,
            \Sevenpluss\NewsCrud\Repositories\PostRepository::class, true);

        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\CommentRepositoryInterface::class,
            \Sevenpluss\NewsCrud\Repositories\CommentRepository::class, true);

        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\TagRepositoryInterface::class,
            \Sevenpluss\NewsCrud\Repositories\TagRepository::class, true);

        $this->app->bindIf(\Sevenpluss\NewsCrud\Repositories\Contracts\UserRepositoryInterface::class,
            \Sevenpluss\NewsCrud\Repositories\UserRepository::class, true);
    }
}
