<!-- cidades.index -->
@extends('layouts.default')
@section('content')
<!-- <script>
$(function(){
	$("#descricao").focus();
});
</script> -->
<div>
<form action="/arquivos/upload" method="POST" enctype="multipart/form-data">
   {{ csrf_field() }}
<div class="row">
  <div class="col-md-6">
    <label for="descricao" class="input-label f-left">Descrição:</label>
    <input type="text" class="input-text f-left" id="descricao" name="descricao" value={{$model->descricao}}>
  </div>

  <div class="col-md-6">
    <label for="artista" class="input-label f-left">Artista:</label>
    <input type="text" class="input-text f-left" id="texto" name="artista" value={{$model->artista}}>
    <input type="hidden" id="id" name="id" value={{$model->id}}>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="descricao" class="input-label f-left">Arquivo Cifra:</label>
    <input type="file" class="input-text f-left" id="arquivo_cifra" name="arquivo_cifra">
  </div>
  <div class="col-md-6">
    <label for="descricao" class="input-label f-left">Arquivo MP3:</label>
    <input type="file" class="input-text f-left" id="arquivo_mp3" name="arquivo_mp3">
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <label for="descricao" class="input-label f-left">Link CifraClub:</label>
    <input type="text" class="input-text f-left" id="link_cifraclub" name="link_cifraclub" value={{$model->link_cifraclub}}>
  </div>
  <div class="col-md-6">
    <label for="descricao" class="input-label f-left">Link YouTube:</label>
    <input type="text" class="input-text f-left" id="texto" name="link_youtube" value={{$model->link_youtube}}>
  </div>
</div>

<div class="row">
  <div class="col-md-12 pt-20">
   <input type="submit" id="gravar" name="gravar" class="btn btn-success">
   <a href="/arquivos" class="btn btn-default">Voltar</a>
  </div>
</div>
</form>
</div>
@stop
