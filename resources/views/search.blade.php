<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>


    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">

    <style>

        .navbar {
            margin-bottom: 50px;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #606c76;
        }

        .navbar li {
            float: left;
            margin-bottom: 0;
        }

        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        .navbar li a:hover {
            background-color: #ab5dda;
        }

    </style>

</head>
<body>


<nav class="navbar">
    <ul>
        <li><a class="active" href="{{ route('home') }}">Home</a></li>
    </ul>
</nav>
<div class="container">

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
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
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

</body>
</html>
