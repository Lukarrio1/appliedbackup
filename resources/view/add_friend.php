<?php
include '.../../../../resources/view/inc/nav.php';
include '../../core/user.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-12 mt-5">
            <div class="card">
                <div class="card-header bg-white">
                    <div class="row">
                        <div class="col-11">
                            <div class="md-form">
                                <input type="text" name="search" id="Searchfriend" class="form-control" placeholder="Search">
                            </div>
                        </div>
                        <div class="col-1 mt-4">
                            <span class="badge badge-primary" id="searchrescount">0</span>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="height:400px; overflow: auto; overflow-x:hidden;">
                    <ul id="searchres" class="list-group list-group-flush">
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
include '../../resources/view/inc/footer.php';
