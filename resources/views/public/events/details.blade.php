<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/css/events/styles.css?v=1.1">
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <title>{{ trans('panel.site_title') }}</title>
</head>
<body>
    @include('public.partials.header', ['user' => $user])
    <div class="warning-container" id="sucess">
        <iconify-icon icon="iconoir:check-circle-solid" id="sucess"></iconify-icon>
        <iconify-icon icon="material-symbols-light:error-rounded" id="error"></iconify-icon>
        <div class="message">
            <h3></h3>
            <p></p>
        </div>
    </div>
    <div class="login-model" style="display:{{ request()->has('login_model')? 'flex' : 'none' }}">
        <div class="form">
            <form method="POST" action="{{ route('confirm.attendance.event', $event->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                   <label for="whatsApp">Numero do whatsApp</label>
                   <div class="associate">
                      <span>+</span>
                      <input name="code" id="code" value="{{ old('code') ?? $code ?? '55' }}" required>
                      @php $selectedDdd = old('ddd') ?? $ddd ?? '85'; @endphp
                      <select name="ddd" id="ddd">
                         <option value="68" {{ $selectedDdd == '68' ? 'selected' : '' }}>68</option>
                         <option value="96" {{ $selectedDdd == '96' ? 'selected' : '' }}>96</option>
                         <option value="92" {{ $selectedDdd == '92' ? 'selected' : '' }}>92</option>
                         <option value="97" {{ $selectedDdd == '97' ? 'selected' : '' }}>97</option>
                         <option value="91" {{ $selectedDdd == '91' ? 'selected' : '' }}>91</option>
                         <option value="93" {{ $selectedDdd == '93' ? 'selected' : '' }}>93</option>
                         <option value="94" {{ $selectedDdd == '94' ? 'selected' : '' }}>94</option>
                         <option value="69" {{ $selectedDdd == '69' ? 'selected' : '' }}>69</option>
                         <option value="95" {{ $selectedDdd == '95' ? 'selected' : '' }}>95</option>
                         <option value="63" {{ $selectedDdd == '63' ? 'selected' : '' }}>63</option>
                         <option value="82" {{ $selectedDdd == '82' ? 'selected' : '' }}>82</option>
                         <option value="71" {{ $selectedDdd == '71' ? 'selected' : '' }}>71</option>
                         <option value="73" {{ $selectedDdd == '73' ? 'selected' : '' }}>73</option>
                         <option value="74" {{ $selectedDdd == '74' ? 'selected' : '' }}>74</option>
                         <option value="75" {{ $selectedDdd == '75' ? 'selected' : '' }}>75</option>
                         <option value="77" {{ $selectedDdd == '77' ? 'selected' : '' }}>77</option>
                         <option value="85" {{ $selectedDdd == '85' ? 'selected' : '' }}>85</option>
                         <option value="88" {{ $selectedDdd == '88' ? 'selected' : '' }}>88</option>
                         <option value="98" {{ $selectedDdd == '98' ? 'selected' : '' }}>98</option>
                         <option value="99" {{ $selectedDdd == '99' ? 'selected' : '' }}>99</option>
                         <option value="83" {{ $selectedDdd == '83' ? 'selected' : '' }}>83</option>
                         <option value="81" {{ $selectedDdd == '81' ? 'selected' : '' }}>81</option>
                         <option value="87" {{ $selectedDdd == '87' ? 'selected' : '' }}>87</option>
                         <option value="86" {{ $selectedDdd == '86' ? 'selected' : '' }}>86</option>
                         <option value="89" {{ $selectedDdd == '89' ? 'selected' : '' }}>89</option>
                         <option value="84" {{ $selectedDdd == '84' ? 'selected' : '' }}>84</option>
                         <option value="79" {{ $selectedDdd == '79' ? 'selected' : '' }}>79</option>
                         <option value="61" {{ $selectedDdd == '61' ? 'selected' : '' }}>61</option>
                         <option value="62" {{ $selectedDdd == '62' ? 'selected' : '' }}>62</option>
                         <option value="64" {{ $selectedDdd == '64' ? 'selected' : '' }}>64</option>
                         <option value="65" {{ $selectedDdd == '65' ? 'selected' : '' }}>65</option>
                         <option value="66" {{ $selectedDdd == '66' ? 'selected' : '' }}>66</option>
                         <option value="67" {{ $selectedDdd == '67' ? 'selected' : '' }}>67</option>
                         <option value="27" {{ $selectedDdd == '27' ? 'selected' : '' }}>27</option>
                         <option value="28" {{ $selectedDdd == '28' ? 'selected' : '' }}>28</option>
                         <option value="31" {{ $selectedDdd == '31' ? 'selected' : '' }}>31</option>
                         <option value="32" {{ $selectedDdd == '32' ? 'selected' : '' }}>32</option>
                         <option value="33" {{ $selectedDdd == '33' ? 'selected' : '' }}>33</option>
                         <option value="34" {{ $selectedDdd == '34' ? 'selected' : '' }}>34</option>
                         <option value="35" {{ $selectedDdd == '35' ? 'selected' : '' }}>35</option>
                         <option value="37" {{ $selectedDdd == '37' ? 'selected' : '' }}>37</option>
                         <option value="38" {{ $selectedDdd == '38' ? 'selected' : '' }}>38</option>
                         <option value="21" {{ $selectedDdd == '21' ? 'selected' : '' }}>21</option>
                         <option value="22" {{ $selectedDdd == '22' ? 'selected' : '' }}>22</option>
                         <option value="24" {{ $selectedDdd == '24' ? 'selected' : '' }}>24</option>
                         <option value="11" {{ $selectedDdd == '11' ? 'selected' : '' }}>11</option>
                         <option value="12" {{ $selectedDdd == '12' ? 'selected' : '' }}>12</option>
                         <option value="13" {{ $selectedDdd == '13' ? 'selected' : '' }}>13</option>
                         <option value="14" {{ $selectedDdd == '14' ? 'selected' : '' }}>14</option>
                         <option value="15" {{ $selectedDdd == '15' ? 'selected' : '' }}>15</option>
                         <option value="16" {{ $selectedDdd == '16' ? 'selected' : '' }}>16</option>
                         <option value="17" {{ $selectedDdd == '17' ? 'selected' : '' }}>17</option>
                         <option value="18" {{ $selectedDdd == '18' ? 'selected' : '' }}>18</option>
                         <option value="19" {{ $selectedDdd == '19' ? 'selected' : '' }}>19</option>
                         <option value="41" {{ $selectedDdd == '41' ? 'selected' : '' }}>41</option>
                         <option value="42" {{ $selectedDdd == '42' ? 'selected' : '' }}>42</option>
                         <option value="43" {{ $selectedDdd == '43' ? 'selected' : '' }}>43</option>
                         <option value="44" {{ $selectedDdd == '44' ? 'selected' : '' }}>44</option>
                         <option value="45" {{ $selectedDdd == '45' ? 'selected' : '' }}>45</option>
                         <option value="46" {{ $selectedDdd == '46' ? 'selected' : '' }}>46</option>
                         <option value="51" {{ $selectedDdd == '51' ? 'selected' : '' }}>51</option>
                         <option value="53" {{ $selectedDdd == '53' ? 'selected' : '' }}>53</option>
                         <option value="54" {{ $selectedDdd == '54' ? 'selected' : '' }}>54</option>
                         <option value="55" {{ $selectedDdd == '55' ? 'selected' : '' }}>55</option>
                         <option value="47" {{ $selectedDdd == '47' ? 'selected' : '' }}>47</option>
                         <option value="48" {{ $selectedDdd == '48' ? 'selected' : '' }}>48</option>
                         <option value="49" {{ $selectedDdd == '49' ? 'selected' : '' }}>49</option>
                     </select>
                       <input style="padding: 10px;" name="number" id="number" value="{{ old('number') ?? $number ?? '' }}" required placeholder="9 9999-9999">
                   </div>
                   @if($errors->has('phonenumber'))
                      <div class="invalid-feedback" style="color: #ff0000">
                            {{ $errors->first('phonenumber') }}
                      </div>
                   @endif
                </div>
                <div class="form-group">
                   <label for="name">Nome</label>
                   <div class="associate">
                      <input style="padding: 10px;" name="name" id="name" value="{{ old('name') }}" required>
                   </div>
                   @if($errors->has('name'))
                      <div class="invalid-feedback" style="color: #ff0000">
                            {{ $errors->first('name') }}
                      </div>
                   @endif
                </div>
                <div class="form-group">
                   <label for="surname">Sobrenome</label>
                   <div class="associate">
                      <input style="padding: 10px;" name="surname" id="surname" value="{{ old('surname') }}" required>
                   </div>
                   @if($errors->has('surname'))
                      <div class="invalid-feedback" style="color: #ff0000">
                            {{ $errors->first('surname') }}
                      </div>
                   @endif
                </div>
                {{-- <div class="form-group">
                   <label for="birthdate">Data de nascimento</label>
                   <div class="associate">
                      <input style="padding: 10px;" name="birthdate" id="birthdate" value="{{ old('birthdate') ?? $birthdate ?? ''}}" required placeholder="dd/mm/aaaa">
                   </div>
                   @if($errors->has('birthdate'))
                      <div class="invalid-feedback" style="color: #ff0000">
                            {{ $errors->first('birthdate') }}
                      </div>
                   @endif
                </div> --}}
                <input type="hidden" name="phonenumber" id="phonenumber" value="{{ old('phonenumber') ?? $phonenumber ?? '' }}">
                <div class="CTA">
                   <input type="submit" value="Confirmar">
                </div>
             </form>
        </div>
    </div>
    <div class="container">
        <div class="recipient">
            <div class="content">
                <div class="main-info">
                    <h3>{{$event->name}}</h3>
                    <p> {{ $event->start }} {{ $event->start_time }} - {{ $event->end }} {{ $event->end_time }}</p>
                </div>
            </div>
            @if (count($event->photo) > 0)
            <div class="gallery">
                <div class="photos {{ count($event->photo) <= 1? 'lonely' : ''}}">
                    <div class="featured">
                        <img src="{{ $event->photo[0]->getUrl() }}">
                    </div>
                    @if (count($event->photo) > 1)
                    <div class="images">  
                        <div class="items">
                            @foreach ($event->photo as $key => $photo)
                            <img src="{{ $photo->getUrl() }}" draggable="false" onclick="setFeatured(this)" id="i{{$key+1}}">
                            @endforeach
                        </div>
                    </div>
                    <iconify-icon class="controls" icon="uiw:left-circle" id="left"></iconify-icon>
                    <iconify-icon class="controls" icon="uiw:right-circle" id="right"> </iconify-icon>
                    @endif
                </div>
            </div>
            @endif
            @if ($event->description)
            <div class="content">   
                <div class="info">
                    <h3>Descrição</h3>
                    <p>{!! $event->description !!}</p>
                </div>
            </div>
            @endif
            @if ($event->rules)
            <div class="content">   
                <div class="info">
                    <h3>Regulamento</h3>
                    <p>{!! $event->rules !!}</p>
                </div>
            </div>
            @endif
            @if ($event->link)
            <div class="content">   
                <div class="info">
                    <h3>Link</h3>
                    <p>{{$event->link_instruction}} <a href="{{$event->link}}">{{$event->link}}</a></p>
                </div>
            </div>
            @endif
            @if ($event->pixel)
            <div class="content">   
                <div class="info">
                    <h3>Pixel</h3>
                    <p>{{$event->pixel}}</p>
                </div>
            </div>
            @endif
            @if ($open) 
                <div class="attendance" id="attendance">
                    @if ($attendance)

                        @if($event->allow_guests === '1')
                            <div class="guests">
                                <div class="content">
                                    <div class="info">
                                        <h3 id="sucess">Sua presença foi confirmada com sucesso!</h3>
                                        @if ($event->type !== '1' && $event->capacity <= $attendanceCount)
                                            <h4>Este evento atingiu sua capacidade máxima!</h4>
                                        @endif
                                        <h4 style="{{$event->type !== '1' && $event->capacity <= $attendanceCount? 'display: none;' : ''}}">Deseja Incluir amigos(as)?</h4>
                                        @if ($event->type === '1' || $event->capacity > $attendanceCount)
                                        <div class="guest-include">
                                            <input type="text" placeholder="Nome Sobrenome">
                                            <div class="actions">
                                                <div class="action" id="save" onclick="saveGuest()">
                                                    <iconify-icon icon="icon-park-solid:check-one"></iconify-icon>
                                                    <span>incluir</span>
                                                </div>
                                            </div>
                                        </div>
                                        @endif
                                        <h4>Nomes Confirmados:</h4>
                                        <div class="list">
                                            <div class="guest {{$isChecked == 1? "checked" : ""}}">
                                                <p>{{$user->name}} {{$user->surname}} (você)</p>
                                            </div>
                                            @foreach ($guests as $key => $guest)
                                                <div class="guest {{$guest->checkin == 1? "checked" : ""}}" id="i{{$key+1}}">
                                                    <p>{{$guest->guest}}</p>
                                                    <div class="actions">
                                                        @if ($guest->checkin == 0)
                                                        <div class="action" id="delete" onclick="deleteGuest({{$key+1}})">
                                                            <iconify-icon icon="ic:round-delete-sweep"></iconify-icon>
                                                            <span>excluir</span>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($event->type === '1' || $event->capacity > $attendanceCount)
                                            <div class="actions">
                                                {{-- <button id="add-guest" onclick="addGuest()">Adicionar + convidados(as)</button> --}}
                                                @if(count($guests) < 1)
                                                <button id="save-guests" onclick="saveGuests()">Ativar minha lista e finalizar</button>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="content">
                                <div class="info sucess">
                                    <h3 id="sucess">Sua presença foi confirmada com sucesso!</h3>
                                </div>
                            </div>
                        @endif

                    @else

                        @if($event->type === '1' || $event->capacity > $attendanceCount)
                            <form action="{{ route('confirm.attendance.event', $event->id) }}" method="POST" onsubmit="return confirm('Confirmar presença no evento?');" style="display: inline-block;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" id="confirm" value="Confirmar presença">
                            </form>
                        @else
                            <div class="content">
                                <div class="info alert">
                                    <h4>Este evento atingiu sua capacidade máxima!</h4>
                                </div>
                            </div>
                        @endif

                    @endif
                </div>
            @else

                <div class="content">
                    <div class="info alert">
                        @if ($attendance)
                        <h3 id="sucess">Sua presença foi confirmada com sucesso!</h3>
                        @endif
                        <h4>Evento encerrado!</h4>
                    </div>
                </div>

            @endif
            
            <div class="content" style="margin-top: .5em">
                <div class="info">
                    <div class="figure">
                        <div href="https://www.google.com/maps/search/?api=1&query={{$event->number}},{{$event->street}},{{$event->neighborhood}},{{$event->city}},{{$event->state}},{{$event->country}}" class="location">
                            <iconify-icon icon="mingcute:location-fill"></iconify-icon>
                        </div>
                        <div class="info">
                            <h3>Local</h3>
                            <p>{{$event->street}}, {{$event->number}}, {{$event->neighborhood}}, {{$event->city}} - {{$event->state}} {{$event->country}} <span onclick="copyText()">copiar</span></p>
                        </div>
                    </div>
                    {{-- @if ($attendance)
                    <iframe id="map" width="100%" frameborder="0" style="border:0" allowfullscreen></iframe>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<script>

    function getCoordinates() {
            fetch(`https://nominatim.openstreetmap.org/search?q={{$address}}&format=json&limit=1`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.length > 0) {
                            const { lat, lon } = data[0];
                            const map = document.querySelector("iframe#map");
                            map.src = `https://www.openstreetmap.org/export/embed.html?bbox=${lon},${lat},${lon},${lat}&layer=mapnik`
                        } else {
                            console.error('Endereço não encontrado');
                        }
                    })
                    .catch(error =>console.error('Erro:', error));
    }
        
    // @if ($attendance) getCoordinates() @endif

    function warning(title, text, type) {
        const warning = document.querySelector(`.warning-container`);
        warning.id = type;
        warning.querySelector("h3").innerHTML = title;
        warning.querySelector("p").innerHTML = text;
        warning.style.display = "flex";
        setTimeout(() => {
            warning.style.display = "none";
        }, 5000);

        const allow_guests = {{$event->allow_guests}};
        console.log(text, allow_guests)
        if((text == "Presença confirmada com sucesso!" && allow_guests == 0) || text == "Lista salva com sucesso!" ) {
            redirectWhatsapp();
        }
    }

    @if (session('success'))
    warning("Sucesso", "{{ session('success') }}", "sucess");
    @endif

    @if (session('error'))
    warning("Falha", "{{ session('error') }}", "error");
    @endif

    const guests = [
        @foreach ($guests as $key => $guest)
        {
            id: {{$key+1}},
            guestID: {{$guest->id}},
            name: "{{$guest->guest}}"
        },
        @endforeach
        @if (count($guests) < 1 && ($event->type === '1' || $event->capacity > $attendanceCount))
        {
            id: 1,
            name: ""
        }
        @endif
    ];

    let increment = {{count($guests) >= 1? count($guests) : 1}};

    const guestsEl = document.querySelector('.guests .list');
    const includeField = document.querySelector('.guest-include input');

    function saveGuest() {
            let value = includeField.value.trim();
            if(value.length !== 0){
                
                const url = `{{ route('add.guest.event', ['eventID' => $event->id, 'customerID' => $user->id ?? 0]) }}`;
        
                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        name: includeField.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    increment++
                    guests.push({ id: increment, name: includeField.value, guestID: data.guestID });
                    const guestEl = document.createElement('div');
                    guestEl.innerHTML = `<p>${includeField.value}</p>
                                            <div class="actions">
                                                <div class="action" id="delete" onclick="deleteGuest(${increment})">
                                                    <iconify-icon icon="ic:round-delete-sweep"></iconify-icon>
                                                    <span>excluir</span>
                                                </div>
                                            </div>`;
                    guestEl.classList.add('guest');
                    guestEl.id = `i${increment}`;
                    guestsEl.appendChild(guestEl);
                    includeField.value = "";
                })
                .catch((error) => {
                    console.error('There was a problem with the fetch operation:', error);
                });

                
            } else {
                alert("Preencha o nome do(a) convidado(a)!")
            }
    }

    function deleteGuest(id) {
        let result = confirm("Remover convidado(a)?");

        if(result){
            const index = guests.findIndex(g => g.id == id);
            if (index !== -1) {
                
            const url = `{{ route('delete.guest.event', ['guestID' => ':guestID']) }}`
            .replace(':guestID', guests[index].guestID);
        
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                }
            })
            .then(response => response.json())
            .then(data => {
                guests.splice(index, 1)
                const guestEl = document.querySelector(`.guest#i${id}`);
                if(guestEl) guestEl.remove();
            })
            .catch((error) => {
                console.error('There was a problem with the fetch operation:', error);
            });
            }
        }
    }

    async function redirectWhatsapp() {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('redirect.whatsapp') }}";
        let csrfTokenField = document.createElement('input');
        csrfTokenField.type = 'hidden';
        csrfTokenField.name = '_token';
        csrfTokenField.value = '{{ csrf_token() }}';
        form.appendChild(csrfTokenField)

        let whatsapp = document.createElement('input');
        whatsapp.type = 'hidden';
        whatsapp.name = 'whatsapp';
        whatsapp.value = '{{$event->whatsapp}}';
        form.appendChild(whatsapp);

        let message = document.createElement('input');
        message.type = 'hidden';
        message.name = 'message';
        message.value = '{{$event->whatsappmessage}}';
        form.appendChild(message);
        
        document.body.appendChild(form);
        form.submit();
    }

    async function saveGuests() {
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = "{{ route('save.guests.event', $event->id) }}";

        let csrfTokenField = document.createElement('input');
        csrfTokenField.type = 'hidden';
        csrfTokenField.name = '_token';
        csrfTokenField.value = '{{ csrf_token() }}';
        form.appendChild(csrfTokenField)

            // let guestsField = document.createElement('input');
            // guestsField.type = 'hidden';
            // guestsField.name = 'guests';
            // guestsField.value = JSON.stringify(guests);
            // form.appendChild(guestsField);

        document.body.appendChild(form);
        form.submit();
    }

    function copyText() {
            const text = '{{$event->street}}, {{$event->number}}, {{$event->neighborhood}}, {{$event->city}} - {{$event->state}} {{$event->country}}';

            const textarea = document.createElement('textarea');
            textarea.value = text;
            document.body.appendChild(textarea);
            textarea.select();
            try {
                const sucess = document.execCommand('copy');
                if (sucess) {
                    warning("Sucesso", "Texto copiado!", "sucess");
                } else {
                    warning("Falha", "Texto não copiado", "error");
                }
            } catch (err) {
                console.error('Erro ao tentar copiar o texto: ', err);
                warning("Falha", "Texto não copiado", "error");
            }
            document.body.removeChild(textarea);
        }
    
