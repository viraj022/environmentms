<style>
    body {
        font-size: 13px;
        font-family: Arial;
    }
    table {
        width: 100%;
        margin-bottom: 15px;
    }
    table, tr, th, td {
        border: 1px solid #000;
        border-collapse: collapse;
    }
</style>
@foreach ($data['rows'] as $row)
    @php
        $colsize = ceil(75 / count($row['columns']));
    @endphp
    <table class="table table-bordered">
        <thead>
            <tr>
                <th colspan="{{1+count($row['columns'])}}">{{$row['title']}}</th>
            </tr>
            <tr>
                <th style="width: 25%;"></th>
                @foreach ($row['columns'] as $column)
                    <th style="width: {{$colsize}}">{{$column}}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($row['attr_rows'] as $attr)
            <tr>
                <td style="width: 25%;">{{$attr['attr_name']}}</td>
                @foreach ($row['columns'] as $colk => $colv)
                    @if (array_key_exists('param_'. $colk, $attr['attr_values']))
                        <td style="width: {{$colsize}}">{{$attr['attr_values']['param_' . $colk]}}</td>
                    @else
                        <td style="width: {{$colsize}}">&nbsp;</td>
                    @endif
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
@endforeach
