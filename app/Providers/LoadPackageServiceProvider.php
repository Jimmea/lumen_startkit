<?php
/**
 * Created by PhpStorm.
 * User: Hungokata
 * Date: 3/6/19
 * Time: 00:01
 */

namespace App\Providers;


use Dionera\BeanstalkdUI\BeanstalkdUIServiceProvider;
use Illuminate\Support\ServiceProvider;
class LoadPackageServiceProvider extends ServiceProvider
{
    protected $packages = [
        BeanstalkdUIServiceProvider::class
    ];
    public function boot()
    {

    }

    public function register()
    {
        foreach ($this->packages as $plugin)
        {
            $this->app->register($plugin);
        }
    }
}