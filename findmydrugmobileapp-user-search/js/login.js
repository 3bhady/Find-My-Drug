function login()
{
    var endpoint='http://localhost/findmydrug/public/api/v1/newcustomer/'+key;

    $$.get(endpoint, data,function(succData)
    {
        console.log("logged");
        console.log(succData);

    },function(data){
        console.log("error");
        console.log(data);

    });

}