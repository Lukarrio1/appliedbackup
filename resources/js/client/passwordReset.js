var pef = document.querySelector("#passwordEmailForm") || null;
if (pef) {
  pef.addEventListener("submit", e => {
    e.preventDefault();
    emailEnter();
  });
}

var resetpasswordform = document.querySelector("#resetpasswordform") || null;
if (resetpasswordform) {
  resetpasswordform.addEventListener("submit", e => {
    e.preventDefault();
    newPasswordEnter();
  });
}

emailEnter = () => {
  let email = $("#ememail").val();
  let error = $("#errorEnterEmail");
  let fd = new FormData();
  if (!validateEmail(email)) {
    error.attr("style", "display:block");
  } else {
    fd.append("email", email);
    axios
      .post("../../../controllers/UserController.php?func=3", fd)
      .then(res => {
        if (res.data.status == 1) {
          location.href =
            "../../../resources/view/password_resets/enter_rkey.php";
        }
      })
      .catch(err => {
        console.log(err.message);
      });
  }
};

newPasswordEnter = () => {
  let r_key = $("#r_key");
  let password = $("#r_password");
  let conpassword = $("#r_confpassword");
  let error = $("#r_keyerror");
  let fd = new FormData();
  if (
    password.val().length > 6 &&
    password.val() == conpassword.val() &&
    r_key.val().length > 10
  ) {
    fd.append("r_key", r_key.val());
    fd.append("password", password.val());
    axios
      .post("../../../controllers/UserController.php?func=4", fd)
      .then(res => {
        if (res.data.password == 1) {
          location.href = "../../../resources/view/login.php";
        } else {
          error
            .attr("style", "display:block")
            .html(`Error, reset key doesn't match a user!`);
        }
      })
      .catch(err => {
        console.log(err);
      });
  } else {
    error.attr("style", "display:block").html(`Error, invalid data entered!`);
  }
};
