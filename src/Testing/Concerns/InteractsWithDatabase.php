<?php
declare(strict_types=1);
namespace Pest\Lumen\Testing\Concerns;

use Illuminate\Database\Eloquent\Model;

trait InteractsWithDatabase
{
    /**
     * Assert that a given where condition exists in the database.
     *
     * @param string $table
     * @param array $data
     * @param string|null $onConnection
     *
     * @return \Laravel\Lumen\Testing\TestCase
     */
    protected function seeInDatabase($table, array $data, $onConnection = null)
    {
        $count = $this->app->make('db')->connection($onConnection)->table($table)->where($data)->count();

        $this->assertGreaterThan(
            0,
            $count,
            sprintf(
                'Unable to find row in database table [%s] that matched attributes [%s].',
                $table,
                json_encode($data)
            )
        );

        return $this;
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param string $table
     * @param array $data
     * @param string|null $onConnection
     *
     * @return $this
     */
    protected function missingFromDatabase($table, array $data, $onConnection = null)
    {
        return $this->notSeeInDatabase($table, $data, $onConnection);
    }

    /**
     * Assert that a given where condition does not exist in the database.
     *
     * @param string $table
     * @param array $data
     * @param string|null $onConnection
     *
     * @return $this
     */
    protected function notSeeInDatabase($table, array $data, $onConnection = null)
    {
        $count = $this->app->make('db')->connection($onConnection)->table($table)->where($data)->count();

        $this->assertEquals(
            0,
            $count,
            sprintf(
                'Found unexpected records in database table [%s] that matched attributes [%s].',
                $table,
                json_encode($data)
            )
        );

        return $this;
    }


    /**
     * Get the database connection.
     *
     * @param  string|null  $connection
     * @param  string|null  $table
     * @return \Illuminate\Database\Connection
     */
    protected function getConnection($connection = null, $table = null)
    {
        $database = $this->app->make('db');

        $connection = $connection ?: $this->getTableConnection($table) ?: $database->getDefaultConnection();

        return $database->connection($connection);
    }
    /**
     * Get the table name from the given model or string.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string  $table
     * @return string
     */
    protected function getTable($table)
    {
        return $this->newModelFor($table)?->getTable() ?: $table;
    }

    /**
     * Get the table connection specified in the given model.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string  $table
     * @return string|null
     */
    protected function getTableConnection($table)
    {
        return $this->newModelFor($table)?->getConnectionName();
    }

    /**
     * Get the model entity from the given model or string.
     *
     * @param  \Illuminate\Database\Eloquent\Model|string  $table
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function newModelFor($table)
    {
        return is_subclass_of($table, Model::class) ? (new $table) : null;
    }
}
