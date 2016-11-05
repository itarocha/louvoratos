<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

use Validator;
use Session;

class AjaxController extends Controller
{
    // Injeta o DAO no construtor
    public function __construct()
    {
      //$this->middleware('auth')->except('ajaxbairrosporcidade');
    }

    public function carregarcifra(Request $request, Response $response){

      //dd('entrou');
      $cifra = $request->input('cifra');



      $contents = '';
      try
      {
          //dd(storage_path);
          //$contents = File::get($filename);
          $contents = File::get(storage_path('app/local/'.$cifra));
      }
      catch (Illuminate\Filesystem\FileNotFoundException $exception)
      {
          $contents = "The file doesn't exist";
      }

      //dd($contents);

      //$contents = 'aaaaaaaaaa';


      //dd($retorno);

      //$retorno = '<option value="">Achou...'.$id_cidade.'</option>';
      //$retorno = 'Itamar';
      //return response()->json($contents,200);
      //return $contents;

      $responsecode = 200;

      $header = array (
              'Content-Type' => 'application/json; charset=UTF-8',
              'charset' => 'utf-8'
          );

      return response()->json($contents , $responsecode, $header, JSON_UNESCAPED_UNICODE);

      //return response()->json($contents,200);
    }
}
// 'end_date' => Carbon::now()->addDays(10)
