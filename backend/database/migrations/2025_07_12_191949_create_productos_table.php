<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
       Schema::create('productos', function (Blueprint $table) {
           $table->uuid('id')->primary();
           $table->string('descripcion');
           $table->string('categoria');
           $table->decimal('precio', 10, 2);
           $table->integer('stockminimo');
           $table->string('unidadmedida');
           $table->boolean('activo')->default(true);
           $table->timestamps();
       });
   }


    
};
