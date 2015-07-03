@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>Categories</li>
		    <li class="active">Manage</li>
		</ul>

		<h1 class="h1">Manage Categories</h1>
	</div>
</div>


<div class="row">
	<div class="col-sm-7">

		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Categories List</h3>
			</div>
			<div class="panel-body">
				<p>Drag and drop categories to change their hierarchy.</p>
				<div id="category-list">
					@include('admin.categories._list')
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm-5">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Add New Category</h3>
			</div>
			<div class="panel-body">
				{!! Form::open( ['route' => ['admin.categories.store']]) !!}
					@include('admin.categories._form')
				{!! Form::close() !!}
			</div>
		</div>


		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Post Types</h3>
			</div>
			<div class="panel-body">
				<p>Set the root category for each post type created,<br/> in order to be populated in their backend form.</p>
				<a href="/admin/categories/roots-post-types" style="text-decoration:underline">Update Post Types Root Categories</a>
			</div>
		</div>


	</div>
</div>


@stop