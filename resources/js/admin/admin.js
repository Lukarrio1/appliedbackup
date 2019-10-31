getAdmin = () => {
  axios("../../../controllers/admin/adminController.php?function=1")
    .then(res => {
      console.log(res);
    })
    .catch(err => {
      console.log(err);
    });
};

getAdmin();
