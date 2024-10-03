@extends('admin.layouts.admin')

@section('title', __('views.admin.customers.edit.title', ['name' => $customer->name]))

@section('content')
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        {{ Form::open(['route' => ['admin.customers.update', $customer->id], 'method' => 'put', 'class' => 'form-horizontal form-label-left']) }}

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                {{ __('views.admin.customers.edit.name') }}
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="name" type="text" maxlength="100" value="{{ old('name', $customer->name) }}" class="form-control col-md-7 col-xs-12 @if($errors->has('name')) parsley-error @endif" name="name" required>
                @if($errors->has('name'))
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get('name') as $error)
                    <li class="parsley-required">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="phone">
                {{ __('views.admin.customers.edit.phone') }}
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="phone" type="text" value="{{ old('phone', $customer->phone) }}" class="form-control col-md-7 col-xs-12 @if($errors->has('phone')) parsley-error @endif" name="phone" required>
                @if($errors->has('phone'))
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get('phone') as $error)
                    <li class="parsley-required">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
                {{ __('views.admin.customers.edit.email') }}
                <span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="email" type="email" value="{{ old('email', $customer->email) }}" class="form-control col-md-7 col-xs-12 @if($errors->has('email')) parsley-error @endif" name="email" required>
                @if($errors->has('email'))
                <ul class="parsley-errors-list filled">
                    @foreach($errors->get('email') as $error)
                    <li class="parsley-required">{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
            </div>
        </div>

        <div class="form-group">
            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <a class="btn btn-primary" href="{{ route('admin.customers') }}">{{ __('views.admin.customers.edit.cancel') }}</a>
                <button type="submit" class="btn btn-success">{{ __('views.admin.customers.edit.update') }}</button>
            </div>
        </div>

        {{ Form::close() }}
    </div>
</div>
@endsection
