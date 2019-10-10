if (document.querySelector("#single_post")) {
  setTimeout(() => {
    if (localStorage.getItem("post_id")) {
      let id = localStorage.getItem("post_id");
      getSinglePost(id);
    }
  }, 300);
}

getSinglePost = id => {
  let fd = new FormData();
  fd.append("post_id", id);
  axios
    .post("../../../controllers/PostController.php?function=9", fd)
    .then(res => {
      console.log(res.data);
    })
    .catch(err => {
      console.log(err);
    });
};
