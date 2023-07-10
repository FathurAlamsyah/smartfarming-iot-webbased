<script>
     alert("KONDISI RELAY TELAH BERUBAH");
</script>
<?php
     include 'connect.php';

     $id = $_GET['id'];

     $query = mysqli_query($con,"SELECT * FROM kontrol WHERE id='$id'");
     $val = mysqli_fetch_assoc($query);
     
     if ($val['nilai']==0) {
          mysqli_query($con,"UPDATE kontrol SET nilai='1' WHERE id='$id'");
     }
     else{
          mysqli_query($con,"UPDATE kontrol SET nilai='0' WHERE id='$id'");
     }

     header("location:index.php");
?>
