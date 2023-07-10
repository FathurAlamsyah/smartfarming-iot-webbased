<?php
     include 'connect.php';

     date_default_timezone_set('Asia/Singapore');

     $tanggal = date("y-m-d");
     $waktu = date("H:i:s");

     $suhu = $kelembaban = "";
     if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $suhu = test_input($_POST["suhu"]);
          $kelembaban = test_input($_POST["kelembaban"]);
          $ketinggian = test_input($_POST["tinggian"]);

          $sql = "INSERT INTO sensor (tanggal,waktu,suhu,kelembaban,ketinggian) VALUES ('".$tanggal."','".$waktu."','".$suhu."','".$kelembaban."','".$ketinggian."')";

          if($con->query($sql) === TRUE){echo "NewLine";}
          else{echo "Error: ".$sql."<br>".$con->error;}
     }
     else{
          echo "Tidak Terpost";
     }

     function test_input($data){
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          return $data;
     }
?>