@extends('app')

@section('content')

    <p align="center"><strong>{{ $message or ' ' }}</strong></p>
    
    {!! Form::open(array('action' => 'AdminController@bookHalls', 'method' => 'POST')) !!}

        <div class="container">    
        <div class="form-group">  
        <label for="halls"> Select Hall </label>
        
        <select name="halls" class="form-control" id="halls">
            @foreach($halls as $hall)
                <option value="{{$hall['id']}}">{{$hall['name']}}</option> 
            @endforeach
        </select>
        </div>
        <div class="form-group">
    		<label for="startDate"> Start Date </label>
    		<input type="date" class="form-control" name="startDate" id="startDate">
    	</div>

        <div class="form-group">
            <label for="endDate"> End Date </label>
            <input type="date" class="form-control" name="endDate" id="endDate">
        </div>

        <div class="form-group">
            <label for="startTime"> Start time </label>
            <input type="time" class="form-control" name="startTime" id="startTime">
        </div>

        <div class="form-group">
            <label for="endTime"> End time </label>
            <input type="time" class="form-control" name="endTime" id="endTime">
        </div>

        <div class="form-group">
                <input type="submit" class="form-control btn btn-primary" value="Book Halls">

            </div>
        </div>

    {!! Form::close() !!}

@stop