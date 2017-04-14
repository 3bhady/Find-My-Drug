<!DOCTYPE html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Find-My-Drug</title>


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <!--bootstrap -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
          crossorigin="anonymous">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="{{URL::to('js/jquery.min.js')  }}"></script>
    <!-- libraries from downloaded theme !-->
    <link href="{{URL::to('css/theme/font-awesome.css')  }}" rel="stylesheet" type="text/css">


    <script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>


    <STYLE>
        body{
            background-color:white;
        }
    </STYLE>

</head>
<body  id="home" class="homepage" >

@include('partials.login')
@yield('content')

<script src="{{URL::to('js/bootstrap.min.js')  }}"></script>



</body>
</html>
