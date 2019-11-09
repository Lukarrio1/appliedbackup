<?php
include_once '../../../resources/view/inc/admin-nav.php';
include_once '../../../core/admin.php';
?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-6 mb-5">
            <div class="card bg-success">
                <div class="card-body">
                    <div class="h3 text-white text-center"><i class="fas fa-user"></i></div>
                    <div class="text-center h4 text-white"> Active Accounts</div>
                    <div class="text-center text-white h5 dashboard" id="active_users">30</div>

                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
        <div class="card bg-success">
                <div class="card-body">
                    <div class="h3 text-white text-center"><i class="fas fa-book"></i></div>
                    <div class="text-center h4 text-white"> All Posts</div>
                    <div class="text-center text-white h5 dashboard" id="posts">30</div>

                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
        <div class="card bg-danger">
                <div class="card-body">
                    <div class="h3 text-white text-center"><i class="fas fa-user-times"></i></div>
                    <div class="text-center h4 text-white"> Deleted Accounts</div>
                    <div class="text-center text-white h5 dashboard" id="deleted_users">30</div>

                </div>
            </div>
        </div>
        <div class="col-md-6 mb-5">
        <div class="card bg-danger">
                <div class="card-body">
                    <div class="h3 text-white text-center"><i class="fas fa-book-dead"></i></div>
                    <div class="text-center h4 text-white">Reported Posts</div>
                    <div class="text-center text-white h5 dashboard" id="reports">30</div>

                </div>
            </div>
        </div>

    </div>
</div>

<?php
include_once '../../../resources/view/inc/admin-footer.php';