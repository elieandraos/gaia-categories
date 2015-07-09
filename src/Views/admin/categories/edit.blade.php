@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>Categories</li>
		    <li class="active">Edit</li>
		</ul>

		<h1 class="h1">Edit Category</h1>
	</div>
</div>


<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Edit Category</h3>
			</div>
			<div class="panel-body">
				{!! Form::model($category, ['route' => ['admin.categories.update', $category->id]]) !!}
					<p>Category Slug: <strong>{!! $category->slug !!}</strong></p><br/>
					@include('admin.categories._form')
				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@stop