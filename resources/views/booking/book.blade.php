@extends('app')

@section('content')

<div class="container">
	@if (!session()->has('user'))
		<h3> Please <a href="/auth/login"> Login </a> first </h3>
	@else
    
    <p align="center"><strong>{{ $message or ' ' }}</strong></p>

	{!! Form::open(array('url' => 'getHalls', 'method' => 'GET')) !!}
    	
    	<div class="form-group">
    		<label for="location"> Location </label>
            <select class="form-control" name="location" id="location" required> 
            <option value="" selected disabled>LHC/ORION/CSE</option>
            <option>LHC</option>
            <option>ORION</option>
            <option>CSE</option>
            </select>
    		<!-- <input type="text" class="form-control" name="location" id="location" placeholder="LHC/ORION/CSE" required> -->
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