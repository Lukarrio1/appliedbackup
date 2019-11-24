<!-- JQuery -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../../../resources/js/mdb.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.0/axios.js"></script>
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.js"></script>
<script>
    var state = {
        img: null,
    }
    setTitle = (page = "") => {
        if (page) {
            document.querySelector('title').innerHTML = "CARRIUM | " + page
        } else {
            document.querySelector('title').innerHTML = "CARRIUM"
        }
    }

    setTitle();

    validateEmail = email => {
        var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    };

    TemPic = (img, id) => {
        var reader = new FileReader();
        reader.onload = (e) => {
            $(`#${id}`).attr("src", e.target.result);
        };
        if (img.files[0].size < 2000000.0) {
            state.img = img || null;
            reader.readAsDataURL(img.files[0]);
        } else {
            iziToast.error({
                position: "topCenter",
                message: `File ${img.files[0].name} is greater than 2mb. Please choose a smaller files.`
            });
            state.img = null
        }
    };

</script>
<script src="../../../resources/js/client/user.js"></script>
<script src="../../../resources/js/client/add_friend.js"></script>
<script src="../../../resources/js/client/post.js"></script>
<script src="../../../resources/js/client/allposts.js"></script>
<script src="../../../resources/js/client/single_post.js"></script>
<script src="../../../resources/js/client/friends.js"></script>
</body>

</html>
