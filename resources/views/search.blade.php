@extends('layout')


@section('css')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
@endsection


@section('content')
    <div>Search UserID: "{{ $search_userid or '' }}"</div>

    <table class="table" id="search-table">
        <thead>
        <tr>
            <th>BlockChain ID</th>
            <th>UserID</th>
            <th>AsciiArmored</th>
        </tr>
        </thead>
        <tbody>
        @foreach($search_result as $value)
            <tr>
                <td>{{ $value->id or '' }}</td>
                <td>{{ $value->data->pgp_public_key->UserID or '' }}</td>
                <td>{{ $value->data->pgp_public_key->Ascii_Armored  or '' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

@endsection


@section('js')
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script>
        $(function () {
            $("#search-table").DataTable(
                {
                    lengthChange: false,
                    searching: false,
                    ordering: false,
                    info: false,
                    paging: false,
                    scrollX: true
                }
            );
        });
    </script>
@endsection