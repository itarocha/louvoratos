<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
//use Illuminate\Http\File;
use Validator;
use DB;

use App\DAO\MusicasDAO;
use App\Util\PetraOpcaoFiltro;
use App\Util\PetraInjetorFiltro;

use App\Evento;

class ArquivosController extends BaseController
{
  //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $dao;

    public function __construct(MusicasDAO $dao)
    {
      $this->dao = $dao;
    }

    public function index(Request $request, Response $response){
      $query = new PetraOpcaoFiltro();
      PetraInjetorFiltro::injeta($request, $query);

      $model = $this->dao->listagemComFiltro($query,9);
      // Carrega parâmetros do get (query params)
      foreach ($request->query as $key => $value){
         $model->appends([$key => $value]);
      }

      $response->headers->set('X-Frame-Options', 'SAMEORIGIN', false);

      return view('arquivos.index')
              ->with('model',$model)
              ->with('titulo','Repertório');
    }

    public function agenda(Request $request, Response $response){
      $model = (object)array('data'=>'19/10/2016');

      $contents = '';
      $filename = 'teste.txt';
      try
      {
          //dd(storage_path);
          //$contents = File::get($filename);
          $contents = File::get(storage_path('app/public/'.$filename));
          //dd($contents);
      }
      catch (Illuminate\Filesystem\FileNotFoundException $exception)
      {
          die("The file doesn't exist");
      }

      $evento = $this->getUltimoEvento();
      $musicas = null;
      if ($evento){
        $musicas = $this->getMusicasByEvento($evento->id);
      }

      //dd($musicas);

      return view('arquivos.agenda')
              ->with('model',$model)
              ->with('arquivo',$contents)
              ->with('evento',$evento)
              ->with('musicas',$musicas)
              ->with('titulo','Agenda');
    }

    private function getUltimoEvento(){
      $max = DB::table('eventos')->max('data_evento');
      if ($max) {
        return Evento::where('data_evento','=',$max)->first();
      }
      return null;
    }

    private function getMusicasByEvento($id){
      return DB::table('eventos')
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
              ->where('eventos.id','=',$id)
              ->orderBy('evento_musicas.ordem')
              ->get();
    }


    public function upload(){
      $model = (object)array( 'id'=>0,
                              'descricao'=>'',
                              'artista'=>'',
                              'arquivo_cifra'=>'',
                              'arquivo_mp3'=>'',
                              'arquivo_letra'=>'',
                              'link_youtube'=>'',
                              'link_cifraclub'=>'',
                            );

      return view('arquivos.upload')
            ->with('model',$model)
            ->with('titulo','Upload de Arquivos');
    }

    private function NewGuid() {
      $s = strtoupper(md5(uniqid(rand(),true)));
      return $s;
      // $guidText =
      //     substr($s,0,8) . '-' .
      //     substr($s,8,4) . '-' .
      //     substr($s,12,4). '-' .
      //     substr($s,16,4). '-' .
      //     substr($s,20);
      // return $guidText;
    }

