<?php

namespace App\Providers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Grammars\MySqlGrammar;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Fluent;
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
        //
    }

    /**
     * @return void
     */
    public function boot()
    {
        /*
        // Using view composer to set following variables globally
        view()->composer('*', function ($view) {
        //variables globales
        //se pueden acceder a estas variables de la siguiente  manera
        //en clases php $dato=config('constants.VERSION_CSS')
        //en plnatillas blade {{config('constants.VERSION_CSS')}}
        //estas variables sirven para controlar las versiones de css y js y otros
        //si usas las variables de este archivo config/constants.php debes actualizar los valores del mismo archivo
        //ahora si usas variables de Providers/AppServiceProvider.php entonces debes actualizar los valores de ese mismo archivo
        $view->with('VERSION_CSS', 2);
        $view->with('VERSION_JS', 2);
        });
         */

        // Type::addType('longblob', LongBlobType::class);
        // Type::addType('blob', 'Doctrine\DBAL\Types\BlobType');
        // Type::addType('binary', 'Doctrine\DBAL\Types\BinaryType');
        Blueprint::macro('longBinary', function ($column) {
            return $this->addColumn('longBinary', $column);
        });

        MySqlGrammar::macro('typeLongBinary', function (Fluent $column) {
            return 'longblob'; 
        });

        Schema::defaultStringLength(420);
    }
}