</script>

@if (count($event->photo) > 1) 
<script>
    const leftControl = document.querySelector("iconify-icon#left");
    const rightControl = document.querySelector("iconify-icon#right");
    const featured = document.querySelector(".featured img");
    imagesTotal = {{count($event->photo)}};
    currentImage = 1;

    function setFeatured(el) {
        featured.src = el.src;
    }

    leftControl.addEventListener("click", () => { 
        let image;

        if(currentImage === 1) currentImage = imagesTotal
        else currentImage--

        image = document.querySelector(`.items img#i${currentImage}`)
        featured.src = image.src;
    });

    rightControl.addEventListener("click", () => { 
        let image;

        if(currentImage === imagesTotal) currentImage = 1
        else currentImage++

        image = document.querySelector(`.items img#i${currentImage}`)
        featured.src = image.src;
    });
</script>
@endif

<script>
    $(document).ready(function () {
 
       $('input#code').on('input', function() {
          $(this).mask('000');
          let code = $(this).val();
          let ddd = $('select#ddd').val();
          let number = $('input#number').val().replace(/[^\d]/g, '');
          $('#phonenumber').val(code+ddd+number);
       });
 
       $('select#ddd').change(function() {
          let code = $('input#code').val().replace(/[^\d]/g, '');
          let ddd = $(this).val();
          let number = $('input#number').val().replace(/[^\d]/g, '');
          $('#phonenumber').val(code+ddd+number);
       });
 
       $('input#number').on('input', function() {
          $(this).mask('0 0000-0000');
          let code = $('input#code').val().replace(/[^\d]/g, '');
          let ddd = $('select#ddd').val();
          let number = $(this).val().replace(/[^\d]/g, '');
          $('#phonenumber').val(code+ddd+number);
       });
 
    $('input#birthdate').on('input', function () {
       $(this).mask('00/00/0000')
    });
 
 });
 </script>