    public function doUpload(Request $request){

      //dd($request->all());

      if ($request->hasFile('arquivo_cifra')){
        $file_cifra = $request->file('arquivo_cifra');

        //dd($request->file('arquivo_cifra'));

        //$retorno = $request->file('arquivo_cifra')->move(storage_path());
        //dd($retorno);

        // $file = $request->file('arquivo_cifra');
        // $extension = $file->getClientOriginalExtension();
        // Storage::disk('local')->put($file->getFilename().'.'.$extension,  $file);
        // $entry = new Fileentry();
        // $entry->mime = $file->getClientMimeType();
        // $entry->original_filename = $file->getClientOriginalName();
        // $entry->filename = $file->getFilename().'.'.$extension;
        //
        // dd($entry);
        //
        // $entry->save();

        //$arquivo_cifra['path'] = $file_cifra->store('local');
        $nome = $this->NewGuid().'.'.$file_cifra->getClientOriginalExtension();

        $arquivo_cifra = array();
        //$arquivo_cifra['md5'] = md5($file_cifra);
        $arquivo_cifra['extensao'] = $file_cifra->getClientOriginalExtension();
        $arquivo_cifra['storage_path'] = storage_path('app/local/');
        $arquivo_cifra['nome_arquivo'] = $nome;
        $xfile = $file_cifra->storeAs('local',$nome, null);
        $arquivo_cifra['xfile'] = $xfile;
        //dd($arquivo_cifra);
        // array:5 [▼
        //   "md5" => "dbe55662463617dc6a5497ee69bb544e"
        //   "novo_nome" => "5A074E924ED3FC191806A56E9DDAD02F"
        //   "extensao" => "txt"
        //   "storage_path" => "D:\projetos_laravel\louvoratos\storage\app"
        //   "nome" => "636ABA4842E40FFE24DF593335257C1F.txt"
        // ]


        //$xfile = $file_cifra->storeAs($path, $this->hashName(), $disk);

        //$xfile = $file_cifra->storeAs($file_cifra, 'itamar.txt', 'public', 'public');

        //$xfile = Storage::putFile('',$file_cifra, 'public');

        //putFile storage_path()


        //dd($file);
        // $arquivo_cifra['mimeType'] = $file_cifra->getClientMimeType();
        // $arquivo_cifra['clientOriginalName'] = $file_cifra->getClientOriginalName();
        // $arquivo_cifra['size'] = $file_cifra->getClientSize().' bytes ';
        // $arquivo_cifra['maxFilesize'] = $file_cifra->getmaxFilesize(); // upload_max_filesize=20M
        // $arquivo_cifra['linkTarget'] = $file_cifra->getLinkTarget();
        // $arquivo_cifra['isValid'] = $file_cifra->isValid();
        // getMaxFilesize( )
        // Returns the maximum size of an uploaded file as configured in php.ini
        // Grava no diretório  .\storage\app\arquivos
        //return response()->json($a,200);
        // $campos = array();
        // $campos['descricao'] = $request->input('descricao');
        // $campos['artista'] = $request->input('artista');
        //return view('arquivo.files');
      }

      //$f = File(storage_path('app/').$arquivo_cifra['path'])->getName();
      //dd($f);

      //dd($arquivo_cifra['path']->fileName());

      if ($request->hasFile('arquivo_mp3')){
        $file_mp3 = $request->file('arquivo_mp3');
        // $arquivo_mp3['path'] = $request->file('arquivo_mp3')->store('local');

        $nome = $this->NewGuid().'.'.$file_mp3->getClientOriginalExtension();

        $arquivo_mp3 = array();
        //$arquivo_cifra['md5'] = md5($file_cifra);
        $arquivo_mp3['extensao'] = $file_mp3->getClientOriginalExtension();
        $arquivo_mp3['storage_path'] = storage_path('app/local/');
        $arquivo_mp3['nome_arquivo'] = $nome;
        $xfile = $file_mp3->storeAs('local',$nome, null);
        $arquivo_mp3['xfile'] = $xfile;

        //dd($arquivo_mp3);

      }

      $campos = [ 'descricao' => $request->input('descricao'),
                  'artista' => $request->input('artista'),
                  'link_cifraclub' => $request->input('link_cifraclub'),
                  'link_youtube' => $request->input('link_youtube'),
                  'arquivo_cifra' => $arquivo_cifra['nome_arquivo'],
                  'arquivo_mp3' => $arquivo_mp3['nome_arquivo']
                ];


      //dd($campos);


      $retorno = $this->dao->insert($campos);

      if ($retorno->id == -1){
        return response()->json(['data'=>[$retorno]],500);
      } else {
        //return response()->json(['data'=>[$retorno]],200);
        return redirect('arquivos');
      }

    }

    // private function validaErros(Array $campos){
    //   $erros = array();
    //   $validator = Validator::make($campos, $this->dao->getRules());
    //
    //    if ($validator->fails()) {
    //      $erros = $validator->errors()->all();
    //    }
    //    return $erros;
    // }

    // GET
    // api/acoes
    // public function index()
    // {
    //   $retorno = $this->dao->listagem();
    //   return response()->json(['data'=>$retorno],200);
    // }

    // GET
    // api/acoes/123
    // public function show($id)
    // {
    //   $retorno = $this->dao->getById($id);
    //   if (!is_null($retorno)) {
    //     return response()->json(['data'=>$retorno],200);
    //   }
    //   return response()->json(['data'=>[]],404);
    // }

