<?php

// https://laravel.com/api/5.3/Illuminate/Database/Query/Builder.html
namespace App\Model;

use DB;
use Laravel\Database\Exception;

class MusicaDAO {


  public function getRules(){
    return array('descricao' => 'required|min:3|max:32',);
  }


  public function listagem(){


    $query = DB::table('musicas as tb')
              ->select('tb.id_musica', 'tb.descricao', 'tb.artista')
              ->orderBy('tb.descricao');
    $retorno = $query->get();
    return $retorno;
  }


  public function getById($id){

    // $query = DB::table('acao as a')
    //           ->select('a.id_acao', 'a.descricao')
    //           ->where('a.id_acao','=',$id);
    // $retorno = $query->get();
    // if ($retorno->count() > 0) {
    //   return $retorno;
    // } else {
    //   return null;
    // }
  }


  public function insert($array){
    try {
      $id = DB::table('musica')->insertGetId($array);

      return (object)array( 'id' => $id,
                            'status_code' => 200,
                            'mensagem' => 'Criado com sucesso');
    } catch (\Exception $e){
      return (object)array( 'id' => -1,
                            'status_code' => 500,
                            'mensagem' => $e->getMessage());
    }
  }


  public function update($id, $array){
    // $model = $this->getById($id);
    //
    // if (!$model){
    //   return (object)array( 'status_code'=>404,
    //                         'mensagem'=>'Não encontrado');
    // }
    // try {
    //   $affected = DB::table('acao')
    //                 ->where('id_acao',$id)
    //                 ->update($array);
    //   $retorno = ($affected == 1) ? 200 : 204;
    //   if ($affected == 1) {
    //     return (object)array(   'status_code'=>200,
    //                             'mensagem'=>'Alterado com sucesso');
    //   } else {
    //       return (object)array( 'status_code'=>204,
    //                             'mensagem'=>'Registro não necessita ser modificado');
    //   }
    // } catch (\Exception $e) {
    //     //Campo inválido, erro de sintaxe
    //     return (object)array('status_code'=>500,
    //         'mensagem'=>'Falha ao alterar registro. Erro de sintaxe ou violação de chave'
    //         .$e->getMessage());
    // }
    // return $retorno;
  }


  public function delete($id)
  {
    // $affected = DB::table('acao')
    //             ->where('id_acao',$id)
    //             ->delete();
    // if ($affected == 1) {
    //   return (object)array( 'status_code'=>200,
    //                         'mensagem'=>'Excluído com sucesso');
    // } else {
    //   return (object)array( 'status_code'=>404,
    //                         'mensagem'=>'Não encontrado');
    // }
  }
}

// INSERT INTO `louvoratos`.`musica`
// (`id_musica`,
// `descricao`,
// `artista`,
// `diretorio_cifra`,
// `arquivo_cifra`,
// `diretorio_mp3`,
// `arquivo_mp3`,
// `diretorio_letra`,
// `arquivo_letra`,
// `link_youtube`,
// `link_cifraclub`)
// VALUES
// (<{id_musica: }>,
// <{descricao: }>,
// <{artista: }>,
// <{diretorio_cifra: }>,
// <{arquivo_cifra: }>,
// <{diretorio_mp3: }>,
// <{arquivo_mp3: }>,
// <{diretorio_letra: }>,
// <{arquivo_letra: }>,
// <{link_youtube: }>,
// <{link_cifraclub: }>);
