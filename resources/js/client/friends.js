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
    .post("../../../controllers/FriendController.php?function=1", fd)
    .then(res => {
      let output = "";
      if (allfriendsCount) {
        allfriendsCount.innerHTML = res.data.length || 0;
      }
      res.data.forEach(f => {
        output += `
     <li class="list-group-item">
          <div class="row">
          <div class="col-md-4 text-center">${f.firstname}</div>
          <div class="col-md-4 text-center">${f.lastname}</div>
          <div class="col-md-4 text-center">${f.email}</div>
        </div></li>`;
      });
      let out = document.querySelector("#searchallfriendsres") || null;
      if (out) {
        out.innerHTML = output;
      }
    })
    .catch(err => {
      console.log(err);
    });
};

searchFriends();
