<?php
include '../../resources/view/inc/guest-nav.php';
include '../../core/guest.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card z-depth-1">
                <div class="progress md-progress primary-color-dark m-0 p-0" id="registerloader" style="display:none">
                    <div class="indeterminate"></div>
                </div>
                <div class="card-header text-center h1 font-weight-bold aqua-gradient text-white">
                    CARRIUM SIGN UP
                </div>
                <div class="card-body">
                    <div class="col-12 alert alert-danger text-center" id="signupfailed" style="display:none">
                        <span id="signuperrors"></span>
                    </div>
                    <form id="signup">
                        <div class="row">
                            <div class="col-6">
                                <div class="md-form">
                                    <label for="firstname">First Name</label>
                                    <input type="text" name="firstname" id="firstname" class="form-control signup">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form">
                                    <label for="lastname">Last Name</label>
                                    <input type="text" name="lastname" id="lastname" class="form-control signup">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="md-form">
                                    <label for="suemail">Email</label>
                                    <input type="email" name="email" id="suemail" class="form-control signup">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form">
                                    <label for="supassword">Password</label>
                                    <input type="password" name="password" id="supassword" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form">
                                    <label for="conpassword">Confirm Password</label>
                                    <input type="password" name="confirm password" id="conpassword" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class=" btn btn-outline-primary btn-rounded">SIGN UP</button>
                            </div>
                    </form>
                </div>
            </div>
            <div class="card-footer bg-white">
                <div class="row">
                    <div class="col-6 text-center">
                        <a href="../../resources/view/login.php" class="btn btn-link">
                            Login
                        </a>
                    </div>
                    <div class="col-6 text-center">
                        <a href="" class="btn btn-link">FORGET PASSWORD ?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php
include '../../resources/view/inc/guest-footer.php';
