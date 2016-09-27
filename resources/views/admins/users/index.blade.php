@extends('admins.master')
@section('title')
    {{ trans('admins/users/names.title_user_page') }}
@endsection
@section('heading')
    {{ trans('admins/users/names.heading_user_page') }}
@endsection
@section('action')
    {{ trans('admins/users/names.action.list_user') }}
@endsection
@section('content')
    <!-- general form elements -->
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('admins/users/names.panel.panel_head_list') }}</h3>
            <a href="{{ route('admin.user.create') }}" class="btn btn-success btn-add"></a>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body">
            <!-- /.box-header -->
            <div class="box-body">
                @include('layout.message')
                {{ Form::open(['route' => 'admin.user.index', 'method' => 'GET', 'class' => 'form-inline']) }}
                    {{ Form::select(config('common.search_key.search_type_key'), $searchTypes, (isset($searchType) ? $searchType : null), ['class' => 'form-control']) }}
                    <div class="input-group">
                        {{ Form::text(config('common.search_key.search_text_key'), (isset($searchText) ? $searchText : null), ['class' =>'form-control',
                        'placeholder' => trans('names.placeholder_search')]) }}
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                            </button>
                        </span>
                    </div>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-default"><i class="fa fa-refresh"></i></a>
                {{ Form::close() }}
                <hr>
                @if ($users->count())
                    <table id="user-lists" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>{{ trans('admins/users/names.label_form.label_name_user') }}</th>
                            <th>{{ trans('admins/users/names.label_form.label_chatwork_id') }}</th>
                            <th>{{ trans('admins/users/names.label_form.label_email_user') }}</th>
                            <th>{{ trans('admins/users/names.label_form.label_avatar_user') }}</th>
                            <th>{{ trans('admins/names.label.label_action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->chatwork_id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td><img src="{{ asset($user->avatar) }}" class="avatar-list"></td>
                                    <td>
                                        <div class="btn-group">
                                            {{
                                                Form::open([
                                                    'route' => ['admin.user.destroy', $user->id],
                                                    'method' => 'DELETE',
                                                    'onsubmit' => 'return confirmDelete("' . trans('messages.confirm.confirm_delete', ['item' => 'user']) . '")'
                                                ])
                                            }}
                                                <a href="{{ route('admin.user.show', ['id' => $user->id]) }}" class="btn btn-primary btn-xs"><i class="fa fa-user"></i></a>
                                                <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i></a>
                                                {{ Form::button('<i class="fa fa-trash-o"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs']) }}
                                            {{ Form::close() }}
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="dataTables_info">
                        {{
                            trans_choice('names.paginations', $users->total(), [
                                'start' => $users->firstItem(),
                                'finish' => $users->lastItem(),
                                'numberOfRecords' => $users->total(),
                            ])
                        }}
                    </div>
                    <div class="pagination pagination-lg">
                        {{ $users->render() }}
                    </div>
                @else
                    <div class="callout callout-info">
                        <h4><i class="icon fa fa-info"></i> {{ trans('messages.infor.infor_name') }}</h4>
                        <p>{{ trans('messages.infor.not_found_lists', ['item' => 'user']) }}</p>
                    </div>
                @endif
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->
@endsection
