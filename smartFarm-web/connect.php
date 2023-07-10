<?php
     $con = mysqli_connect("localhost","root","","cabe");

     if (mysqli_connect_errno()) {
          echo "GAGAL : ".mysqli_connect_error();
     }
?>