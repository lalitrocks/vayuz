<div style="height: 80px;background-color: green;">
    <h1 class="text-white pt-3 ps-5">Welcome <span class=" user-name" style="font-weight: 900;"></span></h1>
</div>
<div class="d-flex  flex-wrap  py-5">
    <a>
        <div class="card text-center ms-5" style="width: 22rem;height: 220px; background-color: orange">
            <h3 class="mt-3"><b>Last Log In</b></h3>
            <div class="d-flex my-5">

                <i class="fas fa-home mx-4 " style="font-size: 40px;"></i>

                <h2><b class="last-log-in"></b></h2>

            </div>
        </div>
    </a>


    <a href="<?= base_url('admin/users/') ?>" class="total-users-container">
        <div class="card text-center ms-5 " style="width: 22rem;height: 220px; background-color: pink">
            <h3 class="mt-3"><b>Total Users</b></h3>

            <div class="d-flex my-5">
                <!-- <i class="fa-solid "></i> -->
                <i class="fas fa-star mx-4 w-25" style="font-size: 40px;"></i>

                <h2 class="w-75"><b class="total-users "></b></h2>

            </div>
        </div>
    </a>
    <a href="<?= base_url('admin/users/')   ?>" class="last-five-users-container">
        <div class="card text-center ms-5 " style="width: 22rem;height: 310px; background-color: aqua">
            <h3 class="mt-3"><b>Last Added Users</b></h3>

            <div class="d-flex my-5">
                <!-- <i class="fa-solid "></i> -->
                <i class="fas fa-bars mx-4 w-25" style="font-size: 40px;"></i>

                <h2 class="w-75"><b class="last-five-users "></b></h2>

            </div>
        </div>
    </a>
</div>


<script>
     $('.total-users-container').hide()
     $('.last-five-users-container').hide()
    function initalize(data) {
        //this fn is automattically called by get_logged_in_userdetail() after getting result from database
        $('.user-name').text(data.user.username);
        $('.last-log-in').text(data.last_log_in);

        if (data.user.role == 1) {
            $('.total-users-container').show()
            $('.last-five-users-container').show()
            $('.total-users').text(data.total_users);

            last_five_users_html = '';
            count = 0;
            JSON.parse(data.last_five_users).forEach(element => {

                count++;
                last_five_users_html += `<span>${element.username}</span><br/>`;
            });


            $('.last-five-users').html(last_five_users_html);
        }

    }

    get_logged_in_userdetail();


</script>