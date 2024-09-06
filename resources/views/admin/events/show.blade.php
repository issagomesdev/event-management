@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.event.title') }}
    </div>

    
    <table class="table table-bordered table-striped" id="full-data">
        <tbody>
            @foreach ($attendanceListFull as $key => $item)
            <tr>
                <td>
                    {{$key+1}} - {{$item->name}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.events.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
                <div class="data-actions">
                    @can('event_edit')
                        <a class="btn btn-xs btn-info" href="{{ route('admin.events.edit', $event->id) }}">
                            {{ trans('global.edit') }}
                        </a>
                    @endcan
    
                    @can('event_delete')
                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                        </form>
                    @endcan
                </div>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.id') }}
                        </th>
                        <td>
                            {{ $event->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.photo') }}
                        </th>
                        <td>
                            @foreach($event->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.cover') }}
                        </th>
                        <td>
                            @if($event->cover)
                                <a href="{{ $event->cover->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $event->cover->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.name') }}
                        </th>
                        <td>
                            {{ $event->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.start') }}
                        </th>
                        <td>
                            {{ $event->start }} {{ $event->start_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.end') }}
                        </th>
                        <td>
                            {{ $event->end }} {{ $event->end_time }}
                        </td>
                    </tr><tr>
                        <th>
                            {{ trans('cruds.event.fields.country') }}
                        </th>
                        <td>
                            {{ $event->country }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.state') }}
                        </th>
                        <td>
                            {{ $event->state }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.city') }}
                        </th>
                        <td>
                            {{ $event->city }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.neighborhood') }}
                        </th>
                        <td>
                            {{ $event->neighborhood }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.street') }}
                        </th>
                        <td>
                            {{ $event->street }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.number') }}
                        </th>
                        <td>
                            {{ $event->number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.description') }}
                        </th>
                        <td>
                            {!! $event->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.rules') }}
                        </th>
                        <td>
                            {!! $event->rules !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.link') }}
                        </th>
                        <td>
                            {{ $event->link }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.link_instruction') }}
                        </th>
                        <td>
                            {{ $event->link_instruction }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.pixel') }}
                        </th>
                        <td>
                            {{ $event->pixel }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.whatsapp') }}
                        </th>
                        <td>
                            {{ $event->whatsapp }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.whatsappmessage') }}
                        </th>
                        <td>
                            {{ $event->whatsappmessage }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.visualization') }}
                        </th>
                        <td>
                            {{ App\Models\Event::VISUALIZATION_RADIO[$event->visualization] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Event::TYPE_RADIO[$event->type] ?? '' }}
                        </td>
                    </tr>
                    @if ($event->type === '0')
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.capacity') }}
                        </th>
                        <td>
                            {{ $event->capacity }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.allow_guests') }}
                        </th>
                        <td>
                            {{ App\Models\Event::ALLOW_GUESTS_RADIO[$event->allow_guests] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            URL
                        </th>
                        <td>
                            <a href="/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}">{{ rtrim(url('/'), '/') }}/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}</a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            URL da lista
                        </th>
                        <td>
                            <a href="/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}/list?user=Listinhagjota&password=gjotalistinha05">{{ rtrim(url('/'), '/') }}/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}/list?user=Listinhagjota&password=gjotalistinha05</a>
                        </td>
                    </tr>
                    <tr>

                        <th>
                            URL do checkin
                        </th>
                        <td>
                            <a href="/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}/checkin?user=Listinhagjota&password=gjotalistinha05">{{ rtrim(url('/'), '/') }}/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}/checkin?user=Listinhagjota&password=gjotalistinha05</a>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.created_at') }}
                        </th>
                        <td>
                            {{ $event->created_at }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.event.fields.updated_at') }}
                        </th>
                        <td>
                            {{ $event->updated_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="attendances">
                <div class="infos">
                    <h2>Lista de presença do evento</h2>
                    <div class="actions">
                        <div class="save" id="toPDF" onclick="exportToPDF()">
                            <iconify-icon icon="ic:round-file-download"></iconify-icon>
                            <span>Baixar PDF</span>
                        </div>
                        <div class="save" id="toCSV" onclick="exportToCSV()">
                            <iconify-icon icon="ph:file-csv-duotone"></iconify-icon>
                            <span>Exportar CSV</span>
                        </div>
                        <div class="save" id="groupBy_clients" onclick="groupList(this)">
                            <iconify-icon icon="heroicons:user-group-16-solid"></iconify-icon>
                            <span>Agrupar por nome</span>
                        </div>
                        <div class="save" id="orderBy_id" onclick="orderList(this)">
                            <iconify-icon icon="mdi:order-alphabetical-ascending"></iconify-icon>
                            <span>Ordenação Alfabetica</span>
                        </div>
                    </div>
                </div>
                <div class="list">
                    @foreach ($attendanceList as $list)
                        <div class="item">
                            <h4>
                                <p>{{$list->name}} {{$list->surname}} 
                                    @if (count($list->guests) > 0)
                                    <iconify-icon class="show-guests" onclick="showGuests(this)" icon="bxs:right-arrow"></iconify-icon> 
                                    @endif
                                </p>
                            </h4>
                                @if (count($list->guests) > 0)
                                <div class="guests">
                                    @foreach ($list->guests as $guest)
                                    <div class="guest">
                                        <p>{{$guest->guest}}</p>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                        </div>
                    @endforeach
                </div>
                <h2>{{$attendanceCheckInCount}} Compareceram de {{$attendanceCount}} Convidados</h2>
            </div>
        </div>
    </div>
</div>
<script src="/js/jspdf/jspdf.umd.js"></script>
<script src="/js/jspdf/jspdf.plugin.autotable.js"></script>

<script>

    let groupby = 'clients';
    let orderby = 'id';

    function showGuests(el) {
        
        console.log(el, el.closest(".item"))
        var showEl = el.closest(".item").querySelector(".guests");
        if(showEl.classList.contains('show')){
            showEl.classList.remove('show');
            el.icon="bxs:right-arrow";
        } else {
            showEl.classList.add('show')
            el.icon="bxs:down-arrow";
        }
    }

	function exportToPDF() {
		var doc = new jspdf.jsPDF()

        doc.text('Lista de presença - {{$event->name}}', 15, 15);
		doc.autoTable({ html: 'table#full-data', startY: 20 })

		doc.save('lista_{{$event->name}}.pdf')
	}

	function exportToCSV() {
		var table = document.querySelector('table#full-data');
		var csvData = [
            @foreach ($attendanceListFull as $key => $item)
            {
                Nome: "{{$item->name}}"
            },
            @endforeach
        ]
        
        const header = Object.keys(csvData[0]).join(',') + '\n';
        const rows = csvData.map(obj => Object.values(obj).join(',')).join('\n');
    	const blob = new Blob([header + rows], { type: 'text/csv' });
		const link = document.createElement('a');
		link.href = URL.createObjectURL(blob);
		link.download = 'lista_{{$event->name}}.csv';
		document.body.appendChild(link);
    	link.click();
	}

    function groupList(el) {
        if(el.id === "groupBy_clients") {
            el.id = "groupBy_name";
            groupby = "name";
        } else {
            el.id = "groupBy_clients";
            groupby = "clients";
        }

        reloadList()
    }

    function orderList(el) {

        if(el.id === "orderBy_id") {
            el.id = "orderBy_abc";
            orderby = "abc";
        } else {
            el.id = "orderBy_id";
            orderby = "id";
            
        }
        
        reloadList()
    }

    function reloadList() {
        const listEl = document.querySelector('.list');

        let list = [];

        if(groupby === "clients") {
            list = [
                @foreach ($attendanceList as $key => $list)
                {
                    id: {{$key+1}},
                    name: "{{$list->name}} {{$list->surname}}",
                    guest: [
                    @foreach ($list->guests as $key => $guest)
                           {
                            id: {{$key+1}},
                            name: "{{$guest->guest}}",
                           }, 
                    @endforeach
                    ],
                },
                @endforeach
            ]
        } else {
            list = [
                @foreach ($attendanceListFull as $key => $list)
                {
                    id: {{$key+1}},
                    name: "{{$list->name}}",
                    type: "{{$list->type}}"
                },
                @endforeach
            ]
        }

        if(orderby === "id"){
            list.sort((a, b) => a.id - b.id);
        } else {
            list.sort((a, b) => a.name.localeCompare(b.name));
        }

        listEl.innerHTML = `${list.map(function(item) {
                        return `<div class="item">
                            <h4> <p>${item.name} 
                                ${item.guest && item.guest.length > 0? '<iconify-icon class="show-guests" onclick="showGuests(this)" icon="bxs:right-arrow"></iconify-icon>' : ''}
                                </p> 
                            </h4>
                            ${item.guest && item.guest.length > 0? `
                            <div class="guests">
                            ${item.guest.map(function(guest) {
                            return `<div class="guest">
                                    <p>${guest.name}</p>
                                </div>`
                            }).join('')}
                            </div>
                            ` : '' }
                            </div>`
                        }).join('')}`
        
    }

</script>

@endsection