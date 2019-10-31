<?php
include_once '../../../resources/view/inc/guest-nav.php';
include_once '../../../core/guest.php';
?>

<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header text-center text-white font-weight-bold h3">
                    CARRIUM ADMIN LOGIN
                </div>
                <div class="card-body">
                    <form id="admin-login">
                        <div class="row">
                            <div class="col-md-12 md-form">
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="col-md-12 md-form">
                                <input type="password" name="password" id="password" name="password" class="form-control">
                            </div>
                            <div class="col-md-12 text-center">
                                <button class="btn btn-outline-success" type="submit">Login</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
