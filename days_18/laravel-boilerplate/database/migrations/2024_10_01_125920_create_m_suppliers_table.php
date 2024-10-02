<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('m_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('contact_person', 100)->nullable();
            $table->string('email', 100)->nullable()->unique();
            $table->string('phone', 15)->nullable()->unique();
            $table->text('address')->nullable();
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
        Schema::dropIfExists('m_suppliers');
    }
}
