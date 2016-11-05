<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventoMusica extends Model
{
  protected $table = 'evento_musicas';
  protected $fillable = array('id_evento','id_musica', 'ordem');
  public $rules = array(  'id_evento' => 'required',
                          'id_musica' => 'required',
                          'ordem' => 'required',
                        );

  public function evento(){
    return $this->belongsTo('App\Evento','id_evento');
  }

  public function musica(){
    return $this->belongsTo('App\Musica','id_musica');
  }
}
