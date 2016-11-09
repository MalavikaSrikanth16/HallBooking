@extends('app')

@section('content')

	{!! Form::open(array('action' => 'BookingController@bookHalls', 'method' => 'POST')) !!}
<style>
#adminbooked{
	background-color: red;
	width: 15px;
	height:15px;
	margin-top: 13px;
	margin-bottom: 10px;
	margin-left: 10px;
	border-radius:3px;
}
#facultybooked{
	background-color: yellow;
	width: 15px;
	height:15px;
	margin-top: 13px;
	margin-bottom: 10px;
	margin-left: 10px;
	border-radius:3px;

}
</style>
		<div class="container">

			<div class="form-group">
				<h3> {{ $location }} halls for the date </h3>
				<input type="date" class="form-control" name="date" value="{{ $date }}" readonly>
			</div>

			<div class="form-group">

					<div class="panel panel-primary">
			  			<div class="panel-heading">Available halls at {{ $location }}</div>
			  			<div class="panel-body">
			    			<ul class="list-group">
			    				@foreach($times as $key=>$value)
			    					<li class="list-group-item"> {{ $key }} 
			    						<ul class="list-inline">
			    							@for($i=0,$j=0,$k=0;$i<count($times[$key]);$i++)
			    								@if($j<count($adminBookedSlots[$key]) && $i==($adminBookedSlots[$key][$j]-1))
		    										
		    										<li class="list-group-item" > 
									                    <div id="adminbooked"></div>
									                    {{ $times[$key][$i] }} 
									                    <?php $j++; ?>
				    							@elseif($k<count($facultyBookedSlots[$key]) && $i==($facultyBookedSlots[$key][$k]-1))
		    										<li class="list-group-item" > 
									                    <div id="facultybooked"></div>
									                    {{ $times[$key][$i] }} 
									                    <?php $k++; ?>
				    							@else
				    								<li class="list-group-item" > 
														<input type="checkbox" class="form-control" name="slot[]" value="{{ ($key).','.($times[$key][$i]) }}">
														{{ $times[$key][$i] }} 
				    								</li>
				    							@endif
			    							@endfor
			    						</ul>
			    					</li>
			    				@endforeach    				
			    			</ul>
			  			</div>
					</div>



			</div>

			<div class="form-group">
				<input type="submit" class="form-control btn btn-primary" value="Book Halls">

			</div>
		</div>

	{!! Form::close() !!}

@stop