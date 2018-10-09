@extends('layouts.app')
 
@section('title', 'Hozzáadás')
 
@section('content')
<div class="row">
    <div class="col-m-6">
        <form class="form-horizontal" method="post" enctype="multipart/form-data" action="{{url('/todo')}}">
            {{ csrf_field() }}
		<div class="form-group">
			<label for="cim" class="col-sm-2 control-label">Cím</label>
			<div class="col-md-5">
				<input type="text" class="form-control" id="cim" name="cim" placeholder="cím" value="{{ old('cim') }}">
				@if ($errors->has('cim'))
					<span class="help-block"><strong>{{ $errors->first('cim') }}</strong></span>
				@endif
			</div>
		</div>
		<div class="form-group">
			<label for="description" class="col-sm-2 control-label">Leírás</label>
			<div class="col-md-5">
				<textarea class="form-control" id="description" name="description" placeholder="leírás" value="{{ old('description') }}"></textarea>
				@if ($errors->has('description'))
					<span class="help-block"><strong>{{ $errors->first('description') }}</strong></span>
				@endif
			</div>
		</div>
		<div class="form-group">
			<label for="file" class="col-md-2 control-label">File</label>
			<div class="col-md-5">
				<input id="file" type="file" class="form-control" name="file">
				@if ($errors->has('file'))
					<span class="help-block">
						<strong>{{ $errors->first('file') }}</strong>
					</span>
				@endif
			</div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-md-5">
				<button type="submit" class="btn btn-default">Hozzáadás</button>
			</div>
		</div>
		</form>
    </div>
</div>
@endsection