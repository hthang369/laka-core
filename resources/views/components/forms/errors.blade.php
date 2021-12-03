@if(isset($errors) && is_object($errors) && $errors->has(rtrim($name, '[]')))
    <div class="{{ $errors->has(rtrim($name, '[]')) ? 'invalid' : '' }}-feedback d-block">
    {!! $errors->first(rtrim($name, '[]')) !!}
    </div>
@endif
