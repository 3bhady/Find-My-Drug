function setupSocket(){
    var socket = io.connect('http://localhost:8890');
    token=(JSON.parse(getData("user"))).token;
addPharmacyEndPoint=api+"/addpharmacy?token="+token;
socket.on('connect',function(){

    console.log(socket.io.engine.id);
    socketId=socket.io.engine.id;

    //call endpoint to add pharmacy
    data =JSON.parse(getData("user"));
    data.socketId=socketId; 
    $$.post(addPharmacyEndPoint, data, function (succData) {
        console.log(succData);
    },function(errorData){
        console.log(errorData);
    });
    console.log(socketId);
});

socket.on('notification',function(notification) {
//console.log(notification);
    addEvents(notification);
});
}
function addEvents(data)
{


    myApp.modal({
        title:  'new drug request !',
        text: 'drug : '+data["drug_name"]+ 'customer_id : '+data["user_id"],
        buttons: [
            {
                text: 'I have it ',
                onClick: function(x) {
                    var requestObject={
                        "drug_request_pharmacy_response_id":data["drug_request_pharmacy_response_id"],
                        "pharmacy":JSON.parse(getData("user")),
                        "drug_id":data["drug_id"],
                        "user_id":data["user_id"],
                        "drug_name":data["drug_name"]
                    }
                    //console.log(requestObject);
                pharmacyResponse(requestObject);
                }
            },
            {
                text: 'I do not have it' ,
                onClick: function() {

                }
            },

        ]
    });


    //todo send response to controller

}
function pharmacyResponse(requestObject)
{
    console.log("in pharmacy repsonse");
    token=(JSON.parse(getData("user"))).token;
    endpoint=api+"/pharmacyAcceptDrug?token="+token;

    $$.post(endpoint, requestObject, function (succData) {
        console.log(succData);
    },function(errorData){
        console.log(errorData);
    });

}