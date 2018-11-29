@layout('layouts.sleek_layout')

	@section('title')
		Sleek
	@endsection

	@section('content')
		Panther templating engine.
	@endsection

	@section('data')
	<ul>
		@foreach($items as $item)
		<li>{{$item->name}}</li>
		@endforeach
	</ul>
	@endsection

@endlayout