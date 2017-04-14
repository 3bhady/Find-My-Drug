<!DOCTYPE html>
<html>
<head>
    <style>
        .toast-black{
            background-color:black;
            color:white;

        }
        .blue{
            font-family: Arial;
            color:blue;
            font-style:italic;
            font-weight: 600;
            display:inline-block;

        }
    </style>
    <title>Real-Time Laravel with Pusher</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="//fonts.googleapis.com/css?family=Source+Sans+Pro:200,300,400,600,700,200italic,300italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="http://d3dhju7igb20wy.cloudfront.net/assets/0-4-0/all-the-things.css" />

    <script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="//js.pusher.com/3.0/pusher.min.js"></script>

        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <script>
        // Ensure CSRF token is sent with AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Added Pusher logging
        Pusher.log = function(msg) {
            console.log(msg);
        };
    </script>
</head>
<body>

<div class="stripe no-padding-bottom numbered-stripe">
    <div class="fixed wrapper">
        <ol class="strong" start="1">
            <li>
                <div class="hexagon"></div>
                <h2><b>Get Your Drug</b> <small>Let's relieve some of people's pain.</small></h2>
            </li>

        </ol>
    </div>
</div>

<section class="blue-gradient-background splash">
    <div class="container center-all-container">
        <form id="notify_form" action="/notifications/notify" method="post">

            <div class="input-group input-group-lg">
                <input type="text" id="notify_text" class="form-control" placeholder="What's the medicine looks like..?"
                       name="notify_text" minlength="3" maxlength="140" required >
                <div class="input-group-btn">
                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                </div>

        </form>

    </div>
</section>

<script>
    var pusher = new Pusher('{{env("PUSHER_KEY")}}');
    var channel = pusher.subscribe('test-channel');
    socketId=pusher.connection.socket_id;
    channel.bind('test-event', function(data) {

        // do something with the event data
        toastr.options.closeButton = true;
        toastr.options.closeDuration = 100;
       // toastr.options.extendedTimeOut = 0;
        toastr.options.closeEasing = 'swing';
        toastr.options.timeOut = 0;
    //alert(data["socketId"]);
        
        toastr.success(" some one request drug<br> ('<p class='blue'>"+data["text"]+"</p>')do you have it ?",
                "<h1 " +
                "class='text-info' " +
                "style='font-size:28px;color:white'>Dear pharmacist,</h1>",
                {
                    iconClass: 'toast-black'
                });
    });
    function notifyInit() {
      // set up form submission handling
      $('#notify_form').submit(notifySubmit);
    }

// Handle the form submission
function notifySubmit() {
  var notifyText = $('#notify_text').val();
  if(notifyText.length < 3) {
    return;
  }

  // Build POST data and make AJAX request
  var data = {notify_text: notifyText,
              socket_id:pusher.connection.socket_id};
  $.post('{{Route("notifications.post")}}', data).success(notifySuccess);






  // Ensure the normal browser event doesn't take place
  return false;
}
function x()
{
    alert('back..');
}
// Handle the success callback
function notifySuccess() {

  console.log('notification submitted');
}

$(notifyInit);
</script>

</body>
</html>
