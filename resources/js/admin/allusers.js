var adminSearch = document.querySelector("#admin-search") || null;
if (adminSearch) {
  adminSearch.addEventListener("keyup", () => {
    let data = adminSearch.value.length > 0 ? adminSearch.value : "all";
    UserSearch(data);
  });
}

var limit = document.querySelector("#limit") || null;
if (limit) {
  limit.addEventListener("change", () => {
    let data = adminSearch.value.length > 0 ? adminSearch.value : "all";
    let lim = limit.value;
    UserSearch(data, lim);
  });
}
var userCount = document.querySelector("#allUserCount") || null;
var allUsers = document.querySelector("#allUsers") || null;

UserSearch = async (search, lim) => {
  let fd = new FormData();
  fd.append("search", search);
  try {
    let data = await axios.post(
      "../../../controllers/adminUserController.php?function=1",
      fd
    );
    setInterval(() => UserUpdateInterval(data.data.length), 60000);
    allUsers.value = data.data.length;
    allUsers.innerHTML = "Show All Entries";
    let res = data.data.slice(0, lim);
    let output = "";
    res.forEach((p, i) => {
      let is_active =
        p.is_active == 1
          ? `<span class="text-success"><i class="fas fa-circle"></i> </span>`
          : `<span class="text-danger"><i class="fas fa-circle"></i> </span>`;
      let is_deleted =
        p.is_deleted == 1
          ? `<span class="text-danger"><i class="fas fa-user-times"></i></span>`
          : "";

      output += `<tr>
        <th scope="row" class="text-center">${i}</th>
        <td class="text-center">${is_active}${is_deleted}</td>
        <td>${p.firstName}</td>
        <td>${p.lastName}</td>
        <td>${p.email}</td>
        <td class="text-center"><span class="badge badge-info">${p.post_count}</span></td>
        <td class="text-center"><span class="badge badge-info">${p.friend_count}</span></td>
        <td><div class="row">
        <div class="col-6 text-right">
        <a href="#!" class="text-warning editUserBtn" title="Edit ${p.firstName}" data-toggle="modal" data-target="#userUpdateModal" id="editUser${p.id}">
        <i class="fas fa-edit"></i></a>
        </div>
        <div class="col-6 text-left">
        <a href="#!" class="deletedUser text-danger" id="user${p.id}" title="Delete ${p.firstName}">
        <i class="fas fa-trash"></i>
        </a>
        </div>
        </div></td>
    </tr>`;
    });

    let div = document.querySelector("#allUsersOutput") || null;
    if (div) {
      div.innerHTML = output;
      userCount.innerHTML = res.length;
    }

    let deletedUsers = document.querySelectorAll(".deletedUser") || null;
    if (deletedUsers) {
      deletedUsers.forEach(d => {
        d.addEventListener("click", () => {
          let id = d.id.substring(4);
          DeleteUser(id);
        });
      });
    }

    let editUserBtn = document.querySelectorAll(".editUserBtn") || null;
    if (editUserBtn) {
      editUserBtn.forEach(e => {
        e.addEventListener("click", () => {
          state.user_id = e.id.substring(8);
          PopulateUserForm(state.user_id);
        });
      });
    }
  } catch (err) {
    throw err;
  }
};

UserSearch("all");

DeleteUser = async id => {
  let fd = new FormData();
  fd.append("id", id);
  try {
    await axios.post(
      "../../../controllers/adminUserController.php?function=2",
      fd
    );
    iziToast.error({
      message: "User deleted successfully!",
      position: "topCenter"
    });

    UserSearch(adminSearch.value, limit.value);
  } catch (err) {
    throw err;
  }
};

var editUserForm = document.querySelector("#editUserForm") || null;
if (editUserForm) {
  editUserForm.addEventListener("submit", e => {
    e.preventDefault();
    UpdateUser();
  });
}

var editUsersFields = document.querySelectorAll(".editUser") || null;
var closeModal = $("#closeUserEditModal");

UpdateUser = async () => {
  let fd = new FormData();
  let pass = false;
  editUsersFields.forEach(f => {
    if (f.value == "") {
      iziToast.error({
        message: `Field ${f.name} is invalid`,
        position: "topCenter"
      });
      pass = false;
    } else {
      pass = true;
      fd.append(f.name, f.value);
    }
  });
  if (pass) {
    fd.append("id", state.user_id);
    try {
      await axios.post(
        "../../../controllers/adminUserController.php?function=5",
        fd
      );
      closeModal.click();
      iziToast.success({
        message: "Profile Updated Successfully!",
        position: "topCenter"
      });
      UserSearch(adminSearch.value || "all");
    } catch (err) {
      throw err;
    }
  }
};

PopulateUserForm = async id => {
  let fd = new FormData();
  fd.append("id", id);
  try {
    let res = await axios.post(
      "../../../controllers/adminUserController.php?function=3",
      fd
    );
    let keys = Object.keys(res.data);
    keys.forEach(k => {
      editUsersFields.forEach(e => {
        if (k == e.name) {
          e.value = res.data[k];
        }
      });
    });
    IsEmailAvail(res.data.email);
  } catch (err) {
    throw err;
  }
};

let userEmail = document.querySelector("#editUserEmail") || null;
if (userEmail) {
  userEmail.addEventListener("keyup", () => {
    if (validateEmail(userEmail.value)) {
      IsEmailAvail(userEmail.value);
    }
  });
}

IsEmailAvail = async email => {
  let fd = new FormData();
  fd.append("email", email);
  fd.append("id", state.user_id);
  try {
    let res = await axios.post(
      "../../../controllers/adminUserController.php?function=4",
      fd
    );
    if (res.data.error == 1) {
      iziToast.error({
        message: res.data.status,
        position: "topCenter"
      });
      state.is_error = true;
    }
  } catch (err) {
    throw err;
  }
};

UserUpdateInterval = async length => {
  try {
    let res = await axios.get(
      "../../../controllers/adminUserController.php?function=1"
    );
    res.data.length != length ? UserSearch(adminSearch.value || "all") : "";
  } catch (err) {
    throw err;
  }
};
