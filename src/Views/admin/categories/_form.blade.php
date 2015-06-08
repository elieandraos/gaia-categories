{!! Form::text('title', (isset($category))?$category->title:null, [ 'class' => 'form-control', 'placeholder' => 'Enter category title'] ) !!}
<br/>
{!! Form::submit('Save Category', ['class' => 'btn btn-primary btn-trans']) !!}