<?php
include_once '../../../resources/view/inc/admin-nav.php';
include_once '../../../core/admin.php';
?>
<div class="container">
<div class="row">
    <div class="col-md-12">
        <div class="card mt-5">
                <div class="card-header bg-white">
                <div class="row">
                    <div class=" md-form col-sm-7">
                        <input type="text" name="post_search" id="post_search" placeholder="Search reports" class="form-control">
                    </div>
                    <div class=" text-center mt-4 col-sm-1">
                        <span id="allReportsCount" class="badge badge-primary">0</span>
                    </div>
                    <div class=" col-sm-4">
                    <select class="mdb-select md-form" id="limitReports">
                    <option id="limitReportsAll" selected></option>
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="40">40</option>
                    <option value="80">80</option>
                    </select>
                    </div>
                </div>
            </div>
            <div class="card-body">
            <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">FirstName</th>
                    <th scope="col">LastName</th>
                    <th scope="col">Title</th>
                    <th scope="col">Body</th>
                    <th scope="col">Reporter ID</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody id="allReportsDisplay">
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
