<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | CityInvest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content="I am really happy learn stock trading from market experts and manage my funds by CITYINDEX. " name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= site_url() ?>assets/images/favicon.ico">

    <!-- App css -->
    <link href="<?= site_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= site_url() ?>assets/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
    <link href="<?= site_url() ?>assets/css/custom.css" rel="stylesheet" type="text/css" />

</head>

<body class="authentication-bg pb-0" >

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start logo-block">
                        <a href="<?= site_url() ?>" class="logo-dark">
                            <span><img class="logo-image" src="<?= site_url() ?>assets/images/logo-dark.png" alt=""></span>
                        </a>
                        <a href="<?= site_url() ?>" class="logo-light">
                            <span><img src="<?= site_url() ?>assets/images/logo.png" alt="" ></span>
                        </a>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Sign In</h4>
                    <p class="text-muted mb-4">Enter your email address and password to access account.</p>
                    <?= view('Auth\Views\_notifications') ?>
                    <!-- form -->
                    <form method="POST" action="<?= site_url('login'); ?>" accept-charset="UTF-8">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input type="text" class="form-control" name="email" value="<?= old('email') ?>" Placeholder="Email" />
                        </div>
                        <div class="mb-3">
                            <a href="<?= site_url('forgot-password'); ?>" class="text-muted float-end"><small>Forgot your password?</small></a>
                            <label for="password" class="form-label">Password</label>
                            <input minlength="5" class="form-control" type="password" name="password" value="" placeholder="Password" />
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                <label class="form-check-label" for="checkbox-signin">Remember me</label>
                            </div>
                        </div>
                        <div class="d-grid mb-0 text-center">
                            <?= csrf_field() ?>
                            <button type="submit" class="btn btn-primary"><i class="mdi mdi-login"></i><?= ' '.lang('Auth.login') ?></button>
                        </div>

                    </form>
                    

                </div> 
            </div> 
        </div>

        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">I love the Cityindex!</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i> I am really happy learn stock trading from market experts and manage my funds by CITYINDEX. <i class="mdi mdi-format-quote-close"></i>
                </p>

            </div> 
        </div>

    </div>

    <script src="<?= site_url() ?>assets/js/vendor.min.js"></script>
    <script src="<?= site_url() ?>assets/js/app.min.js"></script>

</body>

</html>