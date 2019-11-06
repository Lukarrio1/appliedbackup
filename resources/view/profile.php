<?php
include '../../resources/view/inc/nav.php';
include '../../core/user.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 mt-5">
            <div class="card">
                <div class="card-header light-blue accent-2 text-center h3 text-white">
                    EDIT ACCOUNT
                </div>
                <div class="card-body">
                    <div class="col-12">
                        <div class="alert alert-danger text-center" id="errorupdateusers" style="display:none">

                        </div>
                    </div>
                    <form id="updateuserinformation">
                        <div class="row">
                            <div class="col-6">
                                <div class="md-form">
                                    <input type="text" name="" id="firstname" class="form-control">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="md-form">
                                    <input type="text" name="" id="lastname" class="form-control">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="md-form">
                                    <input type="text" name="" id="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-rounded btn-outline-primary">UPDATE</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mt-5 mb-5">
            <!-- Card -->
            <div class="card testimonial-card">

                <!-- Background color -->
                <div class="card-up  light-blue accent-2"></div>

                <!-- Avatar -->
                <div class="avatar mx-auto white">
                    <img src="" class="rounded-circle" alt="woman avatar" id="profileImageOut">
                </div>

                <!-- Content -->
                <div class="card-body">
                    <!-- Name -->
                    <h4 class="card-title"> <span id="usercardfname"></span>&nbsp;<span id="usercardlname"></span><br>
                        <small> <span id="usercardemail"></span></small></h4>
                </div>
                <div class="card-footer bg-white">
                    <div class="row">
                        <div class="col-12 md-form text-center">
                            <form id="uploadProPic">
                            <div class="file-field">
                            <div class="btn btn-primary btn-sm float-left">
                                <span>Choose file</span>
                                <input
                                    type="file"
                                    id="profileImgIn"
                                    required
                                />
                            </div>
                            <div class="file-path-wrapper">
                                <input
                                    class="file-path validate"
                                    type="text"
                                    placeholder="Upload your file"
                                    id="profileImgOut"
                                    readonly
                                />
                            </div>
                        </div>
                            </form>
                        </div>
                        <div class="col-12 text-center">
                            <a href="#!" class="btn btn-danger" id="deleteuser" title="Delete Account"><i class="fa fa-trash"></i></a>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Card -->
        </div>
    </div>
</div>

<?php
include '../../resources/view/inc/footer.php';
