var lgForm = document.querySelector("#admin-login") || null;
if (lgForm) {
  lgForm.addEventListener("submit", e => {
    e.preventDefault();
    AdminLogin();
  });
}

AdminLogin = () => {
  let fields = document.querySelectorAll(".admin") || null;
  let fd = new FormData();
  let pass = false;
  fields.forEach(f => {
    if (f.value == "") {
      pass = false;
      iziToast.error({
        position: "topCenter",
        message: `Field ${f.name} is invalid.`
      });
    } else {
      fd.append(f.name, f.value);
      pass = true;
    }
  });
  if (pass) {
    axios
      .post("../../../controllers/adminLoginController.php?function=1", fd)
      .then(res => {
        if (Number(res.data.status) == 403) {
          iziToast.error({
            message: "Incorrect credentials!",
            position: "topCenter"
          });
        } else {
          location.href = "../../../resources/view/admin/index.php";
        }
      })
      .catch(err => {
        throw err;
      });
  }
};
