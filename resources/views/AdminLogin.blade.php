<!DOCTYPE html>
<html >
<head>
    <style>
        body {
            background: #eee !important;
        }

        .wrapper {
            margin-top: 80px;
            margin-bottom: 80px;
        }

        .form-signin {
            max-width: 380px;
            padding: 15px 35px 45px;
            margin: 0 auto;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.1);
        }
        .form-signin .form-signin-heading,
        .form-signin .checkbox {
            margin-bottom: 30px;
        }
        .form-signin .checkbox {
            font-weight: normal;
        }
        .form-signin .form-control {
            position: relative;
            font-size: 16px;
            height: auto;
            padding: 10px;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }
        .form-signin .form-control:focus {
            z-index: 2;
        }
        .form-signin input[type="text"] {
            margin-bottom: -1px;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .form-signin input[type="password"] {
            margin-bottom: 20px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
        }


    </style>
    <meta charset="UTF-8">
    <title>Admin Login</title>


    <link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/bootstrap/3.0.2/css/bootstrap.min.css'>



</head>

<body>

<div class="wrapper">
    <form id="LoginForm" action="/admin/signin" method="post" class="form-signin">
        {{ csrf_field() }}
        <h1 style="text-align: center">Find My Drug</h1>
        <h3 class="form-signin-heading" style="text-align: center" >Welcome to Admin Panel</h3>
        <h4 class="form-signin-heading">Please login</h4>
        <input type="text" class="form-control" name="email" placeholder="Email Address" required="" autofocus="" />
        <input type="password" class="form-control" name="password" placeholder="Password" required=""/>
        @if (\Session::has('invalid_input'))

            <h4>Invalid E-mail or Password</h4>

        @endif
        <button id="login" class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
    </form>

</div>

</body>
</html>
