<div class="form-group">
    @isset($title)
        <label for="{{ $name }}">{{ $title }}</label>
    @endisset
    <input type="password" name="{{ $name }}" class="form-control @error($name) is-invalid @enderror"
           id="{{ $name }}" @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
           @if(old($name, $value ?? null)) value="{{ old($name, $value ?? null) }}" @endif
    >
</div>
