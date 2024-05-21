<?php namespace Pensoft\DemonstrationProjects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class UpdateDemonstrationProjectsTable3 extends Migration
{
    public function up()
    {
        Schema::table('pensoft_demonstrationprojects_demonstration_projects', function(Blueprint $table)
        {
            $table->json('icon_settings')->nullable();
        });
    }

    public function down()
    {
        Schema::table('pensoft_demonstrationprojects_demonstration_projects', function(Blueprint $table)
        {
            $table->dropColumn('icon_settings');
        });
    }
}