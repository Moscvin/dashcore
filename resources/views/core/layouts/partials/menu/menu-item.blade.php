@if ($item->show)
    @if (is_string($item))
        <li class="header">{{ $item }}</li>
    @else
        @if ($item->menu_active)
            <li class="treeview">
                <a href="{{ $item->href }}"
                class="{{ !isset($item->children) ? "drop_item" : "" }}"
                >
                    <i class="sidebar-menu-icon fas fa-fw fa-{{ $item->icon ?? 'circle-o' }}"></i>
                    <span class="sidebar-menu-text">{{ $item->text }}</span>
                    @if ($item->children)
                        <span class="pull-right-container">
                        <i class="fas fa-angle-left pull-right"></i>
                        </span>
                    @endif
                </a>
                @if (isset($item->children))
                    <ul class="treeview-menu">
                        @each('core.layouts.partials.menu.menu-item', $item->children, 'item')
                    </ul>
                @endif
            </li>
        @endif
    @endif
@endif
