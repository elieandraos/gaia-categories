@if (!count($categories))
	<p class="unfortunate">You haven't created any category yet :(</p>
@else
	{!! Form::hidden('sort-url', $sort_url, ['id' => 'sort-url']) !!}
	 <div class="dd" id="nestable">
        <ul class="dd-list">
			@foreach($categories as $category)
				{{ $category->renderNode($category, $locale) }}
			@endforeach
		</ul>
	</div>
@endif