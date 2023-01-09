<ul>
    @foreach($appraisalQstChd as $value)
    <li><span>{{ $value->label }}</span> | <span>{{ $value->value }}</span></li>
    @endforeach
</ul>
