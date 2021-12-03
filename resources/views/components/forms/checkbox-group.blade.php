@php
    $prefix = config('laka-core.prefix');
@endphp
<div {!! $attributes->class($class) !!}>
@foreach ($items as $key => $item)
    <x-form-checkbox :name="$name"
        :id="$key"
        :label="$item['label']"
        :checked="$item['checked']"
        :value="$key"
        :custom="true"
        groupClass="mr-2"
        :showError="false"></x-form-checkbox>
@endforeach

@include("{$prefix}::components.forms.help-block")

@include("{$prefix}::components.forms.errors")
</div>
