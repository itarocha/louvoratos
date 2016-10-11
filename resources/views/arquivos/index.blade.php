<!-- cidades.index -->
@extends('layouts.default')
@section('content')

<div>
	<a href="/arquivos/upload" class="btn btn-primary">Upload</a>
</div>
<div class="container-fluid">
	<div class="row">
  @foreach($model as $item)
    <div class="col-sm-6 col-md-4">
      <div class="thumbnail">
        <center>
        <iframe height="150"
          width="300"
          src="http://www.youtube.com/embed/{{ $item->link_youtube }}"
          frameborder="0" allowfullscreen="">
        </iframe>
      </center>
        <div class="caption">
          <h4>{{ $item->descricao }}</h4>
          <h5>{{ $item->artista }}</h5></span>
          <p><a href="{{ $item->link_cifraclub }}" class="btn btn-warning btn-sm" role="button">
								<span class="glyphicon glyphicon-star" aria-hidden="true"></span>
							CifraClub</a>
          	<a href="#" class="btn btn-primary btn-sm" role="button">
							<span class="glyphicon glyphicon-music" aria-hidden="true"></span>
							Letra</a>
            <a href="download/{{ $item->arquivo_mp3 }}/{{ snake_case($item->descricao) }}.mp3" class="btn btn-danger btn-sm" role="button">
							<span class="glyphicon glyphicon-download" aria-hidden="true"></span>
							Donwload</a>
					</p>
        </div>
      </div>
    </div>
  @endforeach
</div>

__$model->links()__
</div>
@stop
