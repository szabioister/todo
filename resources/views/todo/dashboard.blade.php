@extends('layouts.app')
@section('title', 'Kezdőlap')
@section('content')
<div class="row">
	<div class="col-md-12">
	<div class="row">
		<form class="form-horizontal" method="get" action="{{url('/todo/search')}}">
		<div class="col-md-6"><input type="text" class="form-control" id="keresoszo" name="keresoszo" placeholder="keresés" value="{{$keresoszo}}"></div>
		<div class="col-md-2"><button type="submit" class="btn btn-secondary btn-block">Keresés</button></div>
		</form>
		<div class="col-md-4">
			<form class="form-horizontal" method="get" action="{{url('/todo/setvisible')}}">
			@if($visible == 0)
			<button type="submit" class="btn btn-primary btn-block">Lezártak megjelenítése</button>
			@else
			<button type="submit" class="btn btn-secondary btn-block">Lezártak elrejtése</button>	
			@endif
			</form>
		</div>
	</div>
	</div>
</div>
<br />
<div class="row">
    <div class="col-md-12">
    <ul class="list-group">
    @if($todos != false)
        @foreach ($todos as $todo)
		<li class="list-group-item 
		@if($todo->status == 1)
		lezart
		@endif
		">
			<div><a class="secondary-content" href="{{url('/todo/'.$todo->id)}}"><b>{{$todo->cim}}</b></a><div>{{ writestat($todo->status) }} | {{ edate($todo->created_at) }}</div></div>
			<a class="secondary-content" href="{{url('/todo/'.$todo->id).'/edit'}}">szerkeszt</a> | 
			<a href="#" class="secondary-content" onclick="event.preventDefault(); document.getElementById('delete-form-{{$todo->id}}').submit();">töröl</a>
			<form id="delete-form-{{$todo->id}}" action="{{url('/todo/'.$todo->id)}}" method="POST" style="display: none;">
			{{ method_field('DELETE') }}{{ csrf_field() }}
			</form>
			@if($todo->status == 0)
			| <a class="secondary-content" href="{{url('/todo/'.$todo->id).'/close'}}">lezár</a>
			@endif
		</li>
		@endforeach
	@else
		<li class="list-group-item">Nincs feladat.</li>
	@endif
    </ul>
    </div>
</div>
@endsection