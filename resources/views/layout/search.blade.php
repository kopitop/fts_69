{{ Form::open(['route' => 'admin.subject.index', 'method' => 'GET', 'class' => 'form-inline']) }}
    {{ Form::select(config('common.search_key.search_type_key'), $searchTypes,
    (isset($searchType) ? $searchType : null), ['class' => 'form-control']) }}
    <div class="input-group">
        {{ Form::text(config('common.search_key.search_text_key'), (isset($searchText) ? $searchText : null),
        ['class' =>'form-control', 'placeholder' => trans('names.placeholder_search')]) }}
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit">
                <span class="glyphicon glyphicon-search"></span>
            </button>
        </span>
    </div>
    <a href="{{ route('admin.subject.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i></a>
{{ Form::close() }}
