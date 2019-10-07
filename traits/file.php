<?php
trait File
{
    function storeImage($location)
    {
        $photo = $_FILES['img'];
        $photoname = $_FILES['img']['name'];
        $phototmpname = $_FILES['img']['tmp_name'];
        $photosize = $_FILES['img']['size'];
        $photoerror = $_FILES['img']['error'];
        $phototype = $_FILES['img']['type'];
        $photoext = explode('.', $photoname);
        $photoactualext = strtolower(end($photoext));
        $allowed = array('jpg', 'jpeg', 'png');
        if (in_array($photoactualext, $allowed)) {
            $img = uniqid('' . true) . "." . $photoactualext;
            $photostorage = "../storage/$location/$img";
            if (move_uploaded_file($phototmpname, $photostorage)) {
                return $img;
            }
        } else {
            return 0;
        }
    }
}
