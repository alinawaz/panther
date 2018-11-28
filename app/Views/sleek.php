@layout('layouts.sleek_layout')

	@section('title')
		Sleek Engine
	@endsection

	@section('content')
		For next level templating.
	@endsection

	@section('data')
	<ul>
		@foreach($items as $item)
		<li>{{$item->name}}</li>
		@endforeach
	</ul>
	@endsection

@endlayout