<?php

// https://laravel.com/api/5.3/Illuminate/Database/Query/Builder.html
namespace App\DAO;

use DB;
use Laravel\Database\Exception;
use App\Musica;

class MusicasDAO extends AbstractDAO {

  function model(){
    return 'App\Musica';
  }

  // Implementação de abstract
  // Essa query é repetida em listagem e getById
  function query(){
    $query = Musica::select(  'musicas.descricao',
                              'musicas.artista',
                              'musicas.arquivo_cifra',
                              'musicas.arquivo_mp3',
                              'musicas.link_youtube',
                              'musicas.link_cifraclub')
              ->orderBy('musicas.descricao');
    return $query;
  }


  public function getCamposPesquisa(){
    return array(
        (object)array('name' => 'musicas.descricao', 'type' => 'text', 'display' => 'Música'),
        (object)array('name' => 'musicas.artista', 'type' => 'text', 'display' => 'Artista' ),
        );
  }

  public function novo(){
    return (object)array( 'id'=>0,
                          'descricao'=>'',
                          'artista' => '',
                          'arquivo_cifra' => '',
                          'arquivo_mp3' => '',
                          'link_youtube' => '',
                          'link_cifraclub' => '');
  }

}
