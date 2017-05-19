function setupSocket(){
    var socket = io.connect('http://localhost:8890');
    socket.on('connect',function(){
        //adding socketId to user
        console.log(socket.io.engine.id);
        socketId=socket.io.engine.id;
        user=getData("customer");
        console.log(user);
        userModified=JSON.parse(user);
        userModified.socket_id=socketId;
        setData("customer",JSON.stringify(userModified));
        console.log("customer------>",getData("customer"));
        socket.emit("addCustomer",JSON.parse(getData("customer")));
    });

socket.on('pharmacyResponse',function(message){
    console.log("new response from pharmacy");
    console.log(message);
    myApp.addNotification({
        message: 'pharmacy: '+message["pharmacy_name"]+' has drug '+message["drug_name"],
        button: {
            text: 'I got it',
            color: 'yellow'
        }
    });
    CreatePharmaciesList(message);
})
};


CreatePharmaciesList= function(data) {
    var middle = '';
    //var start = '<div class="list-block">' + ' <ul>';
    //var end = ' </ul> ' + '</div>';
    // for (var i = 0; i < data.length; i++) {
    // middleList+=" <li value="+value+">"+key+"</li>";

    /*        middle+='  <a id="'+value+'" href="drug.html" class="item-link"> ' +
     '<div class="item-media"><i class="icon icon-f7"></i></div> ' +
     '<div class="item-inner"> ' +
     '<div class="item-title">' +
     key+
     '</div> ' +
     '</div>';
     });*/
    middle += '    <li> ' +
        '<a href="pharmacy.html" class="item-link item-content pharmacy" data-id="' + data[Object.keys(data)[0]] + '"> ' +
        '<div class="item-media"><i class="icon icon-f7"></i></div> ' +
        '<div class="item-inner"> ' +
        '<div class="item-title">' + data[Object.keys(data)[1]] + '</div> ' +
        '<div class="item-after">View</div> ' +
        '</div> ' +
        '</a> ' +
        '</li>';
    // }

    //$$('#pharmacies-view').empty();
    $$('#pharmacies-view').prepend( middle );
    //$$('#pharmacies-view').append(start + middle + end);
    //$$('#list-view').clear();
    //$$('#list-view').append(start+middle+end);
    $$('.pharmacy').on('click', function () {
        localStorage.setItem("pharmacy_id",data[0]);
        console.log(localStorage.getItem("pharmacy_id"));
    });
    /* $$.each(data,function(key,value) {
     var li = document.getElementById(value).onclick = function () {
     console.log(value);
     localStorage.setItem("drug_id",value);
     }
     });*/
    console.log(localStorage.getItem("pharmacy_id"));
};

