<h1>lol</h1>
<script>
    var name=localStorage.getItem("name");
        if(localStorage.getItem('name'))
        {
            document.write("hello : "+name);
        }
    else
        {
            localStorage.setItem("name","ALI");
            document.write("new user  : "+localStorage.getItem("name"));

        }

    var socket = io.connect('http://localhost:8890');
    socket.on('connect',function(){
       // document.write(socket.io.engine.id);
    });
    socket.on('message', function (data) {
        $( "#messages" ).append( "<p>"+data+"</p>" );
    });
</script>