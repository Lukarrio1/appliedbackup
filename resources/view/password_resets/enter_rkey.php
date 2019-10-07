<?php
include '../../../resources/view/inc/guest-nav.php';
include '../../../core/guest.php';
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-center text-white h1 aqua-gradient">
                    CARRIUM PASSWORD RESET
                </div>
                <div class="card-body">
                    <div class="col-12 text-center font-weight-bold">
                        Please enter the reset key that was sent the email that you entered previously.
                    </div>
                    <div class="alert alert-danger col-12 text-center" id="r_keyerror" style="display:none">
                        you have an error
                    </div>
                    <form id="resetpasswordform">
                        <div class="md-form">
                            <input type="text" name="" id="r_key" class="form-control" placeholder="Reset Key">
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="md-form">
                                    <input type="password" name="" id="r_password" class="form-control" placeholder="New Password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form">
                                    <input type="password" name="" id="r_confpassword" class="form-control" placeholder="Confirm Password">
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-rounded btn-outline-primary">RESET</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../../../resources/view/inc/guest-footer.php';