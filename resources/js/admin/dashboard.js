dashBoard = () => {
  let dash = document.querySelectorAll(".dashboard") || null;
  axios
    .get("../../../controllers/DashBoardController.php?function=1")
    .then(res => {
      let keys = Object.keys(res.data);
      if (dash) {
        keys.forEach(k => {
          dash.forEach(d => {
            if (d.id == k) {
              d.innerHTML = res.data[k];
            }
          });
        });
      }
    })
    .catch(err => {
      throw err;
    });
};
dashBoard();
setInterval(() => dashBoard(), 60000);
