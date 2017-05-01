<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin panel</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
    <style>
        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        li {
            float: left;
        }

        li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        li a:hover:not(.active) {
            background-color: #111;
        }

        .active {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>

<ul>
    <li><a class="active" href="logout">Logout</a></li>
</ul>

<div class="container">
    <h2>Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</h2>
    <h2>{{$title}}</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>PharmacyName</th>
        </tr>
        </thead>

@foreach($data as $value)

        <tbody>
        <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->name_en}}</td>
            <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$value->id}}">Open</button></td>
        </tr>
        </tbody>

            <div class="modal fade" id={{$value->id}} role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">



                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Pharmacy Info</h4>
                        </div>
                        <div class="modal-body">
                            <p>ID: {{$value->id}} </p>
                            <p>Name: {{$value->name_en}}</p>
                            <p>Address: {{$value->address_en}}</p>
                            <p>Landline: {{$value->landline}}</p>
                            <p>Mobile: {{$value->mobile}}</p>
                            <p>E-mail: {{$value->email}}</p>
                            <p>Owner: {{$value->owner_name}}</p>
                            <p>Open: {{$value->open}}</p>
                            <p>close: {{$value->close}}</p>
                        </div>

@if($title=='Pharmacies')

                            <div class="modal-footer">
                                <a href='/admin/pharmacy/delete/{{$value->id}}' type="button" class="btn btn-default" >Delete</a>
                                <button href='#' type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>

@endif
                        @if($title=='Pharmacy Forms')
                        <div class="modal-footer">
                            <a href='/admin/pharmacyform/accept/{{$value->id}}' type="button" class="btn btn-default" >Accept</a>
                            <a href='/admin/pharmacyform/refuse/{{$value->id}}' type="button" class="btn btn-default">Refuse</a>
                            <button href='#' type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


@endforeach
    </table>
</div>




</body>
</html>