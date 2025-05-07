<div class="form-group">
    @isset($title)
        <label for="{{ $id }}">{{ $title }}</label>
    @endisset
    <select class="duallistbox" multiple="multiple"
        name="{{ $name }}" id="{{ $id }}"
    >
        @foreach($items as $v)
            <option
                value="{{ $v->id }}"

                @isset($values)
                    @if(in_array($v->id, $values)) selected @endif
                @endisset

                @isset($value)
                    @if($value == $v->id)
                        selected
                    @endif
                @else
                    @if(old($name) == $v->id)
                        selected
                    @endif
                @endisset
            >
                {{ $v }}
            </option>
        @endforeach
    </select>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#{{ $id }}').bootstrapDualListbox();
    });
</script>
