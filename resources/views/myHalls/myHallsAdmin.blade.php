@extends('app')

@section('content')

<div class="container">

	<h1> My halls </h1>

	{!! Form::open(array('url' => 'admin/cancelHalls', 'method' => 'POST')) !!}

		<div class="form-group">
			<table class="table table-bordered">
				<thead>
					<tr> 
						<th> Index </th>
						<th> Hall Name </th>
						<th> Start Date </th>
						<th> End Date </th>
						<th> Slot Start Time </th>
						<th> Slot End Time </th>
						<th> Cancel </th>
					</tr>
				</thead>

				<tbody>
					@foreach($data as $key=>$value)
						<tr>
							<td> {{ $key+1 }}</td>
							<td> {{ $value->hallName }}</td>
							<td> {{ $value->startDate }} </td>
							<td> {{ $value->endDate }} </td>
							<td> {{ $value->startTime }} </td>
							<td> {{ $value->endTime }} </td>
							
							<td>
								<input type="checkbox" class="form-control" name="bookIds[]" value="{{ $value->bookingId }}">
							</td>
						</tr>
					@endforeach
				<tbody>
			</table>
		</div>

		<div class="form-group">
			<input type="submit" class="btn btn-primary" value="Cancel Selected Bookings">
		</div>

	{!! Form::close() !!}
	


</div>

@stop