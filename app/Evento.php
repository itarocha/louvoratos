<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
  protected $table = 'eventos';
  protected $fillable = array('id_musica', 'data_evento', 'ordem');
  public $rules = array(  'id_musica' => 'required',
                          'data_evento' => 'required|date',
                          'ordem' => 'required',
                        );

  public function musica(){
    return $this->belongsTo('App\Musica','id_musica');
  }
}
