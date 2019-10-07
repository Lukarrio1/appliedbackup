<?php
include '.../../../../resources/view/inc/nav.php';
include '../../core/user.php';
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2 mt-5 mb-5">
            <div class="card">
                <div class="card-header  green accent-3 text-white text-center h3">
                    <div class="fa fa-plus"></div>Post
                </div>
                <div class="card-body">
                    <div class="col-md-8 offset-md-2 text-center">
                        <div class="mb-2">
                            <img src="" alt="" style="width:50%" id="tempportfolioimage" />
                        </div>
                    </div>
                    <form id="createpost">
                        <div class="row">

                            <div class="col-md-8 offset-md-2">
                                <div class="md-form">
                                    <label for="posttitle">POST TITLE</label>
                                    <input type="text" name="post title" id="posttitle" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <div class="md-form">
                                    <label for="postbody">POST BODY</label>
                                    <textarea name="" id="postbody" cols="30" rows="1" class="form-control md-textarea"></textarea>
                                </div>
                            </div>
                            <div class="col-md-8 offset-md-2">
                                <div class="file-field">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <span>Choose file</span>
                                        <input type="file" id="postimgin">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Upload your file" id="postimgout">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 text-center">
                                <hr>
                                <button type="submit" class="btn btn-outline-success btn-rounded">CREATE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-5" id="allposts">

    </div>
</div>


<?php
include '../../resources/view/inc/footer.php';
