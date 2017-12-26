<style>
    ul.nav-pills > li {
        display: inline-block;
        margin-bottom: 20px;
    }
</style>
<ul class="nav nav-pills flex-column form-control">
    @foreach($facets['aggregations'] as $key => $aggregation)
        @if($key == "functionalName")
            <li class="custom-control custom-checkbox">
                <ul class="flex-column">
                    <b class="flex-column">
                        Functional names
                    </b>
                    @if(isset($aggregation['value']['buckets']))
                        @foreach($aggregation['value']['buckets'] as $bucket)
                            <li class="custom-control custom-checkbox">
                                <label>
                                    <input @if(isset($filter['functionalName']) && in_array($bucket['key'], $filter['functionalName']))checked="checked"
                                           @endif name="functionalName" type="checkbox" value="{{$bucket['key']}}"
                                           onclick="Filter.sendData()">
                                    {{$bucket['key']}} - ({{$bucket['doc_count']}})
                                </label>
                            </li>
                        @endforeach
                    @else
                        @foreach($aggregation['buckets'] as $bucket)
                            <li class="custom-control custom-checkbox">
                                <label>
                                    <input @if(isset($filter['functionalName']) && in_array($bucket['key'], $filter['functionalName']))checked="checked"
                                           @endif name="functionalName" type="checkbox" value="{{$bucket['key']}}"
                                           onclick="Filter.sendData()">
                                    {{$bucket['key']}} - ({{$bucket['doc_count']}})
                                </label>
                            </li>
                        @endforeach
                    @endif
                </ul>
        @else
            @if(isset($aggregation['value']['buckets']))
                @if($aggregation['value']['buckets'])
                    <li class="custom-control custom-checkbox">
                        <ul class="flex-column ">
                            <b class="flex-column">
                                Attribute{{$key}} 1
                            </b>
                            @foreach($aggregation['value']['buckets'] as $value)
                                <li class="custom-control">
                                    <label>
                                        <input @if(isset($filter['attribute']) && in_array($value['key'], $filter['attribute']))
                                               checked="checked"
                                               @endif id="attributes" data-attr-id="{{$key}}"
                                               name="attributes[{{$key}}]"
                                               type="checkbox" value="{{$value['key']}}"
                                               onclick="Filter.sendData()">
                                        {{$value['key']}} - ({{$value['doc_count']}})
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @else
                @if($aggregation['buckets'])
                    <li class="custom-control custom-checkbox">
                        <ul class="flex-column">
                            <b class="flex-column">
                                Attribute{{$key}} 2
                            </b>
                            @foreach($aggregation['buckets'] as $value)
                                <li class="custom-control">
                                    <label>
                                        <input @if(isset($filter['attribute']) && in_array($value['key'], $filter['attribute']))
                                               checked="checked"
                                               @endif id="attributes" data-attr-id="{{$key}}"
                                               name="attributes[{{$key}}]"
                                               type="checkbox" value="{{$value['key']}}"
                                               onclick="Filter.sendData()">
                                        {{$value['key']}} - ({{$value['doc_count']}})
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @endif
            @endif
        @endif
    @endforeach
</ul>