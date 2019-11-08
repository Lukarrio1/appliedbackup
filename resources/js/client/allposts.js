getAllPosts = () => {
  axios
    .get("../../../controllers/PostController.php?function=8")
    .then(res => {
      console.log(res.data);
      let output = "";
      res.data.forEach(p => {
        output += `<div class="col-md-6 mb-3">
      <div class="card">
        <div class="view overlay">
            <img
            class="card-img-top"
            src="../../../storage/postImg/${p.img}"
            alt="Card image cap"
            />
            <a href="#!">
            <div class="mask rgba-white-slight"></div>
          </a>
      </div>      
        <div class="card-body">
          <h4 class="card-title">${p.title}</h4>
          <p class="card-text">
            ${p.body}
          <div class="col-12 text-right"><a href="#!" class="text-dark"><small><strong>Author ${p.owner.firstname}</strong></small></a></div>
          </p>
         <div class="text-center">
              <a href="#!"  class="btn btn-primary viewpost" id="viewpost${p.id}">View Post</a>
         </div>
      </div>
      </div>
  </div>`;

        let allfollowingsposts =
          document.querySelector("#allfollowingsposts") || null;
        if (allfollowingsposts) {
          allfollowingsposts.innerHTML =
            output || `<div class="col-md-12 mt-5">No Posts</div>`;
        }

        let viewPost = document.querySelectorAll(".viewpost") || null;
        if (viewPost) {
          viewPost.forEach(v => {
            v.addEventListener("click", () => {
              let post_id = v.id.substring(8);
              localStorage.setItem("post_id", post_id);
              location.href = "../../../resources/view/single_post.php";
            });
          });
        }
      });
    })
    .catch(err => {
      throw err;
    });
};
getAllPosts();
