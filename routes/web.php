<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', 'ArquivosController@index');
Route::get('/arquivos', 'ArquivosController@index');
Route::get('/arquivos/upload', 'ArquivosController@upload');
Route::post('/arquivos/upload', 'ArquivosController@doUpload');

Route::get('/arquivos/agenda', 'ArquivosController@agenda');


// Download Route
Route::get('/download/{filename}/{nome}', function($filename, $nome)
{

    //dd($nome);
    // Check if file exists in app/storage/file folder
    $file_path = storage_path('app/local/'.$filename);

    //dd($file_path);

    if (file_exists($file_path))
    {
        // Send Download
        return response()->download($file_path, $nome, [
            'Content-Length: '. filesize($file_path),
            'Content-Type: '.'application/mpeg3'
        ]);
    }
    else
    {
        // Error
        exit('Requested file does not exist on our server!');
    }
})
->where('filename', '[A-Za-z0-9\-\_\.]+');
