function login()
{
    var endpoint='http://localhost/findmydrug/public/api/v1/newcustomer/12345';

    $$.get(endpoint,function(succData)
    {
        succData=JSON.parse(succData);
        console.log("logged");

        var User=succData.user;
            setData("customer",JSON.stringify(User));


    },function(errData){
        console.log("error");
        

    });

}