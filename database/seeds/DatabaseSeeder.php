<?php

use Illuminate\Database\Seeder;
use App\Musica;
use App\Evento;
use App\EventoMusica;
//use App\ModelValidator;

// php artisan db:seed

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PopulaTabelasSeeder::class);
    }
}


class PopulaTabelasSeeder extends Seeder {

  public function run(){

      //DB::table('evento_musicas')->delete();
      //DB::table('eventos')->delete();

      // $usuarios = User::get();
      //
      // if($usuarios->count() == 0) {
      //     User::create(array(
      //         'email' => 'admin@gmail.com',
      //         'password' => Hash::make('admin'),
      //         'name'  => 'Administrador',
      //         'isAdmin'  => 'S',
      //         'podeAlterar'  => 'S',
      //         'podeIncluir'  => 'S',
      //         //'tipo'  => 'admin'
      //     ));
      // }

      $musicas = Musica::get();
      foreach ($musicas as $key => $musica) {
        $this->command->info($musica->id.' - '.$musica->descricao);
      }

      // $evento = Evento::create(array(
      //     'data_evento' => '2016-10-16'
      // ));
      //
      // $this->command->info('Evento #'.$evento->id.' criado com sucesso!');

      $m1 = Musica::find(3);
      $m2 = Musica::find(4);
      $m3 = Musica::find(5);
      $m4 = Musica::find(6);

      $this->command->info('Musica #1 = '.$m1->descricao.' '.$m1->artista);
      $this->command->info('Musica #2 = '.$m2->descricao.' '.$m2->artista);
      $this->command->info('Musica #3 = '.$m3->descricao.' '.$m3->artista);
      $this->command->info('Musica #4 = '.$m4->descricao.' '.$m4->artista);

      // EventoMusica::create(array(
      //   'id_musica' => $m1->id,
      //   'id_evento' => $evento->id,
      //   'ordem'     => 1,
      // ));
      // EventoMusica::create(array(
      //   'id_musica' => $m2->id,
      //   'id_evento' => $evento->id,
      //   'ordem'     => 2,
      // ));
      // EventoMusica::create(array(
      //   'id_musica' => $m3->id,
      //   'id_evento' => $evento->id,
      //   'ordem'     => 3,
      // ));
      // EventoMusica::create(array(
      //   'id_musica' => $m4->id,
      //   'id_evento' => $evento->id,
      //   'ordem'     => 4,
      // ));

      $evento = $this->getUltimoEvento();
      $this->command->info('Ultimo evento = '.$evento->id);

      $query = DB::table('eventos')
              ->select( 'eventos.id',
                        'eventos.data_evento',
                        'evento_musicas.id_musica',
                        'evento_musicas.ordem',
                        'musicas.descricao',
                        'musicas.artista',
                        'musicas.arquivo_cifra'

                        )
              ->join('evento_musicas','eventos.id','=','evento_musicas.id_evento')
              ->join('musicas','musicas.id','=','evento_musicas.id_musica')
              ->where('eventos.id','=',$evento->id)
              ->orderBy('evento_musicas.ordem')
              ->get();

      foreach ($query as $key => $m) {
        $this->command->info(' *** '.$m->descricao.' - '.$m->artista.'. Cifra: '.$m->arquivo_cifra);
      }

      // Último evento

      // Se último evento é diferente de null,  busca músicas deste evento



      $this->command->info('Comandos realizados com sucesso!');
  }

  private function getUltimoEvento(){
    $max = DB::table('eventos')->max('data_evento');
    if ($max) {
      $evento = Evento::where('data_evento','=',$max)->first();

      //$musicas = $evento->musica_eventos;
      $musicas = $evento->musicas;

      //dd($evento->musicas);
      //dd($musicas);
      foreach ($musicas as $m) {
        $this->command->info('      Musica do Evento #1 = '.$m->descricao);

      }

      return $evento;
    }
    return null;
  }

}
