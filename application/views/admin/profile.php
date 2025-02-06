<div class="p-5">

    <h1>First Name :<span class="text-decoration-underline first-name"></span></h1>
    <h1>Last Name :<span class="text-decoration-underline last-name"></span></h1>
    <h1>UserName :<span class="text-decoration-underline user-name"></span></h1>




    <h1>User Education</h1>

    <table class="table">
        <thead>
            <tr>
                <th scope="col">university</th>
                <th scope="col">course</th>
                
            </tr>
        </thead>
        <tbody class="user-edu">
           
        </tbody>
    </table>

    <h1>User Employment</h1>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Company Name</th>
                <th scope="col">Profile</th>
                
            </tr>
        </thead>
        <tbody class="user-emp">

           
        </tbody>
    </table>
</div>

<script>
    function addNewEducation(university, course) {
        html = `<tr><td>${university}</td><td> ${course}</td></tr>`;
        $('.user-edu').append(html);
    }

    function addNewEmployment(companyname, Profile) {
        html = `<tr><td>${companyname}</td><td> ${Profile}</td></tr>`;
        $('.user-emp').append(html);
    }

    function initalize(data) {
        //this fn is automattically called by get_logged_in_userdetail() after getting result from database
        $('.user-name').text(data.user.username);
        $('.first-name').text(data.user.first_name);
        $('.last-name').text(data.user.last_name);
        // if (data.user_education !== array()) {

        if (typeof data.user_education !== 'undefined' && data.user_education.length > 0) {

            data.user_education.forEach(element => {

                addNewEducation(element.university, element.course)
            });
        } else {
            $('.user-edu').append('<tr><td colspan=2>No data found</td></tr>');

        }

        if (typeof data.user_employment === 'undefined' && data.user_employment.length > 0) {
            data.user_employment.forEach(element => {

                addNewEmployment(element.company_name, element.job_profile)
            });
        } else {
            $('.user-emp').append('<tr><td colspan=2>No data found</td></tr>');

        }


    }
    get_logged_in_userdetail()
</script>