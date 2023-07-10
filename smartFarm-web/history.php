<div class="judul">
     <h2>HISTORY</h2>
</div>
<div class="history">
     <table>
          <thead>
               <tr>
                    <td>No.</td>
                    <td>Tanggal</td>
                    <td>waktu</td>
                    <td>Suhu &#176;C</td>
                    <td>Kelembaban</td>
                    <td>Ketinggian Air (cm)</td>
               </tr>
          </thead>
          <tbody>
               <?php
                    include 'connect.php';

                    $no=1;
                    $data = mysqli_query($con,"SELECT * FROM sensor ORDER BY id DESC");

                    while ($a = mysqli_fetch_array($data)) {
               ?>
                    <tr>
                         <td><?php echo $no++; ?></td>
                         <td><?php echo $a['tanggal']; ?></td>
                         <td><?php echo $a['waktu']; ?></td>
                         <td><?php echo $a['suhu']; ?></td>
                         <td><?php echo $a['kelembaban']; ?></td>
                         <td><?php echo $a['ketinggian']; ?></td>
                    </tr>
               <?php
                    }
               ?>
          </tbody>
     </table>
</div>