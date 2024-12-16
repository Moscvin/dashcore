@if (is_array($item))
    <li>
        <a href="{{ $item['url'] }}"
           @if (isset($item['children'])) class="dropdown-toggle" data-toggle="dropdown" @endif
        >
            <i class="fas fa-fw fa-{{ $item['icon'] ?? 'circle-o' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>
            {{ $item['text'] }}
            @if (isset($item['label']))
                <span class="label label-{{ $item['label_color'] ?? 'primary' }}">{{ $item['label'] }}</span>
            @elseif (isset($item['children']))
                <span class="caret"></span>
            @endif
        </a>
        @if (isset($item['children']))
            <ul class="dropdown-menu" role="menu">
                @foreach($item['children'] as $subitem)
                    @if (is_string($subitem))
                        @if($subitem == '-')
                            <li role="separator" class="divider"></li>
                        @else
                            <li class="dropdown-header">{{ $subitem }}</li>
                        @endif
                    @else
                    <li>
                        <a url="{{ $subitem['url'] }}">
                            <i class="fas fa-{{ $subitem['icon'] ?? 'circle-o' }} {{ isset($subitem['icon_color']) ? 'text-' . $subitem['icon_color'] : '' }}"></i>
                            {{ $subitem['text'] }}
                            @if (isset($subitem['label']))
                                <span class="label label-{{ $subitem['label_color'] ?? 'primary' }}">{{ $subitem['label'] }}</span>
                            @endif
                        </a>
                    </li>
                    @endif
                @endforeach
            </ul>
        @endif
    </li>
@endif
