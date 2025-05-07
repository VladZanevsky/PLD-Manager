<div class="form-group">
    <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="{{ $name }}" name="{{ $name }}"
            @if(!isset($value) && !old($name))
                @checked($default ?? false)
            @endif
            @if(isset($disabled) && $disabled) disabled @endif
            @checked(old($name, $value ?? null))
            @isset($on_change) onchange="this.form.submit()" @endisset >
        @isset($title)
            <label class="custom-control-label" for="{{ $name }}">{{ $title }}</label>
        @endisset
    </div>
</div>
