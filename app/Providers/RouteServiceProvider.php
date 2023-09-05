<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapDepartmentRoutes();
        $this->mapCustomerRoutes();
        $this->mapHumanResourceRoutes();
        $this->mapApplicationRoutes();
        $this->mapProfileRoutes();
        $this->mapContractRoutes();
        $this->mapFolderRoutes();
        $this->mapFileRoutes();
        $this->mapUserRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "department" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapDepartmentRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/department.php'));
    }

    /**
     * Define the "customer" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapCustomerRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/customer.php'));
    }

    /**
     * Define the "human_resource" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapHumanResourceRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/human_resource.php'));
    }

    /**
     * Define the "application" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApplicationRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/application.php'));
    }

    /**
     * Define the "profile" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapProfileRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/profile.php'));
    }

    /**
     * Define the "contract" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapContractRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/contract.php'));
    }

    /**
     * Define the "folder" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFolderRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/folder.php'));
    }

    /**
     * Define the "file" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapFileRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/file.php'));
    }

    /**
     * Define the "user" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapUserRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web/user.php'));
    }
}
