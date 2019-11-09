<?php
include_once '../../../resources/view/inc/guest-nav.php';
include_once '../../../core/guest.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card mt-5">
                <div class="card-header text-center text-white font-weight-bold h3 bg-success">
                    CARRIUM ADMIN LOGIN
                </div>
                <div class="card-body">
                    <form id="admin-login">
                        <div class="row">
                            <div class="col-md-8 offset-md-2 md-form">
                                <input type="email" name="email" id="email" class="form-control admin" placeholder="Email">
                            </div>
                            <div class="col-md-8  offset-md-2 md-form">
                                <input type="password" name="password" id="password" name="password" class="admin form-control" placeholder="Password">
                            </div>
                            <div class="col-md-12 text-center">
                                <button class="btn btn-success btn-md btn-rounded" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once '../../../resources/view/inc/admin-footer.php';