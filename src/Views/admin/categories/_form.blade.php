{!! Form::text('title', (isset($category))?$category->title:null, [ 'class' => 'form-control', 'placeholder' => 'Enter category title'] ) !!}
<br/>
{!! Form::textarea('description', (isset($category))?$category->description:null, [ 'class' => 'form-control richtexteditor', 'id' => 'txt_desc'] ) !!}
<br/>
{!! Form::submit('Save Category', ['class' => 'btn btn-primary btn-trans']) !!}