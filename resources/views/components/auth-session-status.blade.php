@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success m-3']) }}>
        {{ $status }}
    </div>
@endif
