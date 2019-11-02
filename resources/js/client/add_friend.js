var Searchfriend = document.querySelector("#Searchfriend") || null;
var res = document.querySelector("#searchrescount") || null;
if (Searchfriend) {
  setTitle("Search Friend");
  Searchfriend.addEventListener("keyup", () => {
    friendSearch(Searchfriend.value, res);
  });
}

friendSearch = (Search = "all", sres = 0) => {
  let fd = new FormData();
  fd.append("search", Search);
  axios
    .post("../../../controllers/FriendController.php?function=1", fd)
    .then(res => {
      let output = "";
      sres.innerHTML =
        Search == "all" || Search.length < 1 ? 0 : res.data.length;
      let newarray = res.data.filter(
        s => s.id != localStorage.getItem("user_id")
      );
      newarray.forEach(s => {
        let online =
          s.is_active == 1
            ? '<i class="fas fa-circle text-success"></i>'
            : '<i class="fas fa-circle  text-danger"></i>';
        output += `
        <li class="list-group-item">
        <div class="row user_add" id="user${s.id}" style="cursor:pointer" href>
        <div class="col-1 text-center">
        ${online}
        </div>
        <div class="col-3 text-center">
        ${s.firstname}
        </div>
        <div class="col-3 text-center">
        ${s.lastname}
        </div>
        <div class="col-5 text-center">
        ${s.email}
        </div>
        </div>
        </li>
        `;
      });
      document.querySelector("#searchres").innerHTML = output;
      document.querySelectorAll(".user_add").forEach(u => {
        u.addEventListener("click", () => {
          let id = u.id.substring(4);
          localStorage.setItem("temp_friend_id", id);
          location.href = "../../../resources/view/single_user.php";
        });
      });
    })
    .catch(err => {
      throw err;
    });
};

if (Searchfriend) {
  friendSearch();
}

if (document.querySelector("#singleuserpage")) {
  setTimeout(() => {
    if (localStorage.getItem("temp_friend_id")) {
      let id = localStorage.getItem("temp_friend_id");
      // console.log("friend_id:", id);
      getSingleUser(id);
    }
  }, 300);
}

