<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Design by foolishdeveloper.com -->
    <title><?= $title ?></title>
    <link rel="shortcut icon" href="<?= SERVER_URL ?>assets/images/favicon.png" type="image/x-icon">
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />

    <link rel="stylesheet" href="<?= SERVER_URL ?>assets/bootstrap/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <!--Stylesheet-->
    <style media="screen">
        *,
        *:before,
        *:after {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #080710;
        }

        .background {
            width: 430px;
            height: 520px;
            position: absolute;
            transform: translate(-50%, -50%);
            left: 50%;
            top: 50%;
        }

        .background .shape {
            height: 200px;
            width: 200px;
            position: absolute;
            border-radius: 50%;
        }

        .shape:first-child {
            background: linear-gradient(#1845ad,
                    #23a2f6);
            left: -80px;
            top: -80px;
        }

        .shape:last-child {
            background: linear-gradient(to right,
                    #ff512f,
                    #f09819);
            right: -30px;
            bottom: -80px;
        }

        form {
            width: 400px;
            background-color: rgba(255, 255, 255, 0.13);
            border-radius: 10px;
            margin: 40px auto;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 40px rgba(8, 7, 16, 0.6);
            padding: 50px 35px;
        }

        form * {
            font-family: 'Poppins', sans-serif;
            /* color: #ffffff; */
            letter-spacing: 0.5px;
            outline: none;
            border: none;
        }

        form h3 {
            font-size: 32px;
            font-weight: 500;
            line-height: 42px;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 30px;
            font-size: 16px;
            font-weight: 500;
        }

        input {
            display: block;
            height: 50px;
            width: 100%;
            color: white;
            background-color: rgba(255, 255, 255, 0.07);
            border-radius: 3px;
            padding: 0 10px;
            margin-top: 8px;
            font-size: 14px;
            font-weight: 300;
        }

        ::placeholder {
            color: #e5e5e5;
        }

        button {
            margin-top: 50px;
            width: 100%;
            background-color: #ffffff;
            color: #080710;
            padding: 15px 0;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
        }

        .social {
            margin-top: 30px;
            display: flex;
        }

        .social div {
            background: red;
            width: 150px;
            border-radius: 3px;
            padding: 5px 10px 10px 5px;
            background-color: rgba(255, 255, 255, 0.27);
            color: #eaf0fb;
            text-align: center;
        }

        .social div:hover {
            background-color: rgba(255, 255, 255, 0.47);
        }

        .social .fb {
            margin-left: 25px;
        }

        .social i {
            margin-right: 4px;
        }

        @media screen and (max-width:400px) {
            form {
                width: 100%;
            }
        }
    </style>
    <script>
        const jwtToken = localStorage.getItem('jwt_token');
        if (jwtToken) {
            //if token found , redirect to dashboard
            window.location.href = window.location.protocol + "//" + window.location.hostname + "/lalit_vayuz/admin/dashboard";
        }
        var base64data;

    </script>
</head>

<body>
    <div class="background d-none d-sm-block">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <form method="post" action="<?= SERVER_URL ?>api/<?= ($title == 'Admin register') ? 'register' : 'login' ?>">
        <h3 class="text-white">Admin <?= ($title == 'Admin register') ? 'Register' : 'Login' ?></h3>

        <p class="success text-success"></p>
        <p class="error text-danger"></p>

        <?php if ($title == 'Admin register') { ?>
            <label class="text-white" for="role">Acoount Type</label>
            <select id="role" name="role">
                <option selected value="0">User</option>
                <option value="1"> Admin</option>
            </select>

            <label class="text-white" for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="First name" required>

            <label class="text-white" for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Last name " required>
        <?php } ?>



        <label class="text-white" for="username">Username</label>
        <input type="text" placeholder="Username" id="username" name="username">

        <label class="text-white" for="password">Password</label>
        <input type="password" placeholder="Password" id="password" name="password">

        <?php if ($title == 'Admin register') { ?>
            <label class="text-white" for="c_password">Confirm Password</label>
            <input type="password" placeholder="Confirm Password" id="c_password" name="c_password">
        <?php } ?>

        <button class="mb-2" type="submit"><?= ($title == 'Admin register') ? 'Register' : 'Log In' ?></button>

        <?php if ($title == 'Admin register') { ?>
            <a href="<?= SERVER_URL ?>/admin/login">Already have an account?</a>
        <?php } else { ?>
            <a href="<?= SERVER_URL ?>/admin/register">Dont have an account?</a>
        <?php } ?>

    </form>


    <script src="<?= SERVER_URL ?>assets/js/admin/jquery-3.7.1.min.js"></script>
    <script src="<?= SERVER_URL ?>assets/js/ajax.js"></script>
    
</body>

</html>