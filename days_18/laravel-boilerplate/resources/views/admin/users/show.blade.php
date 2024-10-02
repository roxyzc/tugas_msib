@extends('admin.layouts.admin')

@section('title', __('views.admin.users.show.title', ['name' => $user->name]))

@section('content')
    <div class="row">
        <table class="table table-striped table-hover">
            <tbody>
                <tr>
                    <th>{{ __('views.admin.users.show.table_header_0') }}</th>
                    <td><img src="{{ $user->avatar ?? asset('default-avatar.png') }}" class="user-profile-image"></td>
                </tr>

                <tr>
                    <th>{{ __('views.admin.users.show.table_header_1') }}</th>
                    <td>{{ $user->name }}</td>
                </tr>

                <tr>
                    <th>{{ __('views.admin.users.show.table_header_2') }}</th>
                    <td>
                        <a href="mailto:{{ $user->email }}">
                            {{ $user->email }}
                        </a>
                    </td>
                </tr>
                <tr>
                    <th>{{ __('views.admin.users.show.table_header_3') }}</th>
                    <td>{{ $user->roles->pluck('name')->implode(', ') }}</td>
                </tr>
                <tr>
                    <th>{{ __('views.admin.users.show.table_header_4') }}</th>
                    <td>
                        @if($user->active)
                            <span class="label label-primary">{{ __('views.admin.users.show.active') }}</span>
                        @else
                            <span class="label label-danger">{{ __('views.admin.users.show.inactive') }}</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>{{ __('views.admin.users.show.table_header_5') }}</th>
                    <td>
                        @if($user->confirmed)
                            <span class="label label-success">{{ __('views.admin.users.show.confirmed') }}</span>
                        @else
                            <span class="label label-warning">{{ __('views.admin.users.show.not_confirmed') }}</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>{{ __('views.admin.users.show.table_header_6') }}</th>
                    <td>{{ $user->created_at->format('d M Y H:i') }} ({{ $user->created_at->diffForHumans() }})</td>
                </tr>

                <tr>
                    <th>{{ __('views.admin.users.show.table_header_7') }}</th>
                    <td>{{ $user->updated_at->format('d M Y H:i') }} ({{ $user->updated_at->diffForHumans() }})</td>
                </tr>

                <tr>
                    <th>{{ __('views.admin.users.show.table_header_8') }}</th>
                    <td>
                        @if ($user->last_login)
                            {{ $user->last_login->format('d M Y H:i') }} ({{ $user->last_login->diffForHumans() }})
                        @else
                            Never logged in
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
            <a class="btn btn-primary" href="{{ route('admin.users') }}">
                {{ __('views.admin.users.back') }}
            </a>
        </div>
    </div>
@endsection
