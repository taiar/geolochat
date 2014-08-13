<?php

use Phpmig\Migration\Migration;

class CreateSessionTable extends Migration
{
    /* @var \Illuminate\Database\Schema\Builder $schema */
    protected $table_name;
    protected $schema;

    /**
     * Do the migration
     */

    public function init ()
    {
        $this->table_name = "sessions";
        $this->schema = $this->get('schema');
    }

    public function up()
    {
        /* @var \Illuminate\Database\Schema\Blueprint $table */
        $this->schema->create(
            $this->table_name,
            function($table) {
                $table->increments('id');
                $table->string('sessid');
                $table->string('ip');
                $table->string('lat');
                $table->string('long');
                $table->timestamps();
                $table->softDeletes();
            }
        );
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->schema->drop($this->table_name);
    }
}
