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
var allUsers = document.querySelector("#allUsers");

UserSearch = async (search, lim = 100) => {
  let fd = new FormData();
  fd.append("search", search);
  try {
    let data = await axios.post(
      "../../../controllers/adminUserController.php?function=1",
      fd
    );
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
        <a href="#!" class=" text-warning" title="Edit ${p.firstName}"><i class="fas fa-edit"></i></a>
        </div>
        <div class="col-6 text-left">
        <a href="#!" class="deletedUser text-danger" id="user${p.id}" title="Delete ${p.firstName}"><i class="fas fa-trash"></i></a>
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
  } catch (err) {
    console.log(err);
  }
};

UserSearch("all");

DeleteUser = async id => {
  let fd = new FormData();
  fd.append("id", id);
  try {
    let res = await axios.post(
      "../../../controllers/adminUserController.php?function=2",
      fd
    );
    console.log(res.data);
  } catch (err) {
    throw err;
  }
};
