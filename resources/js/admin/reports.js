var post_search = document.querySelector("#post_search") || null;
var allReportsCount = document.querySelector("#allReportsCount") || null;
var limitReportsAll = document.querySelector("#limitReportsAll") || null;
var limitReports = document.querySelector("#limitReports") || null;
var allReportsDisplay = document.querySelector("#allReportsDisplay") || null;

if (post_search) {
  post_search.addEventListener("keyup", () => {
    let search = post_search.value;
    searchReports(search, limitReports.value);
  });
}

if (limitReports) {
  limitReports.addEventListener("change", () => {
    searchReports(post_search.value, limitReports.value);
  });
}

searchReports = async (search = "all", limit = 0) => {
  let fd = new FormData();
  let output = "";
  fd.append("search", search);
  try {
    let res = await axios.post(
      "../../../controllers/adminPostController.php?function=1",
      fd
    );
    let res_limited = res.data.slice(0, limit >= 1 ? limit : res.data.length);
    if (allReportsCount && limitReportsAll) {
      allReportsCount.innerHTML = res_limited.length;
      limitReportsAll.value = res.data.length;
      limitReportsAll.innerHTML = "All reports";
    }
    res_limited.forEach((r, i) => {
      output += `<tr>
      <th scope="row">${i}</th>
      <td>${r.owner.firstName}</td>
      <td>${r.owner.lastName}</td>
      <td>${r.title}</td>
      <td>${r.body}</td>
      <td>${r.report.user_id}</td>
      <td>
      <div class="row">
      <div class="col-sm-6">
      <a class="text-danger warnUser" href="#!" title="Warn ${r.owner.firstName}" id="warn${r.id}">
      <i class="far fa-envelope"></i>
      </a>
      </div>
      <div class="col-sm-6">
      <a class="text-danger deleteReport" href="#!" title="Delete report" id="deleteReport${r.report.id}">
      <i class="fas fa-trash"></i>
      </a>
      </div>
      </div>
      </td>
           </tr>`;
    });
    if (allReportsDisplay) {
      allReportsDisplay.innerHTML = output;
    }
    let warnUser = document.querySelectorAll(".warnUser") || null;
    let deleteReport = document.querySelectorAll(".deleteReport") || null;
    if (warnUser) {
      warnUser.forEach(w => {
        w.addEventListener("click", () => {
          let id = w.id.substring(4);
          WarnUser(id);
        });
      });
    }
    if (deleteReport) {
      deleteReport.forEach(d => {
        d.addEventListener("click", () => {
          let id = d.id.substring(12);
          DeleteReport(id);
        });
      });
    }
  } catch (err) {
    console.log(err);
  }
};

searchReports();

WarnUser = async id => {
  let fd = new FormData();
  fd.append("id", id);
  try {
    let res = await axios.post(
      "../../../controllers/adminPostController.php?function=2",
      fd
    );
    searchReports(post_search.value, limitReports.value);
    iziToast.success({
      message: "Warned user successfully",
      position: "topCenter"
    });
  } catch (err) {
    console.log(err);
  }
};

DeleteReport = async id => {
  let fd = new FormData();
  fd.append("id", id);
  try {
    let res = await axios.post(
      "../../../controllers/adminPostController.php?function=3",
      fd
    );
    searchReports(post_search.value, limitReports.value);
    console.log(res.data);
  } catch (err) {
    console.log(err);
  }
};
