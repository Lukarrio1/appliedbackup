var loginform = document.querySelector("#loginForm") || null;
var ll = $("#loginloader");
ll.attr("style", "display:none");
if (loginform) {
  setTitle("Login");
  loginform.addEventListener("submit", e => {
    e.preventDefault();
    Login();
  });
}

Login = () => {
  let email = $("#email").val();
  let password = $("#password").val();
  let error = $("#loginfailed");
  ll.attr("style", "display");
  let fd = new FormData();
  if (!validateEmail(email) || password.length < 6) {
    error.attr("style", "");
    setTimeout(() => {
      ll.attr("style", "display:none");
    }, 500);
  } else {
    fd.append("email", email);
    fd.append("password", password);
    axios
      .post("../../../controllers/LoginController.php?function=login", fd)
      .then(res => {
        let status = res.data.login;
        if (status == false) {
          error.attr("style", "");
          setTimeout(() => {
            ll.attr("style", "display:none");
          }, 500);
        } else {
          error.attr("style", "display:none");
          location.href = "../../../resources/view/index.php";
        }
      })
      .catch(err => {
        throw err;
      });
  }
};
