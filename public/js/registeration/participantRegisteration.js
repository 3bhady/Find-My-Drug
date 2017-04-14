$( document ).ready(function() {
    $("#submit").click(function(){log();});
    function log (){
        $('html, body').animate({scrollTop:0}, 'slow');
        nat_id=$('#nat_id').val();
        first_name=$('#first_name').val();
        last_name=$('#last_name').val();
        age=$('#age').val();
        gender=$('#gender').val();
        mobile=$('#mobile').val();
        email=$('#email').val();
        university=$('#university').val();
        major=$('#major').val();

        formData=  {
            "nat_id":nat_id,
            "first_name":first_name,
            "last_name":last_name,
            "age":age,
            "gender":gender,
            "mobile":mobile,
            "email":email,
            "university":university,
            "major":major

        };
        $.ajax({
            type: 'POST',
            contentType:"application/json",

            url: '/IEEE-CUSB-Website/public/api/v1/participants-forms',
            data: JSON.stringify(formData),
            dataType: 'json',
            success: function(data){

                done='<div class="alert alert-success">'+
                    '<div class="container-fluid">'+
                    '<div class="alert-icon">'+
                    '<i class="material-icons">check</i>'+
                    ' </div> '+
                    '<button type="button" ' +
                    'class="close" data-dismiss="alert"' +
                    ' aria-label="Close">'+
                    '<span aria-hidden="true">' +
                    '<i class="material-icons">clear</i></span>'+
                    '</button>'+
                    '<b>'+data["message"] +' , MR:</b>'+
                    data["name"]         +
                    '</div></div>';
                $('#registeration').empty();
                $('#registeration').append(done);


            },
            error:function (data){
                var errors = data.responseJSON;


                errorsHtml='';
                $.each(errors,function(key,value){

                    errorsHtml += '<div class="alert alert-danger"><ul>'+
                        '<div class="container-fluid">'+
                        ' <div class="alert-icon"> '+
                        '<i class="material-icons">error_outline</i>'+
                        '</div>'+
                        '<button type="button" class="close" ' +
                        'data-dismiss="alert" aria-label="Close">'+
                        '<span aria-hidden="true">' +
                        '<i class="material-icons">clear</i>' +
                        '</span></button>'+
                        '<b>'+key +':'+
                        '</b>'+
                        value+
                        '</div></div>'

                });
                $('#registeration').empty();
                $('#registeration').append(errorsHtml);



            }
        });

    }






});