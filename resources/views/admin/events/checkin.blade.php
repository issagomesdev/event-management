@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        CheckIn do Evento
    </div>

    <table class="table table-bordered table-striped" id="full-data">
        <tbody>
            @foreach ($attendanceListFull as $key => $item)
            <tr>
                <td>
                    {{$item->name}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="card-body">
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

                    <div class="check-filter">
                        <label for="check-filter"> filtrar por</label>
                        <select name="check-filter" onchange="changeFilter(this.value)">
                            <option value="all">Todos</option>
                            <option value=1>Comparecem</option>
                            <option value=0>Não Compareceram</option>
                        </select>
                    </div>

                    <div class="field-filter">
                        <label for="abc-filter"> filtrar pela letra</label>
                        <select name="abc-filter" onchange="changeFilterABC(this.value)">
                            <option value="all">Todos</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>
                            <option value="P">P</option>
                            <option value="Q">Q</option>
                            <option value="R">R</option>
                            <option value="S">S</option>
                            <option value="T">T</option>
                            <option value="U">U</option>
                            <option value="V">V</option>
                            <option value="W">W</option>
                            <option value="X">X</option>
                            <option value="Y">Y</option>
                            <option value="Z">Z</option>
                        </select>
                    </div>
    
                    <div class="field-filter">
                        <label for="search"> Pesquisar </label>
                        <input type="search" name="search" oninput="changeSearch(this.value)">
                    </div>
                </div>
            </div>
            <div class="list">
                @foreach ($attendanceList as $list)
                <div class="item">
                    <h4>
                        @if (count($list->guests) > 0)
                            <iconify-icon class="show-guests" onclick="showGuests(this)" icon="bxs:right-arrow"></iconify-icon>
                        @endif
                        <p>{{$list->name}} {{$list->surname}}
                            @if ($list->checkin)
                            <iconify-icon icon="icon-park-solid:check-one"></iconify-icon>
                            <button id="check" onclick="checkIn(this, {{$list->id}}, 0, null)"> Desfazer CheckIn </button>
                            @else
                            <iconify-icon icon="ic:round-pending"></iconify-icon>
                            <button id="pending" onclick="checkIn(this, {{$list->id}}, 1, null)"> Fazer CheckIn </button>
                            @endif
                        </p>
                    </h4>
                    @if (count($list->guests) > 0)
                    <div class="guests">
                        @foreach ($list->guests as $guest)
                        <div class="guest">
                            <p>{{$guest->guest}}
                                @if ($guest->checkin)
                                <iconify-icon icon="icon-park-solid:check-one"></iconify-icon>
                                <button id="check" onclick="checkIn(this, {{$list->id}}, 0, {{$guest->id}})"> Desfazer CheckIn </button>
                                @else
                                <iconify-icon icon="ic:round-pending"></iconify-icon>
                                <button id="pending" onclick="checkIn(this, {{$list->id}}, 1, {{$guest->id}})"> Fazer CheckIn </button>
                                @endif
                            </p>
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
@endsection
<script src="/js/jspdf/jspdf.umd.js"></script>
<script src="/js/jspdf/jspdf.plugin.autotable.js"></script>

<script>
    const eventID = {{ $event->id }};
    let groupby = 'clients';
    let orderby = 'id';
    let filter = 'all';
    let filterABC = 'all';
    let search = ''

    function changeFilter(value) {
        filter = value;
        reloadList() 
    }

    function changeFilterABC(value) {
        filterABC = value;
        reloadList() 
    }

    function changeSearch(value) {
        search = value;
        reloadList() 
    }

    let list = [
                @foreach ($attendanceList as $key => $list)
                {
                    id: {{$key+1}},
                    customerID: {{$list->id}},
                    name: "{{$list->name}} {{$list->surname}}",
                    checkin: {{$list->checkin}},
                    guest: [
                    @foreach ($list->guests as $Gkey => $guest)
                           {
                            id: {{$Gkey+1}},
                            guestID: {{$guest->id}},
                            name: "{{$guest->guest}}",
                            checkin: {{$guest->checkin}}
                           }, 
                    @endforeach
                    ],
                },
                @endforeach
    ];
            
    let listFull = [
                @foreach ($attendanceListFull as $key => $list)
                {
                    id: {{$key+1}},
                    customerID: {{$list->customerID}},
                    customer: '{{$list->customer ?? ''}}',
                    guestID: {{$list->guestID ?? 'null'}},
                    name: "{{$list->name}}",
                    type: "{{$list->type}}",
                    checkin: {{$list->checkin}}
                },
                @endforeach
    ];

    function showGuests(el) {
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
        var table = document.querySelector('table#full-data');
        var rows = Array.from(table.querySelectorAll('tr')).slice(0);

        rows.sort(function (a, b) {
            var firstColumnA = a.querySelector('td').innerText.trim().toLowerCase();
            var firstColumnB = b.querySelector('td').innerText.trim().toLowerCase();
            return firstColumnA.localeCompare(firstColumnB);
        });

        var doc = new jspdf.jsPDF();

        doc.text('Lista de presença - {{$event->name}}', 15, 15);

        var tempTable = document.createElement('table');
        var tbody = document.createElement('tbody');

        rows.forEach(function (row, index) {
            var newRow = row.cloneNode(true);
            var firstColumn = newRow.querySelector('td');
            firstColumn.innerText = (index + 1) + ' - ' + firstColumn.innerText.trim();
            tbody.appendChild(newRow);
        });

        tempTable.appendChild(tbody);

        doc.autoTable({ html: tempTable, startY: 20 });

        doc.save('lista_{{$event->name}}.pdf');

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

        if(orderby === "id"){
           list.sort((a, b) => a.id - b.id);
           listFull.sort((a, b) => a.id - b.id);
        } else {
           list.sort((a, b) => a.name.localeCompare(b.name));
           listFull.sort((a, b) => a.name.localeCompare(b.name));
        }

        let filterItems = JSON.parse(JSON.stringify(groupby === "clients" && filterABC === 'all' && search.trim() === ''? list : listFull));

        if(filterABC !== 'all'){
            filterItems = filterItems.filter(i => i.name.toUpperCase().startsWith(filterABC));
        }

        if(search.trim() !== ''){
            filterItems = filterItems.filter(i => i.name.toLowerCase().includes(search.toLowerCase()));
        }

        if(filter == '1'){

            filterItems = filterItems.filter(item => item.checkin == 1);

            if(groupby === "clients"){
                filterItems.forEach(item => {
                    if(item.guest && item.guest.length > 0){
                        item.guest = item.guest.filter(i => i.checkin == 1)
                    }
                });
            }

        } else if(filter == '0'){

            filterItems = filterItems.filter(item => item.checkin == 0);

            if(groupby === "clients"){
                filterItems.forEach(item => {
                    if(item.guest && item.guest.length > 0){
                        item.guest = item.guest.filter(i => i.checkin == 0)
                    }
                });
            }

        }

        listEl.innerHTML = `${filterItems.map(function(item) {
                        return `<div class="item">
                            <h4>
                            ${item.guest && item.guest.length > 0? '<iconify-icon class="show-guests" icon="bxs:right-arrow" onclick="showGuests(this)"></iconify-icon>': ''}
                                <p>${item.name}
                                    ${item.checkin? `<iconify-icon icon="icon-park-solid:check-one"></iconify-icon> <button id="check" onclick="checkIn(this, ${item.customerID}, 0, ${item.guestID? item.guestID : null})"> Desfazer CheckIn </button>` : 
                                    `<iconify-icon icon="ic:round-pending"></iconify-icon> <button id="pending" onclick="checkIn(this, ${item.customerID}, 1, ${item.guestID? item.guestID : null})"> Fazer CheckIn </button>` }
                                </p> 
                            </h4>
                            ${item.customer? `<p>convidado de ${item.customer}</p>` : ''}
                            ${item.guest && item.guest.length > 0? `
                            <div  >
                            </div>
                            <div class="guests">
                            ${item.guest.map(function(guest) {
                            return `<div class="guest">
                                    <p>${guest.name}
                                        ${guest.checkin? `<iconify-icon icon="icon-park-solid:check-one"></iconify-icon> <button id="check" onclick="checkIn(this, ${item.customerID}, 0, ${guest.guestID})"> Desfazer CheckIn </button>` : `<iconify-icon icon="ic:round-pending"></iconify-icon> <button id="pending" onclick="checkIn(this, ${item.customerID}, 1, ${guest.guestID})"> Fazer CheckIn </button>` }
                                    </p>
                                </div>`
                            }).join('')}
                            </div>
                            ` : '' }
                            </div>`
                        }).join('')}`
        
    }

    async function checkIn(el, customerID, action, guestID = null) {
        const url = `{{ route('admin.events.toCheckIn', ['id' => ':id', 'eventID' => ':eventID', 'action' => ':action', 'type' => ':type']) }}`
        .replace(':id', guestID? guestID : customerID)
        .replace(':eventID', eventID)
        .replace(':action', action)
        .replace(':type', guestID? 1 : 0);
        
        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            }
        })
        .then(response => response.json())
        .then(data => {
            let element;

            if(el.closest(".guest")){
                element = el.closest(".guest");
            } else {
                element = el.closest(".item");
            }

            const iconEl = element.querySelector('p iconify-icon')
            const buttonEl = element.querySelector('p button')

            if(action){
                    buttonEl.id = "check";
                    buttonEl.setAttribute('onclick', `checkIn(this, ${customerID}, 0, ${guestID? guestID : null})`);
                    buttonEl.innerHTML = "Desfazer CheckIn";
                    iconEl.setAttribute("icon", "icon-park-solid:check-one");
            } else {
                    buttonEl.id = "pending";
                    buttonEl.setAttribute('onclick', `checkIn(this, ${customerID}, 1, ${guestID? guestID : null})`);
                    buttonEl.innerHTML = "Fazer CheckIn";
                    iconEl.setAttribute("icon", "ic:round-pending");
            }

            let indexCustomer = list.findIndex(l => l.customerID === customerID);
            if(guestID){
                let indexGuest = list[indexCustomer].guest.findIndex(l => l.guestID === guestID);
                list[indexCustomer].guest[indexGuest].checkin = action;
            } else {
                list[indexCustomer].checkin = action;
            }

            let findData = listFull.filter(l => l.customerID === customerID);
            
            if(guestID){
                findData.forEach(data => {
                    if(data.guestID === guestID) data.checkin = action;
                });
            } else {
                findData.forEach(data => {
                    if(data.guestID === null) data.checkin = action;
                });
            }

            
        })
        .catch((error) => {
            console.error('There was a problem with the fetch operation:', error);
        });
    }
    

</script>