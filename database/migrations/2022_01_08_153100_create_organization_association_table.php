<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationAssociationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_association', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('assocciated_as');
            $table->date('start_at');
            $table->date('end_at')->nullable();
            $table->boolean('end_at_current_work')->default(false);
            $table->text('description');
            $table->unsignedInteger('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_association');
    }
}
