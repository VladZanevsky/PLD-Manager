<div class="form-group">
    @isset($title)
        <label for="{{ $id ?? $name }}">{{ $title }}</label>
    @endisset

    @php
        $old = str_replace('[', '.', $id ?? $name); // Replace [ with .
        $old = str_replace(']', '', $old); // Remove ]
    @endphp

    <input type="color" name="{{ $name }}"
           class="form-control @error($name) is-invalid @enderror"
           @if(isset($readonly) && $readonly) readonly @endif
           id="{{ $id ?? $name }}" @isset($placeholder) placeholder="{{ $placeholder }}" @endisset
           @if(old($old, $value ?? null)) value="{{ old($old, $value ?? null) }}" @endif
    >
</div>
