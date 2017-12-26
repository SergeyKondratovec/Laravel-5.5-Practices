<table class="table table-striped">
    <thead>
    <tr>
        <th>#</th>
        <th>Title</th>
        <th>Type</th>
    </tr>
    </thead>
    <tbody>
    @foreach($result['hits']['hits'] as $hit)
        <tr>
            <td>{{$hit['_id']}}</td>
            @if(isset($hit['highlight']['title'][0]))
                <td>{!! $hit['highlight']['title'][0] !!}</td>
            @else
                <td>{{$hit['_source']['title'] }}</td>
            @endif
            <td>{{$hit['_type']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $paging->links('vendor.pagination.bootstrap-4') }}