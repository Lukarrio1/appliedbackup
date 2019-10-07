<?php
include '../../resources/view/inc/guest-nav.php';
include '../../core/guest.php'
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card z-dept-1">
                <div class="progress md-progress primary-color-dark m-0 p-0" id="loginloader">
                    <div class="indeterminate"></div>
                </div>
                <div class="card-header text-center h1 font-weight-bold aqua-gradient text-white">
                    CARRIUM SIGN IN
                </div>
                <div class="card-body">
                    <div class="col-12 alert alert-danger text-center" id="loginfailed" style="display:none">
                        Error, invalid credentials!
                    </div>
                    <form id="loginForm">
                        <div class="row">
                            <div class="col-md-8 offset-md-2">
                                <div class="md-form">
                                    <label for="email">Email</label>
                                    <input type="text" name="Email" id="email" class="form-control" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <div class="md-form">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="form-control" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-outline-primary btn-rounded">login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-6 text-center">
                            <a href="../../resources/view/signup.php" class="btn btn-link">REGISTER</a>
                        </div>
                        <div class="col-6 text-center">
                            <a href="../../resources/view/password_resets/enter_email.php" class="btn btn-link">FORGET PASSWORD ?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../../resources/view/inc/guest-footer.php';
