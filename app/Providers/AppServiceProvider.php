<?php

namespace App\Providers;

use App\Repositories\File\FileRepository;
use App\Repositories\File\FileRepositoryInterface;
use App\Repositories\Folder\FolderRepository;
use App\Repositories\Folder\FolderRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //folder
        $this->app->singleton(FolderRepositoryInterface::class, FolderRepository::class);
        //file
        $this->app->singleton(FileRepositoryInterface::class, FileRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
