@extends('admin.layout')

@section('content')

<div class="row">
	<div class="col-md-12">
		<!-- Breadcrumb -->
		<ul class="breadcrumb">
		    <li><a href="#">Dashboard</a></li>
		    <li>Categories</li>
		    <li class="active">Configuration</li>
		</ul>

		<h1 class="h1">Post Types Root Categories</h1>
	</div>
</div>


<div class="row">
	<div class="col-sm-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Post Types/Categories</h3>
			</div>
			<div class="panel-body">
				{!! Form::open(['route' => ['admin.categories.roots-store']]) !!}				
					<p>Configure the root category for each post type created.</p>

					<div class="row" style="margin-bottom:15px;">
						<div class="form-group">
				            {!! Form::label('news', 'News', ['class' => 'col-sm-3 control-label']) !!}
				            <div class="col-sm-6">
				                {!! Form::select(
				                    'news', 
				                    ['0' => 'Select category'] + $categories, 
				                    $newsCategoryRoot, 
				                    ['class' => 'form-control', 'id' => 'news']
				                ) !!}    
				            </div>
				        </div>  
			    	</div>

					@foreach($postTypes as $postType)
						<div class="row" style="margin-bottom:15px;">
							<div class="form-group">
					            {!! Form::label('category_id[]', $postType->title, ['class' => 'col-sm-3 control-label']) !!}
					            {!! Form::hidden('post_type_id[]', $postType->id) !!}
					            <div class="col-sm-6">
					                {!! Form::select(
					                    'category_id[]', 
					                    ['0' => 'Select category'] + $categories, 
					                    $postType->getConfiguredRootCategory(), 
					                    ['class' => 'form-control', 'id' => 'category_id[]']
					                ) !!}    
					            </div>
					        </div>  
				    	</div>
				    @endforeach


					<div class="row">
						 <br/>
					    <div class="col-sm-3  col-sm-push-3">
					        <a href="{{ route('admin.categories.list') }}">
					            <button type="button" class="btn btn-default btn-trans btn-full-width" data-toggle="tooltip" data-placement="top" title="Back to categories list">
					                <i class="fa fa-mail-reply"></i> &nbsp; Categories
					            </button>
					        </a>
					    </div>
					    <div class="col-sm-3 col-sm-push-3">
					        {!! Form::submit('Save', ['class' => 'btn btn-primary btn-trans form-control']) !!}
					    </div>
					</div>

				{!! Form::close() !!}
			</div>
		</div>
	</div>
</div>


@stop