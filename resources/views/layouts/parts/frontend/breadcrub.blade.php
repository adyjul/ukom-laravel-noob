<div class="navigasi">
    <ul>
        @foreach ($datas as $name => $link)
            <li style="margin-right: 3px">
                @if ($link != '')
                    <a href="{{ $link }}">{{ $name }}</a>
                @else
                    {{ $name }}
                @endif
            </li>
        @endforeach
    </ul>
</div>
