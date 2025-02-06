//main file included in each admin page 

if (!jwtToken) {
    //if token not found redirect to login page
    window.location.href =  window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/admin/";
}

function logout() {
    localStorage.removeItem('jwt_token');
    window.location.href =  window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/admin/";
}

//add token in each table request
$('#data-table').bootstrapTable({
    ajaxOptions: {
        beforeSend: function(xhr) {
            // Set Authorization header with Bearer JWT token
            xhr.setRequestHeader('Authorization', 'Bearer ' + localStorage.getItem('jwt_token'));
        }
    }
})