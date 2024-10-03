@extends('user.layouts.user')

@section('content')
<div class="row">
    <table class="table table-striped table-hover">
        <tbody>
            <tr>
                <th>{{ __('views.admin.users.show.table_header_0') }}</th>
                <td><img src="{{ auth()->user()->avatar ?? asset('default-avatar.png') }}" class="user-profile-image"></td>
            </tr>

            <tr>
                <th>{{ __('views.admin.users.show.table_header_1') }}</th>
                <td>{{ auth()->user()->name }}</td>
            </tr>

            <tr>
                <th>{{ __('views.admin.users.show.table_header_2') }}</th>
                <td>
                    <a href="mailto:{{ auth()->user()->email }}">
                        {{auth()->user()->email }}
                    </a>
                </td>
            </tr>
            <tr>
                <th>{{ __('views.admin.users.show.table_header_3') }}</th>
                <td>{{ auth()->user()->roles->pluck('name')->implode(', ') }}</td>
            </tr>
            <tr>
                <th>{{ __('views.admin.users.show.table_header_4') }}</th>
                <td>
                    @if(auth()->user()->active)
                        <span class="label label-primary">{{ __('views.admin.users.show.active') }}</span>
                    @else
                        <span class="label label-danger">{{ __('views.admin.users.show.inactive') }}</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>{{ __('views.admin.users.show.table_header_5') }}</th>
                <td>
                    @if(auth()->user()->confirmed)
                        <span class="label label-success">{{ __('views.admin.users.show.confirmed') }}</span>
                    @else
                        <span class="label label-warning">{{ __('views.admin.users.show.not_confirmed') }}</span>
                    @endif
                </td>
            </tr>

            <tr>
                <th>{{ __('views.admin.users.show.table_header_6') }}</th>
                <td>{{ auth()->user()->created_at->format('d M Y H:i') }} ({{ auth()->user()->created_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>{{ __('views.admin.users.show.table_header_7') }}</th>
                <td>{{ auth()->user()->updated_at->format('d M Y H:i') }} ({{ auth()->user()->updated_at->diffForHumans() }})</td>
            </tr>

            <tr>
                <th>{{ __('views.admin.users.show.table_header_8') }}</th>
                <td>
                    @if (auth()->user()->last_login)
                        {{ auth()->user()->last_login->format('d M Y H:i') }} ({{ auth()->user()->last_login->diffForHumans() }})
                    @else
                        Never logged in
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>

    {{-- <div class="user-dashboard container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <!-- Kartu untuk menampilkan informasi profil pengguna -->
                <div class="card shadow border-light mb-4">
                    <div class="card-body text-center">
                        <img 
                            src="{{ auth()->user()->avatar }}" 
                            alt="Profile Image" 
                            class="img-fluid rounded-circle mb-3" 
                            style="width: 120px; height: 120px;"
                        >
                        <h2 class="text-primary font-weight-bold">{{ auth()->user()->name }}</h2>
                        <p class="text-muted mt-2">
                            <small>{{ __('Last Login: :date', ['date' => auth()->user()->last_login]) }}</small>
                        </p>
                    </div>
                </div>

                <!-- Kartu untuk menampilkan informasi akun pengguna -->
                <div class="card shadow border-light text-center">
                    <div class="card-body">
                        <h3 class="card-title text-secondary">{{ __('Account Information') }}</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <strong>{{ __('Name:') }}</strong> 
                                <span class="text-muted">{{ auth()->user()->name }}</span>
                            </li>
                            <li class="mb-2">
                                <strong>{{ __('Email:') }}</strong> 
                                <span class="text-muted">{{ auth()->user()->email }}</span>
                            </li>
                            <li class="mb-2">
                                <strong>{{ __('Account Status:') }}</strong> 
                                <span class="badge {{ auth()->user()->confirmed ? 'bg-success' : 'bg-danger' }}">
                                    {{ auth()->user()->confirmed ? __('Confirmed') : __('Unconfirmed') }}
                                </span>
                            </li>
                            <li>
                                <strong>{{ __('Last Login:') }}</strong> 
                                <span class="text-muted">{{ auth()->user()->last_login }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
