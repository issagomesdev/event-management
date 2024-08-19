<link rel="stylesheet" href="/css/header.css">
<script src="https://code.iconify.design/iconify-icon/2.1.0/iconify-icon.min.js"></script>

@php $eventID = null; @endphp

@if (request()->is('event-details/*'))
    @php $eventID = request()->segment(2); @endphp
@endif

<header>
    <a class="logo" href="/">
        <img src="{{ asset('images/logo.png') }}" alt="Listinha VIP">
    </a>

    @if($user && $user->id)
    <section id="loggedIn" onclick="openUserMenu()">
        <iconify-icon icon="mdi:user-circle"></iconify-icon>
        <span>{{ $user->name }} {{ $user->surname }}</span>

        <div class="userMenu">
            <ul>
                <li>
                    <a href="/customer/logout">
                        <iconify-icon icon="icomoon-free:exit" ></iconify-icon>
                        <span>Sair</span>
                    </a>
                </li>
            </ul>
        </div>
    </section>
    @else
    <section id="not-loggedIn">
        <a href="/customer/login{{$eventID? '?eventID='.$eventID : ''}}" style="margin-right: 1em;">Login</a>
        <a href="/customer/register{{$eventID? '?eventID='.$eventID : ''}}">Cadastre-se</a>
    </section>
    @endif

</header>

<script>
    function openUserMenu() {
        const userMenu = document.querySelector('.userMenu');
        if(userMenu.classList.contains('show')){
            userMenu.classList.remove('show')
        } else {
            userMenu.classList.add('show')
        }
    }
</script>