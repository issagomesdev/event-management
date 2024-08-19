<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700|Raleway:300,600" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <link rel="stylesheet" href="/css/customer-form.css">
    <title>{{ trans('panel.site_title') }}</title>
</head>
<body>
   <div class="container">
      @if($register)
         <section id="formHolder">
            <div class="row">
               <div class="col-sm-6 brand">
                  {{-- <a href="#" class="logo">Eventos<span>.</span></a> --}}
                  <div class="logo">
                     <img src="{{ asset('images/logo.png') }}" alt="Listinha VIP">
                  </div>
                  <div class="heading">
                     <h2>Bem-vindo </h2>
                     <p>Realize seu cadastro para visualizar o evento</p>
                  </div>
               </div>
               <div class="col-sm-6 form">
                  <div class="login form-peice">
                     <form class="login-form" method="POST" action="{{ route("customers.store") }}" enctype="multipart/form-data">
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
                        {{-- <div class="form-group">
                           <label for="email">E-mail</label>
                           <input type="email" name="email" id="email" value="{{ old('email') }}" required>
                           @if($errors->has('email'))
                              <div class="invalid-feedback" style="color: #ff0000">
                                    {{ $errors->first('email') }}
                              </div>
                           @endif
                        </div> --}}
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
                        <div class="form-group">
                           <label for="birthdate">Data de nascimento</label>
                           <div class="associate">
                              <input style="padding: 10px;" name="birthdate" id="birthdate" value="{{ old('birthdate') ?? $birthdate ?? ''}}" required placeholder="dd/mm/aaaa">
                           </div>
                           @if($errors->has('birthdate'))
                              <div class="invalid-feedback" style="color: #ff0000">
                                    {{ $errors->first('birthdate') }}
                              </div>
                           @endif
                        </div>
                        @if ($eventID)
                        <input type="hidden" name="eventID" id="eventID" value="{{ $eventID }}">
                        @endif
                        <input type="hidden" name="phonenumber" id="phonenumber" value="{{ old('phonenumber') ?? $phonenumber ?? '' }}">
                        <div class="CTA" style="display: flex;">
                           <input type="submit" value="Cadastrar">
                           <a href="https://wa.me/5585991634968?text=Ol%C3%A1.%20Estou%20com%20d%C3%BAvidas%20no%20site%20listinha%20vip%20">Precisa de ajuda?</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      @else 
         <section id="formHolder">
            <div class="row">
               @if (session('error'))
                  <div class="alert alert-danger">
                     {{ session('error') }}
                  </div>
               @endif
               <div class="col-sm-6 brand">
                  <div class="logo">
                     <img src="{{ asset('images/logo.png') }}" alt="Listinha VIP">
                  </div>
                  <div class="heading">
                     <h2>Bem-vindo</h2>
                     <p>Faça o login para visualizar o evento</p>
                  </div>
               </div>
               <div class="col-sm-6 form">
                  <div class="login form-peice">
                     <div class="instructions">
                        <h4>Cadastre-se para acessar nossas listas</h4>
                        <h4>É rápido e 100% seguro!</h4>
                     </div>
                     <form class="login-form" method="POST" action="{{ route("customers.verifyCustomer") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                           <label for="phonenumber">Numero do whatsApp</label>
                           <div class="associate">
                              <span>+</span>
                              <input name="code" id="code" value="{{ old('code', '55') }}" required>
                              <select name="ddd" id="ddd">
                                 <option value="68" {{ old('ddd', '85') == '68' ? 'selected' : '' }}>68</option>
                                 <option value="96" {{ old('ddd', '85') == '96' ? 'selected' : '' }}>96</option>
                                 <option value="92" {{ old('ddd', '85') == '92' ? 'selected' : '' }}>92</option>
                                 <option value="97" {{ old('ddd', '85') == '97' ? 'selected' : '' }}>97</option>
                                 <option value="91" {{ old('ddd', '85') == '91' ? 'selected' : '' }}>91</option>
                                 <option value="93" {{ old('ddd', '85') == '93' ? 'selected' : '' }}>93</option>
                                 <option value="94" {{ old('ddd', '85') == '94' ? 'selected' : '' }}>94</option>
                                 <option value="69" {{ old('ddd', '85') == '69' ? 'selected' : '' }}>69</option>
                                 <option value="95" {{ old('ddd', '85') == '95' ? 'selected' : '' }}>95</option>
                                 <option value="63" {{ old('ddd', '85') == '63' ? 'selected' : '' }}>63</option>
                                 <option value="82" {{ old('ddd', '85') == '82' ? 'selected' : '' }}>82</option>
                                 <option value="71" {{ old('ddd', '85') == '71' ? 'selected' : '' }}>71</option>
                                 <option value="73" {{ old('ddd', '85') == '73' ? 'selected' : '' }}>73</option>
                                 <option value="74" {{ old('ddd', '85') == '74' ? 'selected' : '' }}>74</option>
                                 <option value="75" {{ old('ddd', '85') == '75' ? 'selected' : '' }}>75</option>
                                 <option value="77" {{ old('ddd', '85') == '77' ? 'selected' : '' }}>77</option>
                                 <option value="85" {{ old('ddd', '85') == '85' ? 'selected' : '' }}>85</option>
                                 <option value="88" {{ old('ddd', '85') == '88' ? 'selected' : '' }}>88</option>
                                 <option value="98" {{ old('ddd', '85') == '98' ? 'selected' : '' }}>98</option>
                                 <option value="99" {{ old('ddd', '85') == '99' ? 'selected' : '' }}>99</option>
                                 <option value="83" {{ old('ddd', '85') == '83' ? 'selected' : '' }}>83</option>
                                 <option value="81" {{ old('ddd', '85') == '81' ? 'selected' : '' }}>81</option>
                                 <option value="87" {{ old('ddd', '85') == '87' ? 'selected' : '' }}>87</option>
                                 <option value="86" {{ old('ddd', '85') == '86' ? 'selected' : '' }}>86</option>
                                 <option value="89" {{ old('ddd', '85') == '89' ? 'selected' : '' }}>89</option>
                                 <option value="84" {{ old('ddd', '85') == '84' ? 'selected' : '' }}>84</option>
                                 <option value="79" {{ old('ddd', '85') == '79' ? 'selected' : '' }}>79</option>
                                 <option value="61" {{ old('ddd', '85') == '61' ? 'selected' : '' }}>61</option>
                                 <option value="62" {{ old('ddd', '85') == '62' ? 'selected' : '' }}>62</option>
                                 <option value="64" {{ old('ddd', '85') == '64' ? 'selected' : '' }}>64</option>
                                 <option value="65" {{ old('ddd', '85') == '65' ? 'selected' : '' }}>65</option>
                                 <option value="66" {{ old('ddd', '85') == '66' ? 'selected' : '' }}>66</option>
                                 <option value="67" {{ old('ddd', '85') == '67' ? 'selected' : '' }}>67</option>
                                 <option value="27" {{ old('ddd', '85') == '27' ? 'selected' : '' }}>27</option>
                                 <option value="28" {{ old('ddd', '85') == '28' ? 'selected' : '' }}>28</option>
                                 <option value="31" {{ old('ddd', '85') == '31' ? 'selected' : '' }}>31</option>
                                 <option value="32" {{ old('ddd', '85') == '32' ? 'selected' : '' }}>32</option>
                                 <option value="33" {{ old('ddd', '85') == '33' ? 'selected' : '' }}>33</option>
                                 <option value="34" {{ old('ddd', '85') == '34' ? 'selected' : '' }}>34</option>
                                 <option value="35" {{ old('ddd', '85') == '35' ? 'selected' : '' }}>35</option>
                                 <option value="37" {{ old('ddd', '85') == '37' ? 'selected' : '' }}>37</option>
                                 <option value="38" {{ old('ddd', '85') == '38' ? 'selected' : '' }}>38</option>
                                 <option value="21" {{ old('ddd', '85') == '21' ? 'selected' : '' }}>21</option>
                                 <option value="22" {{ old('ddd', '85') == '22' ? 'selected' : '' }}>22</option>
                                 <option value="24" {{ old('ddd', '85') == '24' ? 'selected' : '' }}>24</option>
                                 <option value="11" {{ old('ddd', '85') == '11' ? 'selected' : '' }}>11</option>
                                 <option value="12" {{ old('ddd', '85') == '12' ? 'selected' : '' }}>12</option>
                                 <option value="13" {{ old('ddd', '85') == '13' ? 'selected' : '' }}>13</option>
                                 <option value="14" {{ old('ddd', '85') == '14' ? 'selected' : '' }}>14</option>
                                 <option value="15" {{ old('ddd', '85') == '15' ? 'selected' : '' }}>15</option>
                                 <option value="16" {{ old('ddd', '85') == '16' ? 'selected' : '' }}>16</option>
                                 <option value="17" {{ old('ddd', '85') == '17' ? 'selected' : '' }}>17</option>
                                 <option value="18" {{ old('ddd', '85') == '18' ? 'selected' : '' }}>18</option>
                                 <option value="19" {{ old('ddd', '85') == '19' ? 'selected' : '' }}>19</option>
                                 <option value="41" {{ old('ddd', '85') == '41' ? 'selected' : '' }}>41</option>
                                 <option value="42" {{ old('ddd', '85') == '42' ? 'selected' : '' }}>42</option>
                                 <option value="43" {{ old('ddd', '85') == '43' ? 'selected' : '' }}>43</option>
                                 <option value="44" {{ old('ddd', '85') == '44' ? 'selected' : '' }}>44</option>
                                 <option value="45" {{ old('ddd', '85') == '45' ? 'selected' : '' }}>45</option>
                                 <option value="46" {{ old('ddd', '85') == '46' ? 'selected' : '' }}>46</option>
                                 <option value="51" {{ old('ddd', '85') == '51' ? 'selected' : '' }}>51</option>
                                 <option value="53" {{ old('ddd', '85') == '53' ? 'selected' : '' }}>53</option>
                                 <option value="54" {{ old('ddd', '85') == '54' ? 'selected' : '' }}>54</option>
                                 <option value="55" {{ old('ddd', '85') == '55' ? 'selected' : '' }}>55</option>
                                 <option value="47" {{ old('ddd', '85') == '47' ? 'selected' : '' }}>47</option>
                                 <option value="48" {{ old('ddd', '85') == '48' ? 'selected' : '' }}>48</option>
                                 <option value="49" {{ old('ddd', '85') == '49' ? 'selected' : '' }}>49</option>
                              </select>
                               <input style="padding: 10px;" name="number" id="number" value="{{ old('number') }}" required placeholder="9 9999-9999">
                           </div>
                        </div>
                        {{-- <div class="form-group">
                           <label for="birthdate">Data de nascimento</label>
                           <div class="associate">
                              <input style="padding: 10px;" name="birthdate" id="birthdate" value="{{ old('birthdate') }}" required placeholder="dd/mm/aaaa">
                           </div>
                              @if($errors->has('birthdate'))
                                 <div class="invalid-feedback" style="color: #ff0000">
                                       {{ $errors->first('birthdate') }}
                                 </div>
                              @endif
                        </div> --}}
                        @if ($eventID)
                        <input type="hidden" name="eventID" id="eventID" value="{{ $eventID }}">
                        @endif
                        <input type="hidden" name="phonenumber" id="phonenumber" value="{{ old('phonenumber') }}">
                        <div class="CTA" style="display: flex;">
                           <input type="submit" value="Entrar">
                           <a href="https://wa.me/5585991634968?text=Ol%C3%A1.%20Estou%20com%20d%C3%BAvidas%20no%20site%20listinha%20vip%20">Precisa de ajuda?</a>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </section>
      @endif
   </div>
</body>
</html>

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