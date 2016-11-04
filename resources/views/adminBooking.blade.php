@extends('app')

@section('content')

<div class="container">
	@if (Auth::guest())
		<h3> Please <a href="/auth/login"> Login </a> first </h3>
	@else

    <p align="center"><strong>{{ $message or ' ' }}</strong></p>

	{!! Form::open(array('url' => 'getadminhalls', 'method' => 'GET')) !!}
    	
    	<div class="form-group">
    		<label for="location"> Location </label>
    		<select class="form-control" name="location" id="location" required> 
            <option value="" selected disabled>LHC/ORION/CSE</option>
            <option>LHC</option>
            <option>ORION</option>
            <option>CSE</option>
            </select>
    	</div>

    	<div class="form-group">
    		<input type="submit" class="btn btn-primary form-control" value="Get Halls">
    	</div>


	{!! Form::close() !!}
		
	@endif

</div>
@stop