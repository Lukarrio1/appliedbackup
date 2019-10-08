var createpost = document.querySelector("#createpost") || null;

if (createpost) {
  createpost.addEventListener("submit", e => {
    e.preventDefault();
    createPost();
  });
}
var postimgin = document.querySelector("#postimgin") || null;
if (postimgin) {
  postimgin.addEventListener("change", e => {
    $("#postimgout").val(e.target.files[0].name);
    TemPic(e.target, "tempportfolioimage");
  });
}

createPost = () => {
  let title = $("#posttitle").val();
  let body = $("#postbody").val();
  let fd = new FormData();
  if (title.length > 3 && body.length > 3) {
    fd.append("title", title);
    fd.append("body", body);
    fd.append("img", state.img.files[0]);
    axios
      .post("../../../controllers/PostController.php?function=1", fd)
      .then(res => {
        console.log(res.data);
        $("#posttitle").val("");
        $("#postbody").val("");
        $("#postimgout").val("");
        postimgin.value = "";
        getPosts();
        $("#tempportfolioimage").attr("src", "");
        iziToast.success({
          message: "Post created successfully.",
          position: "topCenter"
        });
      })
      .catch(err => {
        throw err;
      });
  }
};

getPosts = () => {
  axios
    .get("../../../controllers/PostController.php?function=2")
    .then(res => {
      let output = "";
      res.data.forEach(p => {
        console.log(p.user.id);
        let comouput = "";
        p.comments.forEach(c => {
          let is_active = c.is_active == 1 ? "text-success" : "text-danger";
          let me =
            Number(c.comment.user_id) === Number(p.user.id)
              ? "You"
              : c.firstname;
          comouput += `
          <div class="col-md-12">
          <div class="row">
          <div class="col-md-2 text-left font-weight-bold">
          <a href="#!" class="text-dark" title="View ${me}'s profile.">
          <span class="${is_active}">
          <i class="fas fa-circle"></i>
          </span>
          ${me}</a>
          </div>
          <div class="col-md-8 text-left">${c.comment.comment}</div>
          <div class="col-md-2 text-center ">
          <a href="#!" id="delcomment${c.comment.id}" class="text-danger delcomment">
          <i class="fa fa-trash"></i>
          </a>
          </div>
          </div>
          <hr>
          </div>
          `;
        });
        let user_likes =
          p.likes.length > 0
            ? p.likes.filter(l => Number(l.user_id) === Number(p.user.id))
                .length
            : 0;
        let liked = user_likes > 0 ? "danger" : "white";

        output += `
        <div class="col-md-10 offset-md-1 mb-5">
        <div class="card">
        <img class="card-img-top" src="../../../storage/postImg/${
          p.img
        }" alt="Card image cap" style="height:200px">
        <div class="card-body">
        <h4 class="card-title text-center"><a>${p.title}</a></h4>
        <p class="card-text text-center">${p.body}</p>
        <div class="row">
            <div class="col-4 text-center">
               <button href="#!" class="btn btn-outline-${liked} likepost" type="button" title="LIKE POST" id="likepost${
          p.id
        }">
                <span class="text-danger">
                   <i class="fas fa-heart"></i>
                </span>
                <span class="text-danger">${p.likes.length || 0}</span>
            </button>
            </div>
            <div class="col-4 text-center">
                <a class="btn btn-outline-warning"><i class="fa fa-edit"></i></a>
            </div>
            <div class="col-4 text-center">
            <a class="btn btn-outline-danger deletepost" id="deletepost${
              p.id
            }"><i class="fa fa-trash"></i></a>
        </div>
        </div>
    </div>
        <div class="card-footer text-center bg-white">
            <div class="row">
                 <div class="col-12 text-center">
                    <a class="btn btn-primary" data-toggle="collapse" href="#comments${
                      p.id
                    }" aria-expanded="false" aria-controls="collapseExample">
                      <span>${p.comments.length} </span></span>COMMENTS
                    </a>
                 </div>
                 <div class="col-md-12">
                 <div class="collapse" id="comments${p.id}">
                <div class="mt-3">
                  <div class="row">
                      ${comouput}
                  </div>
                </div>
                </div>
              </div>
            </div>
        </div>
        </div>
</div>`;
        comouput = "";
        user_likes = 0;
      });
      let allposts = document.querySelector("#allposts") || null;
      if (allposts) {
        allposts.innerHTML = output;
      }
      let likepost = document.querySelectorAll(".likepost") || null;
      let delcomment = document.querySelectorAll(".delcomment") || null;
      if (likepost) {
        likepost.forEach(l => {
          l.addEventListener("click", () => {
            let post_id = l.id.substring(8);
            likePost(post_id);
          });
        });
      }
      if (delcomment) {
        delcomment.forEach(d => {
          d.addEventListener("click", () => {
            let id = d.id.substring(10);
            deleteComment(id);
          });
        });
      }
      let deletepost = document.querySelectorAll(".deletepost") || null;
      if (deletepost) {
        deletepost.forEach(d => {
          d.addEventListener("click", () => {
            let id = d.id.substring(10);
            deletePost(id);
          });
        });
      }
    })
    .catch(err => {
      throw err;
    });
};

likePost = post_id => {
  let fd = new FormData();
  fd.append("post_id", post_id);
  axios
    .post("../../../controllers/PostController.php?function=3", fd)
    .then(res => {
      console.log(res.data);
      getPosts();
    })
    .catch(err => {
      throw err;
    });
};

deleteComment = id => {
  let fd = new FormData();
  fd.append("id", id);
  axios
    .post("../../../controllers/PostController.php?function=4", fd)
    .then(res => {
      getPosts();
    })
    .catch(err => {
      throw err;
    });
};

deletePost = id => {
  let fd = new FormData();
  fd.append("id", id);
  axios
    .post("../../../controllers/PostController.php?function=5", fd)
    .then(res => {
      getPosts();
      iziToast.success({
        message: "Post successfully deleted!",
        position: "topCenter"
      });
    })
    .catch(err => {
      throw err;
    });
};

getPosts();
