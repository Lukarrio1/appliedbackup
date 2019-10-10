getLoggedUser = () => {
  axios
    .get("../../../controllers/UserController.php?func=1")
    .then(res => {
      localStorage.setItem("user_id", res.data.id);
      $("#username").html(res.data.firstname);
      $("#firstname").val(res.data.firstname);
      $("#lastname").val(res.data.lastname);
      $("#email").val(res.data.email);
      $("#usercardfname").html(res.data.firstname);
      $("#usercardlname").html(res.data.lastname);
      $("#usercardemail").html(res.data.email);
      // $("#numberofpost").html(res.data.post_count);
      $("#numberoffriends").html(res.data.friend_count);
    })
    .catch(err => {
      throw err;
    });
};

getLoggedUser();

let upui = document.querySelector("#updateuserinformation") || null;

if (upui) {
  setTitle("Account");
  upui.addEventListener("submit", e => {
    e.preventDefault();
    updateUserInfo();
  });
}

updateUserInfo = () => {
  let errors = $("#errorupdateusers");
  errors.removeClass("alert-success");
  errors.addClass("alert-danger");
  let firstname = $("#firstname").val();
  let lastname = $("#lastname").val();
  let fd = new FormData();
  let email = $("#email").val();
  if (!validateEmail(email)) {
    errors.attr("style", "display:block");
    errors.html("Error, Email is invalid.");
  } else if (firstname.length < 3) {
    errors.attr("style", "display:block");
    errors.html(
      "Error, First name is too short minimum of 3 characters is required. "
    );
  } else if (lastname.length < 3) {
    errors.attr("style", "display:block");
    errors.html(
      "Error, Last name is too short minimum of 3 characters is required. "
    );
  } else {
    fd.append("firstname", firstname);
    fd.append("lastname", lastname);
    fd.append("email", email);

    axios
      .post("../../../controllers/UserController.php?func=2", fd)
      .then(res => {
        let error = res.data.error;
        if (error) {
          errors.attr("style", "display:block");
          errors.html("Error, Email is already in use.  ");
        } else {
          errors.attr("style", "display:block");
          errors.removeClass("alert-danger");
          errors.addClass("alert-success");
          errors.html("Account updated successfully.");
          getLoggedUser();
          setTimeout(() => {
            errors.attr("style", "display:none");
          }, 3000);
        }
      })
      .catch(err => {
        throw err;
      });
  }
};

getNotifications = () => {
  axios
    .get("../../../controllers/UserController.php?func=5")
    .then(res => {
      // setInterval(() => notificationTimer(res.data.length), 10000);
      let output = "";
      res.data.forEach(n => {
        output += `<a class="dropdown-item ${n.class}" href="#!" id="notify${n.user_id}" data="${n.id}" data-ref_id="${n.ref_id}"><i class="${n.icon}"></i> ${n.notify}</a>`;
      });
      let display = document.querySelector("#notificationdisplay");
      if (display) {
        display.innerHTML = output;
      }
      let newfollower = document.querySelectorAll(".newfollower") || null;
      if (newfollower) {
        newfollower.forEach(n => {
          n.addEventListener("click", () => {
            id = n.id.substring(6);
            localStorage.setItem("temp_friend_id", id);
            let nt_id = $(`#${n.id}`).attr("data");
            removeNotify(nt_id);
            location.href = "../../../resources/view/single_user.php";
          });
        });
      }

      let newpost = document.querySelectorAll(".newpost") || null;
      if (newpost) {
        newpost.forEach(n => {
          n.addEventListener("click", () => {
            let nt_id = $(`#${n.id}`).attr("data");
            removeNotify(nt_id);
            location.href = "../../../resources/view/index.php";
          });
        });
      }

      let newlike = document.querySelectorAll(".newlike") || null;
      if (newlike) {
        newlike.forEach(n => {
          n.addEventListener("click", () => {
            let ref_id = $(`#${n.id}`).attr("data-ref_id");
            let id = $(`#${n.id}`).attr("data");
            localStorage.setItem("post_id", ref_id);
            removeNotify(id);
            location.href = "../../../resources/view/single_post.php";
          });
        });
      }

      let ncout = document.querySelector("#notificationcount") || null;
      if (ncout) {
        ncout.innerHTML = res.data.length;
      }
    })
    .catch(err => {
      throw err;
    });
};

getNotifications();

removeNotify = id => {
  let fd = new FormData();
  fd.append("id", id);
  axios
    .post("../../../controllers/UserController.php?func=6", fd)
    .then(res => getNotifications())
    .catch(err => {
      throw err;
    });
};

notificationTimer = id => {
  axios
    .get("../../../controllers/UserController.php?func=5")
    .then(result => (result.data.length != id ? getNotifications() : null))
    .catch(err => {
      throw err;
    });
};