getSingleUser = id => {
  let fd = new FormData();
  let output = "";
  fd.append("id", id);
  axios
    .post(`../../../controllers/FriendController.php?function=2`, fd)
    .then(res => {
      // console.log(res.data);
      let friendoutput = "";
      let postoutput = "";
      let is_active =
        res.data.is_active == 1
          ? '<i class="fas fa-circle text-success"></i>'
          : '<i class="fas fa-circle  text-danger"></i>';
      let is_follow =
        res.data.friend == 1
          ? `<a class="btn btn-primary text-white follow" href="#!" id="follow${res.data.id}">UnFollow</a>`
          : `<a class="btn btn-outline-primary text-white follow" href="#!" id="follow${res.data.id}">Follow</a>`;
      output += ` <div class="card testimonial-card">
      <div class="card-up  light-blue accent-2"></div>
      <div class="avatar mx-auto white">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/img%20%2810%29.jpg" class="rounded" alt="woman avatar">
      </div>
      <div class="card-body">
          <!-- Name -->
          <h4 class="card-title">${is_active}&nbsp;${res.data.firstname}&nbsp;${res.data.lastname}</h4>
          <h6 class="card-title">${res.data.email}</h6>
          <hr>
          <!-- Quotation -->
         <div class="row">
         <div class="col-6 text-center">
          <span class="font-weight-bold">Posts</span> :<span class="badge badge-primary">${res.data.posts.length}</span>
         </div>
         <div class="col-6 text-center">
         <a data-toggle="modal" data-target="#viewallfriends" class="font-weight-bold">Friends</a>
         :<span class="badge badge-primary">${res.data.friends.length}</span>
        </div>
        <div class="col-12 text-center mt-2">
          ${is_follow}
        </div>
         </div>
      </div>

  </div>`;

      res.data.friends.forEach(f => {
        let myp =
          Number(f.id) == Number(res.data.logged_user_id)
            ? "../../../resources/view/profile.php"
            : "#!";
        let is_me =
          Number(f.id) == Number(res.data.logged_user_id)
            ? "You"
            : `${f.firstname} ${f.lastname}`;
        let online =
          f.is_active == 1
            ? '<i class="fas fa-circle text-success"></i>'
            : '<i class="fas fa-circle  text-danger"></i>';

        friendoutput += `
        <li class="list-group-item">
        <div class="row"  style="cursor:pointer" href="#!">
        <div class="col-2 text-center mt-2">
        ${online}
        </div>
        <div class="col-6
         text-center mt-2">
       ${is_me}
        </div>
        <div class="col-4 text-center">
          <a class="btn btn-sm btn-outline-primary viewfriend" id="vnf${f.id}" href="${myp}">View account</a>
        </div>
        </div>
        </li>`;
      });

      res.data.posts.forEach(p => {
        let comouput = "";
        let liked =
          p.likes.filter(l => l.user_id == res.data.logged_user_id).length > 0
            ? "danger"
            : "white";

        p.comments.forEach(c => {
          let is_active = c.is_active == 1 ? "text-success" : "text-danger";
          let me =
            Number(c.comment.user_id) === Number(res.data.logged_user_id)
              ? "You"
              : c.firstname;
          let is_mine =
            c.comment.user_id == res.data.logged_user_id
              ? "display:block"
              : "display:none";
          comouput += `
          <div class="col-md-12">
          <div class="row">
          <div class="col-md-2 text-left font-weight-bold">
          <a href="#!" class="text-dark viewperson" title="View ${me}'s profile." data="" id="viewperson${c.comment.user_id}" data="${c.comment.user_id}">
          <span class="${is_active}">
          <i class="fas fa-circle"></i>
          </span>
          ${me}</a>
          </div>
          <div class="col-md-8 text-left">${c.comment.comment}</div>
          <div class="col-md-2 text-center" style="${is_mine}">
          <a href="#!"  class="text-danger delusercomment" id="deleteusercomment${c.comment.id}" data="${c.comment.id}">
          <i class="fa fa-trash"></i>
          </a>
          </div>
          </div>
          <hr>
          </div>`;
        });

        postoutput += `
        <div class="col-md-10 offset-md-1 mb-5 ">
        <div class="card">
        <img class="card-img-top" src="../../../storage/postImg/${
          p.img
        }" alt="Card image cap" style="height:200px">
        <div class="card-body">
        <h4 class="card-title text-center"><a>${p.title}</a></h4>
        <p class="card-text text-center">${p.body}</p>
        <div class="row">
            <div class="col-6 text-center">
               <button href="#!" class="btn btn-outline-${liked} likeuserpost" type="button" title="LIKE POST" id="likeuserpost${
          p.id
        }">
                <span class="text-danger">
                   <i class="fas fa-heart"></i>
                </span>
                <span class="text-danger">${p.likes.length || 0}</span>
            </button>
            </div>
            <div class="col-6 text-center">
            <a class="btn btn-outline-danger reportpost" id="reportpost${
              p.id
            }">Report</a>
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
                <div class="col-12">
                <form id="addcommentform">
                <div class="md-form">
                <input type="text" class="form-control" placeholder="Add Comment" id="addcomment" data="${
                  p.id
                }"/>
                </div>
                </form>
                </div>
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
      });

      let addfriendoutput = document.querySelector("#addfriendssearch") || null;
      if (addfriendoutput) {
        addfriendoutput.innerHTML = friendoutput;
      }
      friendoutput = "";
      document.querySelector("#friendusercard").innerHTML = output;
      let follow = document.querySelector(".follow") || null;
      if (follow) {
        follow.addEventListener("click", () => {
          let id = follow.id.substring(6);
          followUser(id);
        });
      }
      let followfriend = document.querySelectorAll(".viewfriend") || null;
      if (followfriend) {
        followfriend.forEach(d => {
          d.addEventListener("click", () => {
            let id = d.id.substring(3);
            localStorage.setItem("temp_friend_id", id);
            location.href = "../../../resources/view/single_user.php";
          });
        });
      }
      let userpostoutput = document.querySelector("#userpostoutput") || null;
      if (userpostoutput) {
        userpostoutput.innerHTML = postoutput;
      }

      let likepost = document.querySelectorAll(".likeuserpost") || null;
      if (likepost) {
        likepost.forEach(l => {
          l.addEventListener("click", () => {
            let post_id = l.id.substring(12);
            likeUserPost(post_id);
          });
        });
      }

      let addcommentform = document.querySelector("#addcommentform") || null;
      if (addcommentform) {
        addcommentform.addEventListener("submit", e => {
          e.preventDefault();
          let comment = document.querySelector("#addcomment").value || null;
          let id = $("#addcomment").attr("data");
          AddComment(comment, id);
        });
      }

      let delcomment = document.querySelectorAll(".delusercomment") || null;
      if (delcomment) {
        delcomment.forEach(d => {
          d.addEventListener("click", () => {
            let id = $(`#${d.id}`).attr("data");
            deleteUserComment(id);
          });
        });
      }

      let viewperson = document.querySelectorAll(".viewperson") || null;
      if (viewperson) {
        viewperson.forEach(v => {
          v.addEventListener("click", () => {
            let id = v.id.substring(10);
            localStorage.setItem("temp_friend_id", id);
            location.href = "../../../resources/view/single_user.php";
          });
        });
      }

      let reportpost = document.querySelectorAll(".reportpost") || null;
      if (reportpost) {
        reportpost.forEach(r => {
          r.addEventListener("click", () => {
            let id = r.id.substring(10);
            reportPost(id);
          });
        });
      }
    })
    .catch(err => {
      throw err;
    });
};

followUser = id => {
  let fd = new FormData();
  fd.append("id", id);
  axios
    .post("../../../controllers/FriendController.php?function=3", fd)
    .then(res => {
      getSingleUser(localStorage.getItem("temp_friend_id"));
    })
    .catch(err => {
      throw err;
    });
};

likeUserPost = post_id => {
  let fd = new FormData();
  fd.append("post_id", post_id);
  axios
    .post("../../../controllers/PostController.php?function=3", fd)
    .then(res => {
      getSingleUser(localStorage.getItem("temp_friend_id"));
    })
    .catch(err => {
      throw err;
    });
};

AddComment = (comment, post_id) => {
  let fd = new FormData();
  if (comment.length > 0) {
    fd.append("comment", comment);
    fd.append("post_id", post_id);
    axios
      .post("../../../controllers/PostController.php?function=6", fd)
      .then(res => {
        getSingleUser(localStorage.getItem("temp_friend_id"));
        iziToast.success({
          message: "Comment added.",
          position: "topCenter"
        });
      })
      .catch(err => {
        throw err;
      });
  }
};

deleteUserComment = id => {
  let fd = new FormData();
  fd.append("id", id);
  axios
    .post("../../../controllers/PostController.php?function=4", fd)
    .then(res => {
      getSingleUser(localStorage.getItem("temp_friend_id"));
      iziToast.error({
        message: "Comment deleted.",
        position: "topCenter"
      });
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
    .then(res => {
      iziToast.error({
        message: "Post reported.",
        position: "topCenter"
      });
    })
    .catch(err => {
      throw err;
    });
};
