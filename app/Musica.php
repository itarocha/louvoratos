<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MusicaEvento;

class Musica extends Model
{
  protected $table = 'musicas';
  protected $fillable = array('descricao', 'artista', 'arquivo_cifra', 'arquivo_mp3', 'link_youtube', 'link_cifraclub');
  public $rules = array(  'descricao' => 'required|min:3|max:128',
                          'artista' => 'required|min:3|max:128',
                          'arquivo_cifra' => 'required|min:3|max:128',
                          'arquivo_mp3' => 'required|min:3|max:128',
                          'link_youtube' => 'required|min:3|max:128',
                          'link_cifraclub' => 'required|min:3|max:128',
                        );

  public function musica_eventos(){
    return $this->hasMany('App\MusicaEvento');
  }
    //
}
