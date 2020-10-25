@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.service.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.services.store") }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group {{ $errors->has('department_id') ? 'has-error' : '' }}">
                <label for="client">{{ trans('cruds.service.fields.department') }}*</label>
                <select name="department_id" id="department" class="form-control" required>
                    @foreach($departments as $id => $department)
                        <option value="{{ $id }}" {{ (isset($service) && $service->department ? $service->department->id : old('department_id')) == $id ? 'selected' : '' }}>{{ $department }}</option>
                    @endforeach
                </select>
                @if($errors->has('department_id'))
                    <em class="invalid-feedback">
                        {{ $errors->first('department_id') }}
                    </em>
                @endif
            </div>

            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.service.fields.name') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.service.fields.name_helper') }}</span>
            </div>

            <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                <label for="price">{{ trans('cruds.service.fields.price') }}</label>
                <input type="number" id="price" name="price" class="form-control" value="{{ old('price', isset($service) ? $service->price : '') }}" step="0.01">
                @if($errors->has('price'))
                    <em class="invalid-feedback">
                        {{ $errors->first('price') }}
                    </em>
                @endif
                <p class="helper-block">
                    {{ trans('cruds.service.fields.price_helper') }}
                </p>
            </div>

            <div class="form-group">
                <a class="btn btn-info" href="{{ route('admin.services.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
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
