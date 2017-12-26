@extends('layouts.master')

@section('title', 'Facets and full text example')

@section('facets')
    @include('objects.filter')
@endsection


@section('PageContent')
    <div class="table-responsive" id="records">
        @include('objects.records')
    </div>
@endsection