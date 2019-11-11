<?php
include_once '../../../resources/view/inc/admin-nav.php';
include_once '../../../core/admin.php';
?>

<div class="container">
   <div class="row mt-5">
       <div class="col-md-10 offset-md-1">
           <div class="card">
               <div class="card-header text-center text-white h3 font-weight-bold">
                    Edit Admin Info
               </div>
               <div class="card-body">
                   <form id="edit-admin">
                       <div class="row">
                           <div class="col-md-6 md-form">
                               <input type="text" name="name" id="admin-name" class="form-control edit-admin">
                           </div>
                            <div class="col-md-6 md-form">
                                <input type="email" name="email" id="admin-email" class="form-control edit-admin">
                            </div>
                        <div class="col-md-12 text-center">
                            <button class="btn btn-warning" type="submit">UPDATE</button>
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