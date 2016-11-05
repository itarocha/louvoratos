<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
  protected $table = 'eventos';
  protected $fillable = array('data_evento');
  public $rules = array(  'data_evento' => 'required|date'
                        );

  public function musica_eventos(){
    return $this->hasMany('App\EventoMusica','id_evento'); // O padrão é evento_id
  }

  public function musicas(){
    //https://laravel.com/api/5.3/Illuminate/Database/Eloquent/Relations/HasManyThrough.html
    // https://github.com/laravel/framework/blob/5.3/src/Illuminate/Database/Eloquent/Relations/HasManyThrough.php
    // https://laravel.com/docs/5.3/eloquent-relationships#one-to-many
    $obj = $this->hasManyThrough('App\Musica','App\EventoMusica','id_musica','id','id_musica'); // O padrão é evento_id

    //dd($obj->getForeignKey());
    return $obj;

  }
}
