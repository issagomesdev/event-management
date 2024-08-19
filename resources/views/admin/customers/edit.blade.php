@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.customer.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.customers.update", [$customer->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.customer.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $customer->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="surname">{{ trans('cruds.customer.fields.surname') }}</label>
                <input class="form-control {{ $errors->has('surname') ? 'is-invalid' : '' }}" type="text" name="surname" id="surname" value="{{ old('surname', $customer->surname) }}" required>
                @if($errors->has('surname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('surname') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.surname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phonenumber">{{ trans('cruds.customer.fields.phonenumber') }}</label>
                <input class="form-control {{ $errors->has('phonenumber') ? 'is-invalid' : '' }}" type="text" name="phonenumber" id="phonenumber" value="{{ old('phonenumber', $customer->phonenumber) }}" required>
                @if($errors->has('phonenumber'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phonenumber') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.phonenumber_helper') }}</span>
            </div>
            {{-- <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.customer.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $customer->email) }}" required>
                @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.email_helper') }}</span>
            </div> --}}
            <div class="form-group">
                <label class="required" for="birthdate">{{ trans('cruds.customer.fields.birthdate') }}</label>
                <input class="form-control date {{ $errors->has('birthdate') ? 'is-invalid' : '' }}" type="text" name="birthdate" id="birthdate" value="{{ old('birthdate', $customer->birthdate) }}" required>
                @if($errors->has('birthdate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('birthdate') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.customer.fields.birthdate_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection