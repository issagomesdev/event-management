@extends('layouts.admin')
@section('content')
@can('event_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.events.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.event.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.event.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Event">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.event.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.start') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.end') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.visualization') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.type') }}
                        </th>
                        <th>
                            {{ trans('cruds.event.fields.allow_guests') }}
                        </th>
                    </tr>
                    <tr>
                        <td>
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Event::VISUALIZATION_RADIO as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Event::TYPE_RADIO as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <select class="search" strict="true">
                                <option value>{{ trans('global.all') }}</option>
                                @foreach(App\Models\Event::ALLOW_GUESTS_RADIO as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $key => $event)
                            <td> </td>
                            <td>
                                {{ $event->id ?? '' }}
                            </td>
                            <td>
                                <a href="{{ route('admin.events.show', $event->id) }}">
                                {{ $event->name ?? '' }}
                                </a>
                            </td>
                            <td>
                                {{ $event->start ?? '' }}
                            </td>
                            <td>
                                {{ $event->end ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Event::VISUALIZATION_RADIO[$event->visualization] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Event::TYPE_RADIO[$event->type] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Event::ALLOW_GUESTS_RADIO[$event->allow_guests] ?? '' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Event:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  console.log(table)
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
})

</script>
@endsection