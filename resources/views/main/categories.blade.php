<li>
    <a href="{{ route('category', $child_node->id) }}">{{ $child_node->name }}</a>

@if(!empty($child_node->children))
    <ul>
        @foreach ($child_node->children as $childNode)
            <li>
                <a href="{{ route('category', $childNode->id) }}">{{ $childNode->name }}</a>
            </li>
        @endforeach
    </ul>
@endif
</li>