    // POST
    // api/acoes {descricao:"texto"}
    public function save(Request $request)
    {



//      $inputs = $request->only([
//        'descricao',
        //'artista',
      // 'diretorio_cifra',
      // 'arquivo_cifra',
      // 'diretorio_mp3',
      // 'arquivo_mp3',
      // 'diretorio_letra',
      // 'arquivo_letra',
      // 'link_youtube',
      // 'link_cifraclub'
//    ]);




      //$arquivos=array();
      if ($request->hasFile('arquivo')){
        $a = array();
        $file = $request->file('arquivo');
        $a['mimeType'] = $file->getClientMimeType();
        $a['clientOriginalName'] = $file->getClientOriginalName();
        $a['size'] = $file->getClientSize().' bytes ';
        $a['maxFilesize'] = $file->getmaxFilesize(); // upload_max_filesize=20M
        $a['linkTarget'] = $file->getLinkTarget();
        $a['isValid'] = $file->isValid();

        // getMaxFilesize( )
        // Returns the maximum size of an uploaded file as configured in php.ini
        // Grava no diretório  .\storage\app\arquivos
        $a['path'] = $request->file('arquivo')->store('arquivos');

        //return response()->json($a,200);


        // $campos = array();
        // $campos['descricao'] = $request->input('descricao');
        // $campos['artista'] = $request->input('artista');

        $campos = [ 'descricao' => $request->input('descricao'),


                    'artista' => 'xis',
                    'arquivo_cifra' => $a['path']
        ];


        echo($campos['descricao']);
        echo($campos['artista']);
        //echo($campos['arquivo_cifra']);
        //dd();

        //$campos['arquivo_cifra'] = $a['path'];

        $retorno = $this->dao->insert($campos);

        if ($retorno->id == -1){
          return redirect('update')->withInput();
          //return response()->json(['data'=>[$retorno]],500);
        } else {
          //return response()->json(['data'=>[$retorno]],200);
          return redirect('arquivos');
        }



      }

      // $erros = $this->validaErros($all);
      // if (count($erros) > 0){
      //     return response()->json([ 'id'=>-1,
      //                               'status_code'=>400,
      //                               'erros'=>$erros]
      //                               ,400);
      // }
    }

    // PUT
    // api/acoes/123 {descricao:"texto"}
    // public function update(Request $request, $id)
    // {
    //   $all = $request->all();
    //
    //   $erros = $this->validaErros($all);
    //   if (count($erros) > 0){
    //       return response()->json([ 'id'=>-1,
    //                                 'status_code'=>400,
    //                                 'erros'=>$erros]
    //                                 ,400);
    //   }
    //
    //   $retorno = $this->dao->update($id,$all);
    //
    //   $status_code = ($retorno->status_code == 204) ? 200 : $retorno->status_code;
    //   $url = ($status_code == 200) ? $request->url() : '';
    //
    //   return response()->json(['data'=>['rota'=>$url,
    //                                     'mensagem'=>$retorno->mensagem]]
    //                             ,$status_code);
    // }

    // DELETE
    // api/acoes/123
    // public function delete($id)
    // {
    //   $retorno = $this->dao->delete($id);
    //   return response()->json(['data'=> ['mensagem'=>$retorno->mensagem]]
    //                           ,$retorno->status_code);
    // }
}


// `'google' => [
// 'driver' => 's3',
//  'key' => 'xxx',
//  'secret' => 'xxx',
//  'bucket' => 'qrnotesfiles',
//  'base_url'=>'https://storage.googleapis.com'
// ],`


//curl -F/--form <name=content> Specify HTTP multipart POST data (H)

// Para isso funcionar, habilite a linha "extension=php_fileinfo.dll" em php.ini.
// Provavelmente na linha 994

// Para mandar via curl
// curl -F "titulo='Arquivo'" -F "arquivo=@d:\temp\file1.jpg" -F "outro=@d:\outrofile.jpg" http://localhost:8000/api/arquivos


// $path = $request->file('avatar')->storeAs(
//     'avatars', $request->user()->id
// );

// $path = Storage::putFileAs(
//     'avatars', $request->file('avatar'), $request->user()->id
// );

// Storage::makeDirectory($directory);
// Storage::deleteDirectory($directory);
// $size = Storage::size('file1.jpg');
// $time = Storage::lastModified('file1.jpg');
//use Illuminate\Http\File;
// Automatically calculate MD5 hash for file name...
//Storage::putFile('photos', new File('/path/to/photo'));

// Manually specify a file name...
//Storage::putFile('photos', new File('/path/to/photo'), 'photo.jpg');
//$contents = Storage::get('file.jpg');
//$exists = Storage::disk('s3')->exists('file.jpg');

// Documentação
// http://v3.golaravel.com/api/class-Symfony.Component.HttpFoundation.File.UploadedFile.html

//dd($request);



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
