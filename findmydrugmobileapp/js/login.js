myApp.onPageInit('login',function(page) {
    myApp.params.swipePanel = false;
    
    token = localStorage.getItem("token");
    endpoint = "http://localhost/public/api/v1/signIn";
    $$('#login').on('click', function () {
        data = myApp.formToData('#loginForm');
        $$.post(endpoint, data, function (succData) {
            succData = JSON.parse(succData);

            //console.log(succData);
            setUpLoginState(succData);
            var user=JSON.parse(getData("user"));
            var name=user.name;
            myApp.alert(name," hello ph: " );
        },function (errorData){
            myApp.alert("invalid username or password ","something went wrong");
            errorData=JSON.parse(errorData.responseText);
            console.log(errorData);

        });
    });

});

    function setUpLoginState(data)
    {
        setData("user",JSON.stringify(data));
        mainView.router.loadPage("index.html");
        console.log("...")

    }