@can($viewGate)
    <a class="btn btn-xs btn-primary"
       @if(auth()->user()->is_admin)
            href="{{ route('admin.' . $crudRoutePart . '.show', $row->id) }}"
       @else
            href="{{ route('employee.' . $crudRoutePart . '.show', $row->id) }}"
       @endif
    >
        {{ trans('global.view') }}
    </a>
@endcan

@can($editGate)
    <a class="btn btn-xs btn-info"
       @if(auth()->user()->is_admin)
            href="{{ route('admin.' . $crudRoutePart . '.edit', $row->id) }}"
       @else
            href="{{ route('employee.' . $crudRoutePart . '.edit', $row->id) }}"
       @endif
       >
        {{ trans('global.edit') }}
    </a>
@endcan
@can($deleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.destroy', $row->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="DELETE">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
    </form>
@endcan
