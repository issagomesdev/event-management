<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/custom.css">
    <title>{{ trans('panel.site_title') }}</title>
</head>
<body>
    @include('public.partials.header', ['user' => $user])
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
</body>
</html>

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