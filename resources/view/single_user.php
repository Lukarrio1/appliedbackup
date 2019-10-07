<?php
include '../../resources/view/inc/nav.php';
include '../../core/user.php';
?>
<span id="singleuserpage" style="display:none"></span>
<div class="container">
  <div class="row">
    <div class="col-12 mt-5 text-center" id="friendusercard"></div>
    <div class="col-12">
      <div
        class="modal fade right"
        id="viewallfriends"
        tabindex="-1"
        role="dialog"
        aria-labelledby="myModalLabel"
        aria-hidden="true"
      >
        <!-- Add class .modal-full-height and then add class .modal-right (or other classes from list above) to set a position to the modal -->
        <div class="modal-dialog modal-full-height modal-right" role="document">
          <div class="modal-content">
            <div
              class="modal-header text-center light-blue accent 2  text-white "
            >
              <h3 class="modal-title w-100 font-weight-bold">FRIENDS</h3>
            </div>
            <div class="modal-body">
              <div class="row">
                <div
                  class="col-12"
                  style="height:375px; overflow: auto; overflow-x:hidden;"
                >
                  <ul
                    id="addfriendssearch"
                    class="list-group list-group-flush"
                  ></ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
      <!-- Full Height Modal Right -->
    </div>

  </div>
  <div class="row mt-5" id="userpostoutput">

</div>
</div>
<?php
include '../../resources/view/inc/footer.php';
