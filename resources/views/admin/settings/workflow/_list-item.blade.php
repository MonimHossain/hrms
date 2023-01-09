<ul>
    @foreach( $tree as $item )
        <li> <a class='selected-item' item-id="{{ $item['id'] }}"> {{ $item['text'] }}</a>

        @if ( isset( $item['nodes'] ) ) {
            @include('admin.settings.workflow._list-item',['tree' => $item['nodes']])
        @endif
        </li>
    @endforeach
</ul>;
