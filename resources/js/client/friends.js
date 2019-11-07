var allfriends = document.querySelector("#allfriendsSearch") || null;
var allfriendsCount = document.querySelector("#allfriendsCount") || null;
if (allfriends) {
  allfriends.addEventListener("keyup", () => {
    let search = allfriends.value || "all";
    if (search.length >= 3) {
      searchFriends(search);
    }
  });
}

searchFriends = (search = "all") => {
  let fd = new FormData();
  fd.append("search", search);
  let searchallfriendsres =
    document.querySelector("#searchallfriendsres") || null;
  axios
    .post("../../../controllers/FriendController.php?function=4", fd)
    .then(res => {
      let output = "";
      let newfriend = res.data.filter(f => f.is_friend == 1);
      if (allfriendsCount) {
        allfriendsCount.innerHTML = newfriend.length || 0;
      }
      newfriend.forEach(f => {
        let is_active = f.is_active == 1 ? "success" : "danger";
        output += `
     <li class="list-group-item">
     <a id="friend${f.id}" class="viewfriend">
     <div class="row">
     <div class="col-md-2">
     <span class="text-${is_active}"><i class="fa fa-circle"></i></span>
     </div>
     <div class="col-md-3 text-center">${f.firstname}</div>
     <div class="col-md-3 text-center">${f.lastname}</div>
     <div class="col-md-4 text-center">${f.email}${
          f.is_del == 1
            ? `(<span class='text-danger'><i class="fas fa-user-times"></i></span>)`
            : ""
        }</div>
      </div>
      </a>
      </li>`;
      });
      let out = document.querySelector("#searchallfriendsres") || null;
      if (out) {
        out.innerHTML = output;
      }
      let view = document.querySelectorAll(".viewfriend") || null;
      if (view) {
        view.forEach(v => {
          v.addEventListener("click", () => {
            let id = v.id.substring(6);
            localStorage.setItem("temp_friend_id", id);
            location.href = "../../../resources/view/single_user.php";
          });
        });
      }
    })
    .catch(err => {
      throw err;
    });
};

searchFriends();
