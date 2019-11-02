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
  let searchallfriendsres =
    document.querySelector("#searchallfriendsres") || null;
  fd.append("search", search);
  axios
    .post("../../../controllers/FriendController.php?function=1", fd)
    .then(res => {
      allfriendsCount.innerHTML = res.data.length || 0;
      res.data.forEach(f => {
        console.log(f);
      });
    })
    .catch(err => {
      console.log(err);
    });
};
searchFriends();
