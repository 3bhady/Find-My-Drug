function login()
{
    var endpoint=api +'/newcustomer/12345';

    $$.get(endpoint,function(succData)
    {
        succData=JSON.parse(succData);


        var User=succData.user;
            setData("customer",JSON.stringify(User));
        console.log(JSON.parse(getData("customer")));

    },function(errData){
        console.log("error");
        

    });

}