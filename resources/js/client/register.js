var signup = document.querySelector("#signup") || null;
if (signup) {
  setTitle("Register");
  signup.addEventListener("submit", e => {
    e.preventDefault();
    signUp();
  });
}

signUp = () => {
  let fname = $("#firstname").val();
  let lname = $("#lastname").val();
  let email = $("#suemail").val();
  let password = $("#supassword").val();
  let conpassword = $("#conpassword").val();
  let errors = [];
  let output = "";
  let registerloader = $("#registerloader") || null;
  registerloader.attr("style", "display:block");
  let signupfailed = $("#signupfailed") || null;
  let fd = new FormData();
  if (fname.length < 3) {
    errors.push({
      Error: "First name is too short it should be 3 characters or more."
    });
  } else if (lname.length < 3) {
    errors.push({
      Error: "Last name is too short it should be 3 characters or more."
    });
  } else if (!validateEmail(email)) {
    errors.push({
      Error: "Email is invalid."
    });
  } else if (password.length < 6) {
    errors.push({
      Error: "Password is too short it must be 6 characters or more."
    });
  } else if (conpassword.length < 6) {
    errors.push({
      Error: "Confirm password is too short it must be 6 characters or more."
    });
  } else if (password != conpassword) {
    errors.push({
      Error: "Password does not match the confirm password field."
    });
  }
  if (errors.length > 0) {
    signupfailed.attr("style", "display:block");
    setTimeout(() => {
      registerloader.attr("style", "display:none");
    }, 500);
    errors.forEach(e => {
      output += e.Error;
    });
    document.querySelector("#signuperrors").innerHTML = output;
  } else {
    fd.append("fname", fname);
    fd.append("lname", lname);
    fd.append("email", email);
    fd.append("password", password);
    signupfailed.attr("style", "display:none");
    axios
      .post("../../../controllers/RegisterController.php", fd)
      .then(res => {
        console.log(res.data);
        let status = res.data.register;
        let error = res.data;
        if (status == 1) {
          setTimeout(() => {
            location.href = "../../../resources/view/login.php";
            registerloader.attr("style", "display:none");
          }, 500);
        }
        if (error.register == 0) {
          setTimeout(() => {
            registerloader.attr("style", "display:none");
          }, 500);
          signupfailed.attr("style", "display:block");
          document.querySelector("#signuperrors").innerHTML = error.Error;
        }
      })
      .catch(err => {
        throw err;
      });
  }
};
