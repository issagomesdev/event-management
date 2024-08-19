@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    Eventos
                </div>
            </div>
                
            <div class="events">
                @foreach ($events as $event)
                    <div class="event">
                        <div class="title">
                            <h2>{{$event->name}}</h2>
                            <div class="menu">   
                                <iconify-icon onclick="showMenu(this)" icon="ic:round-menu"></iconify-icon>
                                <div class="actions hidden">
                                    <a href="{{ route('admin.events.show', $event->id) }}">Visualizar Evento</a>
                                    <a href="{{ route('admin.events.checkin', $event->id) }}">Acessar CheckIn</a>
                                </div>
                            </div>
                        </div>
                        <p> {{$event->start ?? 'em breve'}} {{ $event->start_time }} - {{$event->end ?? 'em breve'}} {{ $event->end_time }} </p>
                        <div class="attendeds">
                            <div class="attended" id="checkIn">
                                <h3>
                                    {{$event->checkIn}}
                                </h3>
                                <p>Compareceram</p>
                            </div>
                            <div class="attended" id="invited">
                                <h3>
                                    {{$event->invited}}
                                </h3>
                                <p>Convidados</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    function showMenu(el) {
        const menu = el.nextElementSibling

        if(menu.classList.contains('hidden')){
            menu.classList.remove('hidden')
        } else {
            menu.classList.add('hidden')
        }
    }
</script>
@endsection

