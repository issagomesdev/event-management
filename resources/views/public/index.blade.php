<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/styles.css">
    <title>{{ trans('panel.site_title') }} - Eventos </title>
</head>
<body>

    @include('public.partials.header', ['user' => $user])
    
    <section id="events">
        <div class="content">
            <h2>Eventos</h2>
            <div class="items">
                    @foreach ($events as $event)
                    <a href="/event-details/{{ $event->id }}/{{ str_replace(' ', '-', $event->name) }}">
                        <div class="item">
                            @if (isset($event->cover))
                            <div class="cover" style="background-image: url('{{ $event->cover->getUrl() }}');">
                            </div>
                            @else 
                            <div class="cover default" style="background-image: url('{{ asset('images/logo.png') }}');">
                            </div>
                            @endif
                            <div class="info">
                                <h3>{{ $event->name }}</h3>
                                <p>Inicio: {{ $event->start }} {{ $event->start_time }}</p>
                                <p>Fim: {{ $event->end }} {{ $event->end_time }}</p>
                            </div>
                        </div>
                    </a>
                    @endforeach
            </div>
            {{-- <div class="pagination"> </div> --}}
        </div>
    </section>

    {{-- <script>

        const url = "{{Request::url()}}"
        const next = {{ $events->currentPage() }} == {{ $events->lastPage() }}? 0 :
        ({{ $events->lastPage() }} - {{ $events->currentPage() }}) >= 3? 3 : 
        ({{ $events->lastPage() }} - {{ $events->currentPage() }});
    
    
        const previus = {{ $events->currentPage() }} == 1? 0 :
        ({{ $events->currentPage() }} - 1) >= 3? 3 : 
        ({{ $events->currentPage() }} - 1);
    
        const currentPage = "{{ $events->currentPage() }}"
        const lastPage = "{{ $events->lastPage() }}"
        const nextPages = []
        const previusPages = []
    
        for(let i = ({{ $events->currentPage() }} + 1); i <= ({{ $events->currentPage() }} + next); i++) {
            nextPages.push([i]);
        }
    
        for(let i = ({{ $events->currentPage() }} - 1); i >= ({{ $events->currentPage() }} - previus); i--) {
            previusPages.push([i]);
        }
    
    </script>
    <script src="/js/page.js"> </script> --}}
    
</body>
</html>
