<?php
include '../../../resources/view/inc/guest-nav.php';
include '../../../core/guest.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5">
            <div class="card">
                <div class="card-header text-center h1 aqua-gradient text-white">
                    CARRIUM PASSWORD RESET
                </div>
                <div class="card-body">
                    <div class="col-12 text-center">
                        <span class="font-weight-bold">Please enter your email below.</span>
                    </div>
                    <form id="passwordEmailForm">
                        <div class="row">
                            <div class="col-12">
                                <div class="alert alert-danger text-center" id="errorEnterEmail" style="display:none">
                                    Email is not found please try again!
                                </div>
                                <div class="md-form">
                                    <label for="ememail">Enter Email</label>
                                    <input type="text" name="email" id="ememail" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-rounded btn-outline-primary">Send</button>
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
