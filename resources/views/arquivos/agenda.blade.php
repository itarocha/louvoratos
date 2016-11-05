<!-- arquivos.agenda -->
@extends('layouts.default')
@section('content')

<script>
	var indice = -1;
	var musicas;
  $(document).ready(function() {
    musicas = {!! json_encode($musicas) !!};

		if (musicas.length > 0){
			indice = 0;
			carregarMusica(musicas[indice].arquivo_cifra);
		}

		$('#btanterior').click(function() {
				carregarAnterior();
		});

		$('#btproximo').click(function() {
				carregarProximo();
		});
    //var query = {_ json_encode($query) !!};
		//alert(musicas.length);
		//$("#btproximo").click
	});

	var carregarAnterior = function(){
		if ( indice > 0) {
			indice--;
		}
		console.log('carregar '+musicas[indice].arquivo_cifra);
		carregarMusica(musicas[indice].arquivo_cifra);
	}
	var carregarProximo = function(){
		if ( indice < musicas.length-1){
			indice++;
		}
		console.log('carregar '+musicas[indice].arquivo_cifra);
		carregarMusica(musicas[indice].arquivo_cifra);
	}


	var carregarMusica = function(m){
		//console.log('carregar '+m);
		//var m = 'ZZZ.txt';

		$.ajax({
		    url        : '/api/ajax/carregarcifra/',
		    dataType   : 'json',
		    //contentType: 'application/text; charset=UTF-8', // This is the money shot
		    data       : {cifra:m},
		    type       : 'get',
		    success   : function(data) {
		        $('#cifra').html(data);
						//dd('deu certo');
		    }
		});

		// $.get('/api/ajax/carregarcifra/',
    // {
    //   cifra: m
    // }, function(data) {
		// 	  //alert(data);
    //     $('#cifra').html(data);
    // });


	}
</script>
	<div class="row">
		<nav aria-label="...">
			<ul class="pager">
				<li class="previous primary"><a id="btanterior" href="#">
					<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Anterior</a>
				</li>
				<li class="next primary"><a id="btproximo" href="#">Próximo <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
				</li>
			</ul>
		</nav>
		<div class="panel panel-primary">
		  <div class="panel-heading">
				<center><h3 class="panel-title">{{ $model->data }}</h3></center>
		  </div>
		  <div id="cifra" class="panel-body" style='font-family: Menlo,Monaco,Consolas,"Courier New",monospace; font-size:1.2em; white-space: pre; padding-top:0px; margin-top:0px;'>
				{!! $arquivo !!}
		  </div>
		</div>

  </div>

@stop
