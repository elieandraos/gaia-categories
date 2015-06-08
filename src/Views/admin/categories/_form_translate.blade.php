<!-- Panel start -->

<div class="row">
    <div class="col-md-2 col-md-push-10">
        <div class="form-group" style="text-align:right;margin-right:0">
            Translating to: {!! Form::select('locale', $locales, $locale, ['class' => 'form-control toggle-language', 'style' => 'width: auto;display:inline']) !!}
            <input type="hidden" value="{!! route('admin.categories.translate', [$category->id, null]) !!}" id="translate-url" />
        </div>
    </div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Required Info</h3>
	</div>
	<div class="panel-body">

		<div class="form-group">
			{!! Form::label('title', 'Title', ['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('title', $category->title, ['class' => 'form-control slug-target']) !!}
            </div>
        </div>

	</div>
</div>
<!-- Panel end -->


<div class="row">
    <div class="col-sm-1  col-sm-push-5">
        <a href="{{ route('admin.categories.list') }}">
            <button type="button" class="btn btn-default btn-trans btn-full-width" data-toggle="tooltip" data-placement="top" title="Back to news list">
                <i class="fa fa-mail-reply"></i> &nbsp; Categories
            </button>
        </a>
    </div>
    <div class="col-sm-1 col-sm-push-5">
        {!! Form::submit('Save Category', ['class' => 'btn btn-primary btn-trans form-control']) !!}
    </div>
</div>