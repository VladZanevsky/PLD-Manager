<div class="form-group">
    @isset($title)
        <label for="{{ $id ?? $name }}">{{ $title }}</label>
    @endisset
    <input type="file" name="{{ $name }}" id="{{ $id ?? $name }}" class="file-pond"
           @isset($multiple) multiple data-allow-reorder="true" @endisset
           @isset($data_files) data-files="{{ json_encode($data_files) }}" @endisset
    >
        @isset($hidden)<input type="hidden" name="{{ $name }}" class="{{ $hidden }}" multiple>@endisset
    @isset($value)
        @foreach($value as $path)
            @php
                $mime_type = \Illuminate\Support\Facades\Storage::mimeType(str_replace("public/", "", $path));
                dump($mime_type);
                dump($path);
            @endphp
            <div>
                @if($mime_type == 'video/mp4' || $mime_type == 'video/x-msvideo')
                    <video class="img-thumbnail mt-2" src="{{ $path }}" controls autoplay style="width: 100%;"></video>
                @else
                    <img src="{{ $path }}" alt="{{ $name }}" class="img-thumbnail mt-2" width="500">
                @endif
            </div>
        @endforeach
    @endisset
</div>


{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        // Get a reference to the file input element--}}
{{--        const inputElement = document.querySelector('input#{{ $id ?? $name }}');--}}
{{--        const key = inputElement.getAttribute('multiple');--}}

{{--        FilePond.registerPlugin(--}}
{{--            FilePondPluginImagePreview,--}}
{{--            // FilePondPluginImageExifOrientation,--}}
{{--            // FilePondPluginFileValidateSize,--}}
{{--            FilePondPluginImageEdit,--}}
{{--        );--}}

{{--        // Create a FilePond instance--}}
{{--        const pond = FilePond.create(inputElement, {--}}
{{--            labelIdle: 'Перетащите сюда или выберите файл',--}}
{{--            // acceptedFileTypes: ['image/*'],--}}
{{--            allowMultiple: key !== null,--}}
{{--            server: {--}}
{{--                headers: {--}}
{{--                    'X-CSRF-Token': '{{ csrf_token() }}',--}}
{{--                },--}}
{{--                process: '{{ route('ajax.filepond.upload', ['key' => $id ?? $name]) }}',--}}
{{--                revert: '{{ route('ajax.filepond.revert') }}',--}}
{{--            },--}}
{{--            --}}{{--files: [--}}
{{--            --}}{{--    {--}}
{{--            --}}{{--        source: '{{ $value ?? null }}',--}}
{{--            --}}{{--        options: {--}}
{{--            --}}{{--            type: 'local',--}}
{{--            --}}{{--        },--}}
{{--            --}}{{--    }--}}
{{--            --}}{{--],--}}
{{--        });--}}
{{--    });--}}

{{--</script>--}}
