@extends('layouts.app')
@section('title', title_case($todo->cim))
@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-primary">
              <div class="panel-heading"><h3>{{title_case($todo->cim)}} <a href="{{url('/todo/'.$todo->id).'/edit'}}" class="btn btn-warning btn-group-sm pull-right ">Szerkesztés</a></h3>
              </div>
                  <div class="panel-body">
                    {{$todo->description}}
					@if($todo->file != '')
						<div><a href="{{asset('storage/'.$todo->file)}}" target="blank">csatolt file megtekintése</a></div>
					@endif
                  </div>
              <div class="panel-footer">
				{{ writestat($todo->status) }} | {{ edate($todo->created_at) }}
			  </div>    
        </div>
    </div>
</div> 
@endsection