<div class="form-group">
    @isset($title)
        <label for="{{ $id ?? $name }}">{{ $title }}</label>
    @endisset
    <div class="input-group">
        <div class="custom-file">
            <input type="file" class="custom-file-input @error($name) is-invalid @enderror"
               id="{{ $id ?? $name }}" name="{{ $name }}" @isset($multiple) multiple @endisset
                   @if(isset($disabled) && $disabled) disabled @endif
            >
            <label class="custom-file-label" for="{{ $id ?? $name }}">{{ $pre_text }}</label>
        </div>
    </div>
    @isset($value)
        @isset($is_file)
            @if($value)
                <div>
                    <a href="{{ $value }}" target="_blank">Документ</a>
                </div>
            @endif
        @else
            <div>
                <img src="{{ $value }}" alt="{{ $name }}" class="img-thumbnail mt-2" width="500" @isset($dark_image) style="background: #303030;" @endisset>
            </div>
        @endisset
    @endisset
</div>
