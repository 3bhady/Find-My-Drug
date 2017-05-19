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
            color:#ffffff;
        }
        li a:hover {
             color:#ffffff;
        }

        .active {
            background-color: #4CAF50;
        }
    </style>
</head>
<body>

<ul>
    @if($title=="Pharmacies")
    <li><a class="active"href="pharmacy">View Pharmacies</a></li>
    <li><a  href="pharmacyform">View pharmacy forms</a></li>
    @endif
    @if($title=="Pharmacy Forms")
        <li><a href="pharmacy">View Pharmacies</a></li>
        <li><a class="active" href="pharmacyform">View pharmacy forms</a></li>
    @endif
    <li><a href="logout" style="float: right;">Logout</a></li>
</ul>


<div class="container">
    <h2>Welcome {{\Illuminate\Support\Facades\Auth::user()->name}}</h2>
    <h2>{{$title}}</h2>
    @if (\Session::has('submit_error'))

        <h4>You can't edit ,Invalid Input</h4>

    @endif
    @if (\Session::has('submit_success'))

        <h4>Done editing.</h4>

    @endif
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
            <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$value->id}}">Show</button></td>
            <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#{{$value->id}}edit">Edit</button></td>

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
                                <button  type="button" class="btn btn-default" data-toggle="modal" data-target="#DeleteConfirmationModal " data-backdrop="false" >Delete</button>
                                <button href='#' type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>


                            <div class="modal fade" id="DeleteConfirmationModal" role="dialog" >
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you Sure you want to delete pharmacy ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/admin/pharmacy/delete/{{$value->id}}"  class="btn btn-default" >Yes</a>
                                            <button href='#' type="button" class="btn btn-default"  data-toggle="modal" data-target="#DeleteConfirmationModal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

@endif
                        @if($title=='Pharmacy Forms')
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#AcceptConfirmationModal " data-backdrop="false" >Accept</button>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#RefuseConfirmationModal " data-backdrop="false">Refuse</button>
                            <button href='#' type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        </div>

                            <div class="modal fade" id="AcceptConfirmationModal" role="dialog" >
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you Sure you want to Accept pharmacy ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/admin/pharmacyform/accept/{{$value->id}}"  class="btn btn-default" >Yes</a>
                                            <button href='#' type="button" class="btn btn-default"  data-toggle="modal" data-target="#AcceptConfirmationModal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="modal fade" id="RefuseConfirmationModal" role="dialog" >
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Confirmation</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p>Are you Sure you want to refuse pharmacy ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="/admin/pharmacyform/refuse/{{$value->id}}" type="submit" class="btn btn-default" >Yes</a>
                                            <button href='#' type="button" class="btn btn-default"  data-toggle="modal" data-target="#RefuseConfirmationModal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>



            <form id="data_form{{$value->id}}" method="post" @if($title=='Pharmacies') action="/admin/pharmacy/edit/{{$value->id}}"  @endif
            @if($title=='Pharmacy Forms') action="/admin/pharmacyform/edit/{{$value->id}}"  @endif >
                {{ csrf_field() }}
                <div class="modal fade" id={{$value->id}}edit role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">

                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Pharmacy Info</h4>
                        </div>

                        <div class="modal-body">
                            <p style="display:inline">ID: {{$value->id}} </p>  <br>
                            <p style="display:inline">Name: </p>  <input type="text" name="name_en" value="{{$value->name_en}}"> <br>
                            <p style="display:inline">Address: </p>  <input type="text" name="address_en" value="{{$value->address_en}}"> <br>
                            <p style="display:inline">Landline: </p>  <input type="text" name="landline" value="{{$value->landline}}"><br>
                            <p style="display:inline">Mobile: </p>  <input type="text" name="mobile" value="{{$value->mobile}}"><br>
                            <p style="display:inline">E-mail: </p>  <input type="text" name="email" value="{{$value->email}}"><br>
                            <p style="display:inline">Owner: </p>  <input type="text" name="owner_name" value="{{$value->owner_name}}"><br>
                            <p style="display:inline">Open:</p>  <input type="time" name="open" value="{{$value->open}}"><br>
                            <p style="display:inline">close: </p>  <input type="time" name="close" value="{{$value->close}}">
                        </div>


                            <div class="modal-footer">
                                <button id="save_button" type="button" class="btn btn-default" data-toggle="modal" data-target="#SaveConfirmationModal " data-backdrop="false" >Save</button>
                                <button href='#' type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            </div>


                        <div class="modal fade" id="SaveConfirmationModal" role="dialog" >
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title">Confirmation</h4>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you Sure you want to change the data of this Pharmacy</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-default" >Submit</button>
                                        <button href='#' type="button" class="btn btn-default"  data-toggle="modal" data-target="#SaveConfirmationModal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </form>


@endforeach



    </table>
</div>




</body>
</html>