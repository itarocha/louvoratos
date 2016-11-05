<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

// php artisan make:migration create_tabelas --create=cidades
// *** php artisan migrate - cria tabelas
// php artisan make:model Cidade
// *** php artisan db:seed


class CreateTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('musicas', function (Blueprint $table) {
          $table->increments('id');
          $table->string('descricao',128);
          $table->string('artista',64);
          $table->string('arquivo_cifra',128);
          //$table->string('arquivo_letra',128);
          $table->string('arquivo_mp3',128);
          $table->string('link_youtube',128);
          $table->string('link_cifraclub',128);
          $table->timestamps();
          $table->index('descricao', 'musicas_idx01');
      });

      Schema::create('eventos', function (Blueprint $table) {
          $table->increments('id');
          $table->date('data_evento');
          $table->timestamps();
          $table->index('data_evento', 'eventos_idx01');
      });

      Schema::create('evento_musicas', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_evento')->unsigned();
          $table->integer('id_musica')->unsigned();
          $table->integer('ordem');
          $table->timestamps();

          $table->foreign('id_musica')->references('id')->on('musicas');
          $table->foreign('id_evento')->references('id')->on('eventos');
      });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
      Schema::dropIfExists('evento_musicas');
      Schema::dropIfExists('eventos');
      Schema::dropIfExists('musicas');
    }
}
