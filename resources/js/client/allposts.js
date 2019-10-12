getAllPosts = () => {
  axios
    .get("../../../controllers/PostController.php?function=8")
    .then(res => {
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
              <a href="#" class="btn btn-primary">View Post</a>
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
      });
    })
    .catch(err => {
      throw err;
    });
};
getAllPosts();
