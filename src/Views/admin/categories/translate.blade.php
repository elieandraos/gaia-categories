@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>Categories</li>
		    <li class="active">Translate</li>
		</ul>

		<h1 class="h1">Translate Category</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-12">
		{!! Form::model( $category, ['route' => ['admin.categories.translate-store', $category->id, $locale], 'class' => 'form-horizontal', 'role' => 'form']) !!}
			@include('admin.categories._form_translate', ['locale' => $locale])
		{!! Form::close() !!}
	</div>
</div>

@stop