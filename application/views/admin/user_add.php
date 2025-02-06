<style>
    .ql-header[value="3"]::after {
        content: 'H3';
        position: absolute;
        top: 2px;
    }

    .ql-header[value="3"] {
        position: relative;
    }

    input[type="text"],
    input[type="password"] {
        width: 80%;
        border: 0;
        height: 32px;
        border-bottom: 1px solid black;
    }

    *:required:invalid {
        border-bottom: 1px solid red;
    }


    select {
        height: 30px;
        padding: 6px;
        border-radius: 4px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" />
<style type="text/css">
    img {
        display: block;
        max-width: 100%;
    }

    .preview {
        overflow: hidden;
        width: 160px;
        height: 160px;
        margin: 10px;
        border: 1px solid red;
    }
</style>
<div class="p-4 blog_add">

    <form action="<?= SERVER_URL ?>api/<?= isset($user_id) ? 'edit_user' : 'add_user' ?>" method="post">
        <h2>Add user</h2>

        <?php
        if (isset($user_id)) {
        ?>
            <input type="hidden" name="id" value="<?= $user_id ?>">
        <?php }  ?>
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="first_name" required>
        <br>

        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="last_name" required>
        <br>

        <label for="username">Username</label>
        <input required type="text" placeholder="Username" id="username" name="username">

        <label for="password">Password</label>
        <input <?= isset($user_id) ? '' : 'required' ?> type="password" placeholder="Password" id="password" name="password">

        <label for="c_password">Confirm Password</label>
        <input <?= isset($user_id) ? '' : 'required' ?> type="password" placeholder="Confirm Password" id="c_password" name="c_password">

        <label for="profile_img">Profile Image</label>
        <img src="" class="d-none" id="preview_img_last">
        <input <?= isset($user_id) ? '' : 'required' ?> type="file" name="profile_img" id="profile_img">
        <br>

        <h2 class="mt-5"> User Education</h2>

        <div class="user-edu-container mt-4">
            <button type="button" onclick="addNewEducation()">Add new row</button>
        </div>


        <h2 class="mt-5"> User Employment</h2>

        <div class="user-emp-container mt-4">
            <button type="button" onclick="addNewEmployment()">Add new row</button>
        </div>

        <p class="success text-success"></p>
        <p class="error text-danger"></p>



        <button class="btn btn-secondary btn-sm mt-3" type="submit">Submit</button>
    </form>



    <!-- //modal crop   -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <!--  default image where we will set the src via jquery-->
                                <img id="image">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="cancel" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
<script>
    //image crop
    var bs_modal = $('#modal');
    var image = document.getElementById('image');
    var cropper, reader, file;


    $("body").on("change", "#profile_img", function(e) {
        var files = e.target.files;
        var done = function(url) {
            image.src = url;
            bs_modal.modal('show');
        };


        if (files && files.length > 0) {
            file = files[0];

            if (URL) {
                done(URL.createObjectURL(file));
            } else if (FileReader) {
                reader = new FileReader();
                reader.onload = function(e) {
                    done(reader.result);
                };
                reader.readAsDataURL(file);
            }
        }
    });

    bs_modal.on('shown.bs.modal', function() {
        cropper = new Cropper(image, {
            aspectRatio: 1,
            viewMode: 3,
            preview: '.preview'
        });
    }).on('hidden.bs.modal', function() {
        cropper.destroy();
        cropper = null;
    });

    $("#cancel").click(function() {
        bs_modal.modal('hide');

    })

    $("#crop").click(function() {
        canvas = cropper.getCroppedCanvas({
            width: 160,
            height: 160,
        });

        canvas.toBlob(function(blob) {
            url = URL.createObjectURL(blob);
            var reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onloadend = function() {
                base64data = reader.result;
                //alert(base64data);
                bs_modal.modal('hide');
                alert("Proceed to submit form");

            };
        });
    });
</script>

<script>
    restrictedContent()


    //Start -- education and employment functionality
    var last_eduindex = 1;

    function addNewEducation(university = "", course = "", id = '') {
        $('.user-edu-container').append(`<div class="user-edu-fieldcontainer d-flex" >
                <div class="w-50">
                    <label for="university_${last_eduindex}">University</label>
                    <input required type="text" name="university[]" value='${university}' id="university_${last_eduindex}">
                </div>

                <div class="w-50">
                    <label for="course${last_eduindex}">Course</label>
                    <input required type="text" name="course[]" value='${course}' id="course_${last_eduindex}">
                    <i style="cursor:pointer" class="fas fa-remove"  onclick=removerow(this)></i>
                    <input required type="hidden" name="university_id[]" value='${id}' >

                </div>

            </div>`);
    }

    var last_index = 1;

    function addNewEmployment(company = "", jobprofile = "", id = '') {
        $('.user-emp-container').append(`<div class="user-emp-fieldcontainer d-flex" >
                <div class="w-50">
                    <label for="company_${last_index}">Company Name</label>
                    <input required type="text" name="company[]" value='${company}' id="company_${last_index}">
                </div>

                <div class="w-50">
                    <label for="jobprofile_${last_index}">Job Profile</label>
                    <input required type="text" name="jobprofile[]" value='${jobprofile}' id="jobprofile_${last_index}">
                    <i style="cursor:pointer" class="fas fa-remove" onclick=removerow(this)></i>
                    <input required type="hidden" name="company_id[]" value='${id}' >

                </div>
            </div>`);
        last_index++;
    }

    function removerow(element) {
        element.parentElement.parentElement.remove();
    }

    //End -- education and employment functionality


    //resize image

    <?php if (isset($user_id)) {
    ?>

        //if its a edit case , then prefill all fields

        const formData = new FormData();
        formData.append("id", <?= $user_id ?>);

        $.ajax({
            headers: {
                'Authorization': 'Bearer ' + jwtToken // Include the JWT token
            },
            method: "POST",
            data: formData,
            url: window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/api/get_user_detail_by_id",
            processData: false, // Do not process the data
            contentType: false
        }).done(function(res) {
            res = JSON.parse(res);

            if (res.status == 200) {

                //populating all fields
                $('#first_name').val(res.data.user.first_name);
                $('#last_name').val(res.data.user.last_name);
                $('#username').val(res.data.user.username);
                $('#username').val(res.data.user.username);
                $('#preview_img_last').removeClass('d-none')
                $('#preview_img_last').attr('src', '<?= base_url('assets/images') . '/' ?>' + res.data.user.profile_img)


                if (res.data.user_education !== null) {
                    res.data.user_education.forEach(element => {
                        addNewEducation(element.university, element.course, element.id)
                    });
                }

                if (res.data.user_employment !== null) {
                    res.data.user_employment.forEach(element => {
                        addNewEmployment(element.company_name, element.job_profile, element.id)
                    });
                }
            } else {
                window.location.href = window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/admin/dashboard";
            }

        })
    <?php
    }
    ?>
</script>