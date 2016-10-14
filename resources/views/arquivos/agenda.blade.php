<!-- arquivos.agenda -->
@extends('layouts.default')
@section('content')

	<div class="row">

		<div class="panel panel-primary">
		  <div class="panel-heading">

				<nav aria-label="...">
				  <ul class="pager">
				    <li class="previous primary"><a href="#">
							<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span> Anterior</a>
						</li>
				    <li class="next primary"><a href="#">Próximo <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span></a>
						</li>
				  </ul>
					<span><center><h3 class="panel-title">{{ $model->data }}</h3></center></span>
				</nav>
		  </div>
		  <div class="panel-body" style='font-family: Menlo,Monaco,Consolas,"Courier New",monospace; font-size:1.2em; white-space: pre;'>
				{!! $arquivo !!}
		  </div>
		</div>

  </div>

@stop
