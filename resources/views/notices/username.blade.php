@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        Username Rules
                    </div>
                    <div class="card-body">
                        <ol>
                            <li>Only contains <em>alphanumeric</em> characters,
                                <em>underscore</em> and <em>dot</em>.
                            </li>
                            <li>Underscore and dot can't be at the <em>end</em> or
                                <em>start</em> of a username (e.g <code>_username</code> / <code>username_</code> / <code>.username</code> /
                                <code>username.</code>).
                            </li>
                            <li>Underscore and dot can't be <em>next to each other</em> (e.g <code>user_.name</code>).</li>
                            <li>Underscore or dot can't be used multiple times <em>in a row</em> (e.g <code>user__name</code> / <code>user..name</code>).
                            </li>
                            <li>Number of characters must be between 4 to 32.</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
