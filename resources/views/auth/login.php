<html>
    <head>
        <title>finance app</title>
        <link rel="stylesheet" href="resources/css/bootstrap.css" type="text/css"/>
        <link rel="stylesheet" href="resources/css/main.css" type="text/css"/>
        <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    </head>
    <body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Lorenum</a>
            </div>
    </nav>
        <div class="container-fluid">
            <form class="form-horizontal" role="form" method="POST" action="auth/login">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <div class="checkbox">
                        <label>
                            <input type="checkbox" name="remember"> Remember Me
                        </label>
                        </div>
                    </div>
                </div>

                 <div class="form-group">
                     <div class="col-md-6 col-md-offset-4">
                         <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                         Login
                         </button>

                         <a href="/password/email">Forgot Your Password?</a>
                     </div>
                 </div>
            </form>
        </div>

        <?php
        if(isset($errors)){
        ?>
            <div class="error-box">
                <p class="error-msg"><?php echo($errors)?></p>
            </div>

        <?php
        }
        ?>

        <div class="container-fluid">
            <form class="form-horizontal" role="form" method="POST" action="auth/register">
                <input type="hidden" name="_token" value="">

                <div class="form-group">
                    <label class="col-md-4 control-label">First name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="first_name" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Last name</label>
                    <div class="col-md-6">
                        <input type="text" class="form-control" name="last_name" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">E-Mail Address</label>
                    <div class="col-md-6">
                        <input type="email" class="form-control" name="email" value="">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="password">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-4 control-label">Repeat Password</label>
                    <div class="col-md-6">
                        <input type="password" class="form-control" name="rep_password">
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
                            Register
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>