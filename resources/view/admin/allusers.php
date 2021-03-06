<?php
include_once '../../../resources/view/inc/admin-nav.php';
include_once '../../../core/admin.php';
?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 mt-3">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="md-form mt-3">
                                <input type="text" class="form-control" name="admin-search" id="admin-search" placeholder="User Search..">
                            </div>
                        </div>
                        <div class="col-sm-1 mt-4 text-center">
                            <span class="badge badge-primary" id="allUserCount">0</span>
                        </div>
                        <div class="col-sm-3 text-center">
                            <select name="limit" id="limit" class="mdb-select md-form">
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
<div class="modal fade" id="userUpdateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header bg-warning">
        <div class="h3 text-center col-12 text-white font-weight-bold">Edit User</div>
      </div>
      <div class="modal-body">
        <form id="editUserForm">
          <div class="row">
            <div class="col-sm-6 md-form">
              <input type="text" class="editUser form-control" name="firstname">
            </div>
            <div class="col-sm-6 md-form">
              <input type="text" class="editUser form-control" name="lastname">
            </div>
            <div class="col-sm-12 md-form">
              <input type="email" name="email" id="editUserEmail" class="form-control editUser">
            </div>
          </div>
            <div class="col-sm-12 text-center">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeUserEditModal">Close</button>
              <button type="submit" class="btn btn-success">Save changes</button>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>
</div>
<?php
include_once '../../../resources/view/inc/admin-footer.php';
