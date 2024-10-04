@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.event.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.events.update", [$event->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="photo">{{ trans('cruds.event.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cover">{{ trans('cruds.event.fields.cover') }}</label>
                <div class="needsclick dropzone {{ $errors->has('cover') ? 'is-invalid' : '' }}" id="cover-dropzone">
                </div>
                @if($errors->has('cover'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cover') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.cover_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.event.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $event->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.name_helper') }}</span>
            </div>
            <div class="form-collection">
                <div class="form-group full">
                    <label for="start">{{ trans('cruds.event.fields.start') }}</label>
                    <input class="form-control date {{ $errors->has('start') ? 'is-invalid' : '' }}" type="text" name="start" id="start" value="{{ old('start', $event->start) }}">
                    @if($errors->has('start'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.start_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="start_time">{{ trans('cruds.event.fields.start_time') }}</label>
                    <input class="form-control timepicker {{ $errors->has('start_time') ? 'is-invalid' : '' }}" type="text" name="start_time" id="start_time" value="{{ old('start_time', $event->start_time) }}">
                    @if($errors->has('start_time'))
                        <div class="invalid-feedback">
                            {{ $errors->first('start_time') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.start_time_helper') }}</span>
                </div>
            </div>
            <div class="form-collection">  
                <div class="form-group full">
                    <label for="end">{{ trans('cruds.event.fields.end') }}</label>
                    <input class="form-control date {{ $errors->has('end') ? 'is-invalid' : '' }}" type="text" name="end" id="end" value="{{ old('end', $event->end) }}">
                    @if($errors->has('end'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.end_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="end_time">{{ trans('cruds.event.fields.end_time') }}</label>
                    <input class="form-control timepicker {{ $errors->has('end_time') ? 'is-invalid' : '' }}" type="text" name="end_time" id="end_time" value="{{ old('end_time', $event->end_time) }}">
                    @if($errors->has('end_time'))
                        <div class="invalid-feedback">
                            {{ $errors->first('end_time') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.end_time_helper') }}</span>
                </div>
            </div>
            <div class="form-collection">   
                <div class="form-group">
                    <label for="country">{{ trans('cruds.event.fields.country') }}</label>
                    <input class="form-control {{ $errors->has('country') ? 'is-invalid' : '' }}" type="text" name="country" id="country" value="{{ old('country', $event->country) }}">
                    @if($errors->has('country'))
                        <div class="invalid-feedback">
                            {{ $errors->first('country') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.country_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="state">{{ trans('cruds.event.fields.state') }}</label>
                    <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', $event->state) }}">
                    @if($errors->has('state'))
                        <div class="invalid-feedback">
                            {{ $errors->first('state') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.state_helper') }}</span>
                </div>
            </div>
            <div class="form-collection">  
                <div class="form-group">
                    <label for="city">{{ trans('cruds.event.fields.city') }}</label>
                    <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $event->city) }}">
                    @if($errors->has('city'))
                        <div class="invalid-feedback">
                            {{ $errors->first('city') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.city_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="neighborhood">{{ trans('cruds.event.fields.neighborhood') }}</label>
                    <input class="form-control {{ $errors->has('neighborhood') ? 'is-invalid' : '' }}" type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood', $event->neighborhood) }}">
                    @if($errors->has('neighborhood'))
                        <div class="invalid-feedback">
                            {{ $errors->first('neighborhood') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.neighborhood_helper') }}</span>
                </div>
            </div>
            <div class="form-collection">
                <div class="form-group">
                    <label for="street">{{ trans('cruds.event.fields.street') }}</label>
                    <input class="form-control {{ $errors->has('street') ? 'is-invalid' : '' }}" type="text" name="street" id="street" value="{{ old('street', $event->street) }}">
                    @if($errors->has('street'))
                        <div class="invalid-feedback">
                            {{ $errors->first('street') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.street_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="number">{{ trans('cruds.event.fields.number') }}</label>
                    <input class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" type="text" name="number" id="number" value="{{ old('number', $event->number) }}">
                    @if($errors->has('number'))
                        <div class="invalid-feedback">
                            {{ $errors->first('number') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.event.fields.number_helper') }}</span>
                </div>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.event.fields.description') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{!! old('description', $event->description) !!}</textarea>
                @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="rules">{{ trans('cruds.event.fields.rules') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('rules') ? 'is-invalid' : '' }}" name="rules" id="rules">{!! old('rules', $event->rules) !!}</textarea>
                @if($errors->has('rules'))
                    <div class="invalid-feedback">
                        {{ $errors->first('rules') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.rules_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link">{{ trans('cruds.event.fields.link') }}</label>
                <input class="form-control {{ $errors->has('link') ? 'is-invalid' : '' }}" type="text" name="link" id="link" value="{{ old('link', $event->link) }}">
                @if($errors->has('link'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.link_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="link_instruction">{{ trans('cruds.event.fields.link_instruction') }}</label>
                <input class="form-control {{ $errors->has('link_instruction') ? 'is-invalid' : '' }}" type="text" name="link_instruction" id="link_instruction" value="{{ old('link_instruction', $event->link_instruction) }}">
                @if($errors->has('link_instruction'))
                    <div class="invalid-feedback">
                        {{ $errors->first('link_instruction') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.link_instruction_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pixel">{{ trans('cruds.event.fields.pixel') }}</label>
                <input class="form-control {{ $errors->has('pixel') ? 'is-invalid' : '' }}" type="text" name="pixel" id="pixel" value="{{ old('pixel', $event->pixel) }}">
                @if($errors->has('pixel'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pixel') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.pixel_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsapp">{{ trans('cruds.event.fields.whatsapp') }}</label>
                <input class="form-control {{ $errors->has('whatsapp') ? 'is-invalid' : '' }}" type="text" name="whatsapp" id="whatsapp" value="{{ old('whatsapp', $event->whatsapp) }}">
                @if($errors->has('whatsapp'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.whatsapp_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsappmessage">{{ trans('cruds.event.fields.whatsappmessage') }}</label>
                <textarea class="form-control {{ $errors->has('whatsappmessage') ? 'is-invalid' : '' }}" name="whatsappmessage" id="whatsappmessage">{{ old('whatsappmessage', $event->whatsappmessage) }}</textarea>
                @if($errors->has('whatsappmessage'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsappmessage') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.whatsappmessage_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="whatsapp_help">{{ trans('cruds.event.fields.whatsapp_help') }}</label>
                <input class="form-control {{ $errors->has('whatsapp_help') ? 'is-invalid' : '' }}" type="text" name="whatsapp_help" id="whatsapp_help" value="{{ old('whatsapp_help', $event->whatsapp_help) }}">
                @if($errors->has('whatsapp_help'))
                    <div class="invalid-feedback">
                        {{ $errors->first('whatsapp_help') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.whatsapp_help_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.event.fields.visualization') }}</label>
                @foreach(App\Models\Event::VISUALIZATION_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('visualization') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="visualization_{{ $key }}" name="visualization" value="{{ $key }}" {{ old('visualization', $event->visualization) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="visualization_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('visualization'))
                    <div class="invalid-feedback">
                        {{ $errors->first('visualization') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.visualization_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.event.fields.type') }}</label>
                @foreach(App\Models\Event::TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="type_{{ $key }}" name="type" value="{{ $key }}" {{ old('type', $event->type) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.type_helper') }}</span>
            </div>
            <div class="form-group" style="display: {{ $event->type === '0'? 'block' : 'none' }}">
                <label for="capacity">{{ trans('cruds.event.fields.capacity') }}</label>
                <input class="form-control {{ $errors->has('capacity') ? 'is-invalid' : '' }}" type="number" name="capacity" id="capacity" value="{{ old('capacity', $event->capacity) }}" step="1" {{ $event->type === '0'? 'required' : '' }}>
                @if($errors->has('capacity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('capacity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.capacity_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.event.fields.allow_guests') }}</label>
                @foreach(App\Models\Event::ALLOW_GUESTS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('allow_guests') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="allow_guests_{{ $key }}" name="allow_guests" value="{{ $key }}" {{ old('allow_guests', $event->allow_guests) === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_guests_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('allow_guests'))
                    <div class="invalid-feedback">
                        {{ $errors->first('allow_guests') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.event.fields.allow_guests_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>

    let typeRadios = document.querySelectorAll("[name=type]");

    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            const capacity = document.querySelector('input#capacity'); 
            const formGroup = capacity.closest('.form-group');
            if(this.value == 1){
                capacity.value = '';
                capacity.removeAttribute("required");
                formGroup.style.display = 'none';
            } else {
                formGroup.style.display = 'block';
                capacity.setAttribute("required", "");
            }
        });
    });

</script>
<script>
    var uploadedPhotoMap = {}
Dropzone.options.photoDropzone = {
    url: '{{ route('admin.events.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
      uploadedPhotoMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotoMap[file.name]
      }
      $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($event) && $event->photo)
      var files = {!! json_encode($event->photo) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photo[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
<script>
    Dropzone.options.coverDropzone = {
    url: '{{ route('admin.events.storeMedia') }}',
    maxFilesize: 5, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 5,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="cover"]').remove()
      $('form').append('<input type="hidden" name="cover" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="cover"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($event) && $event->cover)
      var file = {!! json_encode($event->cover) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="cover" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.events.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $event->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection