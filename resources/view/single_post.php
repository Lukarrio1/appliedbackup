<?php
include '../../resources/view/inc/nav.php';
include '../../core/user.php';
?>
<span id="single_post"></span>
<div class="container">
  <div class="row">
    <div class="col-md-10 offset-md-1 mt-2">
      <div class="card">
        <div
          class="card-header text-center h3 bg-success text-white font-weight-bold"
        >
          This is the card title
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-center">
              <img
                src="https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80"
                class=" border border-success"
                style="width:70%"
              />
            </div>
            <div class="col-12 text-center">title section</div>
            <div class="col-12 pl-5">body section</div>
            <div class="col-12 text-center">
              this btn section
            </div>
            <div class="col-12">
              this is the comment section
            </div>
          </div>
        </div>
        <div class="card-footer bg-white">
          this is the card footer if you didnt notice that it is at the card
        </div>
      </div>
    </div>
  </div>
</div>
<?php
include '../../resources/view/inc/footer.php';
