
{{ $data['title'] }} 


{!! Form::model($data['category'], ['data-remote' => true, 'data-callback' => 'removeCategory', 'class' => 'remote-form', 'route' => ['admin.categories.delete', $data['category']->id]]) !!}
	<a href="#">
		<button type="button" class="btn btn-danger btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Delete Category" 
				onclick="customConfirm( this, 'Are you sure?', 'You will not be able to recover this category.', 'Deleted!', 'The category has been deleted.')" >
			<i class="fa fa-trash-o"></i>
		</button>
	</a>
{!! Form::close() !!}


<a href="{{ route('admin.categories.translate', [$data['category']->id, $data['locale']]) }}">
	<button type="button" class="btn btn-info btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Translate Category">
		<i class="fa fa-refresh"></i>
	</button>
</a>


<a href="{{ $data['edit_url'] }}">
	<button type="button" class="btn btn-info btn-trans btn-xs btn-action " data-toggle="tooltip" data-placement="top" title="Edit Category">
		<i class="fa fa-pencil-square-o"></i>
	</button>
</a>


