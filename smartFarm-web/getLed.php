<?php
     include 'connect.php';

     $query = mysqli_query($con,"SELECT * FROM kontrol");

     while ($a = mysqli_fetch_assoc($query)) {
          $rows[] = $a;
     }

     //echo '<pre>'; print_r($rows); echo '</pre>';	
     echo json_encode($rows);
?>