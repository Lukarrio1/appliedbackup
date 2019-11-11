var admin_logout = document.querySelector("#admin-logout") || null;
if (admin_logout)
  admin_logout.addEventListener("click", () => {
    adminLogout();
  });

adminLogout = async () => {
  try {
    let res = await axios.post(
      "../../../controllers/adminLoginController.php?function=2"
    );
    location.href = "../../../resources/view/admin/login.php";
  } catch (err) {
    console.log(err);
  }
};

Admin = async () => {
  try {
    let res = await axios.get(
      "../../../controllers/adminController.php?function=1"
    );
    let admin_name = document.querySelector("#admin-name") || null;
    if (admin_name) {
      admin_name.innerHTML = res.data.name;
    }
    let keys = Object.keys(res.data);
    let admin_fields = document.querySelectorAll(".edit-admin") || null;
    keys.forEach(k => {
      admin_fields.forEach(a => {
        if (a.name == k) {
          a.value = res.data[k];
        }
      });
    });
  } catch (err) {
    throw err;
  }
};

Admin();

var editAdmin = document.querySelector("#edit-admin") || null;
if (editAdmin) {
  editAdmin.addEventListener("submit", e => {
    e.preventDefault();
    updateAdmin();
  });
}

updateAdmin = () => {
  let fd = new FormData();
  let fields = document.querySelectorAll(".edit-admin") || null;
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
      .post("../../../controllers/adminController.php?function=2", fd)
      .then(res => {
        if (res.data.is_error == 1) {
          iziToast.error({
            position: "topCenter",
            message: res.data.error
          });
        } else {
          iziToast.success({
            message: "Account Updated Successfully!",
            position: "topCenter"
          });
        }
        Admin();
      })
      .catch(err => {
        console.log(err);
      });
  }
};
