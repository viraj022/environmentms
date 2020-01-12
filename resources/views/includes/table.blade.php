
<thead>
    <tr>
        <td></td>
        @foreach ($tableParam as $para)
        <td>{{$para}}</td>
        @endforeach
    </tr>
</thead>
<tbody>
    @foreach ($tableRows as $trk => $tr)
    <tr>
        <td>{{$tr['attr_name']}}</td>
        @foreach ($tableParam as $para)
        <td>
            @if(isset($tableRows[$trk][$para]))
            {{$tableRows[$trk][$para]}}</td>
        @else
        <span class="badge bg-danger">N/A</span>
        @endif
        @endforeach
    </tr>
    @endforeach
</tbody>
