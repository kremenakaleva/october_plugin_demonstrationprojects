<?php namespace Pensoft\DemonstrationProjects\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

/**
 * CreatePartnersDemonstrationTable Migration
 */

class CreateScientificPartnersDemonstrationsTable extends Migration
{
    public function up()
    {
        Schema::create('pensoft_scientific_partners_demonstrations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('demonstration_id')->unsigned();
            $table->integer('partner_id')->unsigned();

            $table->primary(['demonstration_id', 'partner_id']);

            $table->foreign('demonstration_id')->references('id')->on('pensoft_demonstrationprojects_demonstration_projects')->onDelete('cascade');
            $table->foreign('partner_id')->references('id')->on('pensoft_partners_partners')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pensoft_scientific_partners_demonstrations');
    }
}