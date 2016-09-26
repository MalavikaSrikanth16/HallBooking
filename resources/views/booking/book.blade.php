@extends('app')

@section('content')

<div class="container">
	@if (Auth::guest())
		<h3> Please <a href="/auth/login"> Login </a> first </h3>
	@else

	{!! Form::open(array('url' => 'getHalls', 'method' => 'GET')) !!}
    	
    	<div class="form-group">
    		<label for="location"> Location </label>
    		<input type="text" class="form-control" name="location" id="location" placeholder="LHC/ORION/CSE" required>
    	</div>

    	<div class="form-group">
    		<label for="location"> Date </label>
    		<input type="date" class="form-control" name="bookDate" id="bookDate" required>
    	</div>

    	<div class="form-group">
    		<input type="submit" class="btn btn-primary form-control" value="Get Halls">
    	</div>


	{!! Form::close() !!}
		
	@endif

</div>

@stop