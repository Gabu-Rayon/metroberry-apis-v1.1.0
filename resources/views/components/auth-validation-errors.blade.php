@props(['errors'])

@if ($errors->any())
    <div {{ $attributes->merge(['class' => 'alert alert-danger m-3']) }}>
        {{ $errors->all()[0] }}
    </div>
@endif
