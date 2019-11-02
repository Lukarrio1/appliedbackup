
<?php
include '../../resources/view/inc/nav.php';
include '../../core/user.php';
?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                     <div class="row">
                         <div class="col-md-11">
                                <div class="md-form">
                                    <input type="text" name="search" id="allfriendsSearch" class="form-control" placeholder="Search friends">
                                </div>
                         </div>
                         <div class="col-md-1 text-center">
                         <span class="badge badge-primary mt-4" id="allfriendsCount">0</span>
                         </div>
                     </div>
                </div>
                <div class="card-body" style="height:400px; overflow: auto; overflow-x:hidden;">
                    <ul id="searchallfriendsres" class="list-group list-group-flush">
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
<?php
include '../../resources/view/inc/footer.php';
