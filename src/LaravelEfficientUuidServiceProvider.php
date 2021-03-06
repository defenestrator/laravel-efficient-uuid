<?php

namespace Dyrynda\Database;

use Illuminate\Database\Connection;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;
use Dyrynda\Database\Connection\MySqlConnection;
use Dyrynda\Database\Connection\SQLiteConnection;
use Dyrynda\Database\Connection\PostgresConnection;

class LaravelEfficientUuidServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Connection::resolverFor('mysql', function ($connection, $database, $prefix, $config): MySqlConnection {
            return new MySqlConnection($connection, $database, $prefix, $config);
        });

        Connection::resolverFor('pgsql', function ($connection, $database, $prefix, $config): PostgresConnection {
            return new PostgresConnection($connection, $database, $prefix, $config);
        });
        
        Connection::resolverFor('sqlite', function ($connection, $database, $prefix, $config): SQLiteConnection {
            return new SQLiteConnection($connection, $database, $prefix, $config);
        });

        Blueprint::macro('efficientUuid', function ($column): ColumnDefinition {
            /** @var Blueprint $this */
            return $this->addColumn('efficientUuid', $column);
        });
    }
}
