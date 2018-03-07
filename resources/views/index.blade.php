@extends('layout')

@section('content')
    <h3>Prototype model of PGP public key using Blockchain</h3>

    <form method="post" action="{{ route('provisional.auth') }}">
        {{ csrf_field() }}

        <fieldset>

            <label for="ascii-armored">Submit a key</label>
            <textarea placeholder="Enter ASCII-armored PGP key here:" rows="100" name="ascii-armored"></textarea>

            @if ($errors->has('ascii-armored'))
                <span class="ascii-armored">
                    <strong style="color: darkred">{{ $errors->first('ascii-armored') }}</strong>
                </span>
            @endif

        </fieldset>

        <button class="button button-outline float-right" type="submit">Submit Button</button>
    </form>

    <br/>
    <hr/>

    <form method="get" action="{{ route('search') }}">
        <label for="search">Search for UserID</label>
        <input type="text" placeholder="Search for UserID" id="search" name="search">
        <button class="button button-outline float-right" type="submit">Search</button>
    </form>
@endsection
