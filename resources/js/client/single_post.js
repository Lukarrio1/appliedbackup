if (document.querySelector("#single_post")) {
  setTimeout(() => {
    if (localStorage.getItem("post_id") != null) {
      let id = localStorage.getItem("post_id");
      getSinglePost(id);
    } else {
      location.href = "../../../resources/view/index.php";
    }
  }, 300);
}

getSinglePost = id => {
  let fd = new FormData();
  fd.append("post_id", id);
  axios
    .post("../../../controllers/PostController.php?function=9", fd)
    .then(res => {
      Comments = comment => {
        let comments = ``;
        comment.forEach(c => {
          let is_active = c.is_active == 1 ? "text-success" : "text-danger";
          let me =
            Number(c.comment.user_id) === Number(res.data.owner.id)
              ? "You"
              : c.firstname;
          let is_mine =
            c.comment.user_id == res.data.owner.id ||
            res.data.owner.id == res.data.post.user_id
              ? "display:block"
              : "display:none";
          comments += `<div class="col-12">
          <div class="row">
          <div class="col-2"><i class="fa fa-circle ${is_active}"></i>${me}</div>
          <div class="col-8">${c.comment.comment}</div>
          <div class="col-2 text-right"><a href="#!" class="text-danger deletecomment" style="${is_mine}" id="deletecomment${c.comment.id}"><i class="fa fa-trash"></i></a></div>
          </div>
          <hr>
          </div>`;
        });
        return comments;
      };

      Likes = likes => {
        let user_likes =
          likes.length > 0
            ? likes.filter(l => Number(l.user_id) == Number(res.data.owner.id))
                .length
            : 0;
        let liked = user_likes > 0 ? "danger" : "white";
        return `<a href="#!" class="btn btn-outline-${liked} likepost"><i class="fas fa-heart text-danger">&nbsp;${likes.length}</i></a>`;
      };

      let output = `<div class="col-md-10 offset-md-1 mt-2 mb-2">
      <div class="card">
        <div
          class="card-header text-center h3 bg-success text-white font-weight-bold"
        >
          VIEW POST
        </div>
        <div class="card-body">
          <div class="row">
            <div class="col-12 text-center">
              <img
                src="../../../storage/postImg/${res.data.post.img}"
                class=" border border-success"
                style="width:70%"
              />
            </div>
            <div class="col-12 text-center font-weight-bold h4 mt-1">${
              res.data.post.title
            }</div>
            <div class="col-12 pl-5">${res.data.post.body}</div>
            <div class="col-12 text-right"><small>
            Author ${res.data.owner.firstname}
            </small>
            </div>
            <div class="col-12 text-center">
              <div class="row">
              <div class="col-6 text-right">
            ${Likes(res.data.likes)}
              </div>
              <div class="col-6 text-left">
              <a href="#!" class="btn btn-outline-danger report" id="reportpost${
                res.data.post.id
              }" data="${res.data.post.id}">REPORT</a>
              </div>
              </div>
            </div>
            <div class="col-12">
            </div>
          </div>
        </div>
        <div class="card-footer bg-white">
         <div class="row">
         <div class="col-12">
         <div class="md-form">
         <form id="acftsp">
         <input type="text" class="form-control" placeholder="Add a comment." id="acfi"/>
         </form>
         </div>
         </div>
         ${Comments(res.data.comment) ||
           "<div class='col-12 text-center'>No Comments</div>"}
         </div>
        </div>
      </div>
    </div>`;

      let page = document.querySelector("#view_single_post") || null;
      if (page) {
        page.innerHTML = output;
      }

      let report = document.querySelectorAll(".report") || null;
      report.forEach(r => {
        r.addEventListener("click", () => {
          let id = r.id.substring(10);
          reportPost(id);
        });
      });

      let acftsp = document.querySelector("#acftsp") || null;
      if (acftsp) {
        acftsp.addEventListener("submit", e => {
          let comment = document.querySelector("#acfi") || null;
          e.preventDefault();
          if (comment.value.length > 0) {
            addComment(comment.value, res.data.post.id);
          }
        });
      }

      let likepost = document.querySelector(".likepost") || null;
      if (likepost) {
        likepost.addEventListener("click", () => {
          likePost(res.data.post.id);
        });
      }

      let delcomment = document.querySelectorAll(".deletecomment") || null;
      if (delcomment) {
        delcomment.forEach(d => {
          d.addEventListener("click", () => {
            let id = d.id.substring(13);
            deleteComment(id);
          });
        });
      }
    })
    .catch(err => {
      throw err;
    });
};

reportPost = id => {
  let fd = new FormData();
  fd.append("id", id);
  axios
    .post("../../../controllers/PostController.php?function=7", fd)
    .then(res => {})
    .catch(err => {
      throw err;
    });
};

addComment = (comment, id) => {
  let fd = new FormData();
  fd.append("comment", comment);
  fd.append("post_id", id);
  axios
    .post("../../../controllers/PostController.php?function=6", fd)
    .then(res => {
      getSinglePost(localStorage.getItem("post_id"));
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
      getSinglePost(localStorage.getItem("post_id"));
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
      getSinglePost(localStorage.getItem("post_id"));
    })
    .catch(err => {
      throw err;
    });
};
