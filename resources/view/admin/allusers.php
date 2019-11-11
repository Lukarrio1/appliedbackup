<?php
include_once '../../../resources/view/inc/admin-nav.php';
include_once '../../../core/admin.php';
?>
<style>
.my-custom-scrollbar {
position: relative;
height: 380px;
overflow: auto;
overflow-x:hidden;
}
.table-wrapper-scroll-y {
display: block;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-3">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="md-form mt-3">
                                <input type="text" class="form-control" name="admin-search" id="admin-search" placeholder="User Search..">
                            </div>
                        </div>
                        <div class="col-md-1 mt-4 text-center">
                            <span class="badge badge-primary" id="allUserCount">0</span>
                        </div>
                        <div class="col-md-3 text-center mt-4">
                            <select name="limit" id="limit" class="browser-default custom-select">
                                <option value="" id="allUsers" selected></option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height:420px;">
                <div class="table-wrapper-scroll-y my-custom-scrollbar mb-1" >

                <table class="table table-bordered table-striped mb-0">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Status</th>
                    <th scope="col">First</th>
                    <th scope="col">Last</th>
                    <th scope="col">Email</th>
                    <th scope="col">Posts Count</th>
                    <th scope="col">Friends Count</th>
                    <th scope="col" class="text-center">Action</th>
                    </tr>

                </thead>
                <tbody id="allUsersOutput">

                </tbody>
                </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once '../../../resources/view/inc/admin-footer.php';
