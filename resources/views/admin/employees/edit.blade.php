@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <div class="form-group">
                <label for="user">Select User</label>
                <select class="form-control" id="user" name="user_id">
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ (isset($employee) && $employee->user ? $employee->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.employee.fields.user_id') }}</label>
                <input class="form-control {{ $errors->has('user_id') ? 'is-invalid' : '' }}" type="number" name="user_id" id="user_id" value="{{ old('user_id', $employee->user_id) }}" required>
                @if($errors->has('user_id'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user_id') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.user_id_helper') }}</span>
            </div>

            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.employee.fields.user') }}
                    </th>
                    <td>
                        {{ $employee->user->name }}
                    </td>
                </tr>
                </tbody>
            </table>

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
