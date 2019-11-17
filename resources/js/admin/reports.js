getReports = async () => {
  try {
    let res = await axios.get(
      "../../../controllers/adminPostController.php?function=1"
    );
    console.log(res.data);
  } catch (err) {
    console.log(err);
  }
};

getReports();
