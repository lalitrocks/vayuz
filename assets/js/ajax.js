$(document).ready(function () {
    //any form submission in whole application is halted, and data is submitted thorugh ajax using an api controller  
    $("form").submit(function (event) {
        event.preventDefault();

        

        var formData = new FormData(this);  // Use FormData to handle file upload and form data together
        // var formDataArray = $(this).serializeArray();

        if ( base64data !== undefined) {
            
            formData.append('base64crop',base64data);
        }
        

        var data = {
            method: "POST",
            url: $(this).attr('action'),
            data: formData, //sending json data
            processData: false,  // Do not process the data
            contentType: false
        }

        if (jwtToken) {
            data.headers = {
                'Authorization': 'Bearer ' + localStorage.getItem('jwt_token')  // Include the JWT token
            };
        }

        $.ajax(data).done(function (res) {
            res = JSON.parse(res);

            if (res.status == 200) {

                $('.error').text(' ');
                $('form').trigger('reset');
                $('.success').text(res.data.msg);

                if (res.data.msg == 'Login Successfully') {
                    // Store JWT token and user details in localStorage (or sessionStorage), if login success

                    localStorage.setItem('jwt_token', res.data.token);
                    localStorage.setItem('user_role', res.data.role);

                    window.location.reload();

                } else if (res.data.msg == 'User added successfully' || res.data.msg == 'User Updated successfully') {
                    // Store JWT token and user details in localStorage (or sessionStorage), if updated in admin panel

                    window.location.href = window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/admin/users";
                }

            } else if (res.status == 500) {
                logout()
            } else {
                $('.success').text(' ');
                $('.error').text(res.data.msg);

            }
        }).fail(function (err) {
            alert('something went wrong')
        });
    })


})