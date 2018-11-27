<h1>Welcome to sleek rendering engine</h1>
<p> Let's see how php tags work, {{ "I am echoed from php" }} </p>
<p> I am variable $test from entity with value = {{ $test }} </p>

@if($test == '123')
	<p>It's One Two Three!</p>
@endif 

<ul>
@foreach($items as $item)
	<li>{{ $item}}</li>
@endforeach
</ul>