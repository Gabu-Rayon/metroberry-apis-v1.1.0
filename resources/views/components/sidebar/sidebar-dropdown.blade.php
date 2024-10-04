<li>
    <a class="has-arrow material-ripple" href="javascript:void(0);">
        <div>
            {!! $icon !!}
            {{ $title }}
        </div>
    </a>
    <ul class="nav-second-level">
        @foreach ($subitems as $subitem)
        <li>
            <a class="text-capitalize" href="{{ $subitem['route'] }}" target="_self">
                {{ $subitem['label'] }}
            </a>
        </li>
        @endforeach
    </ul>
</li>
