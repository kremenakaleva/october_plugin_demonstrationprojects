<?php namespace Pensoft\DemonstrationProjects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreateDemonstrationProjectsTable Migration
 */
class CreateDemonstrationProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('pensoft_demonstrationprojects_demonstration_projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('slug')->nullable();
            $table->string('title')->nullable();
            $table->string('category')->nullable();
            $table->string('cluster')->nullable();
            $table->string('country')->nullable();
            $table->text('main_objective')->nullable();
            $table->text('expected_outcome')->nullable();
            $table->text('content')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pensoft_demonstrationprojects_demonstration_projects');
    }
}
