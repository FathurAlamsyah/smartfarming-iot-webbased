     <div class="judul">
          <h2>DASHBOARD</h2>
     </div>
     <div class="kontrol">
          <div class="rowJudul">
               Kondisi Relay
          </div>
          <div class="rowKet">
               <div class="col">
                    Relay 1:
               <?php
                    include 'connect.php';
                    $query2 = mysqli_query($con,'SELECT * FROM kontrol WHERE id=1');
                    $val2 = mysqli_fetch_assoc($query2);
                    if ($val2['nilai']==1) {
                         echo "Nyala";
                    }
                    elseif ($val2['nilai']==0) {
                         echo "Mati";
                    }
               ?>
               </div>
               <div class="col">
                    <?php
                         if ($val2['nilai']==1) {
                    ?>
                         <a href="kontrolLed.php?id=<?php echo $val2['id']; ?>" class="mati">MATIKAN</a>
                    <?php
                         }
                         elseif($val2['nilai']==0){
                    ?>
                         <a href="kontrolLed.php?id=<?php echo $val2['id']; ?>" class="nyala">NYALAKAN</a>
                    <?php          
                         }
                    ?>
               </div>
          </div>
          <div class="rowKet">
               <div class="col">
                    Relay 2:
                    <?php
                         $query3 = mysqli_query($con,'SELECT * FROM kontrol WHERE id=2');
                         $val3 = mysqli_fetch_assoc($query3);
                         if ($val3['nilai']==1) {
                              echo "Nyala";
                         }
                         elseif ($val3['nilai']==0) {
                              echo "Mati";
                         }
                    ?>
               </div>
               <div class="col">
                    <?php
                         if ($val3['nilai']==1) {
                    ?>
                         <a href="kontrolLed.php?id=<?php echo $val3['id']; ?>" class="mati">MATIKAN</a>
                    <?php
                         }
                         elseif($val3['nilai']==0){
                    ?>
                         <a href="kontrolLed.php?id=<?php echo $val3['id']; ?>" class="nyala">NYALAKAN</a>
                    <?php          
                         }
                    ?>
               </div>
          </div>
          <?php
               $data = mysqli_query($con,"SELECT * FROM sensor ORDER BY id DESC LIMIT 1");
               $d=mysqli_fetch_assoc($data);
          ?>
          <div class="colTanggal">
               <table>
                    <thead>
                         <tr>
                              <td>Tanggal</td>
                              <td>Waktu</td>
                         </tr>
                    </thead>
                    <tbody>
                         <tr>
                              <td><?php echo $d['tanggal']; ?></td>
                              <td><?php echo $d['waktu']; ?></td>
                         </tr>
                    </tbody>
               </table>
          </div>
          <div class="data">
               <div class="card suhu">
                    <div class="judulCard">
                         <span>SUHU</span>
                    </div>
                    <div class="bodyCard">
                         <p><?php echo $d['suhu']; ?> &#176;C</p>
                    </div>
               </div>
               <div class="card lembab">
                    <div class="judulCard">
                         <span>KELEMBABAN</span>
                    </div>
                    <div class="bodyCard">
                         <p><?php echo $d['kelembaban']; ?></p>
                    </div>
               </div>
               <div class="card air">
                    <div class="judulCard">
                         <span>KETINGGIAN AIR</span>
                    </div>
                    <div class="bodyCard">
                         <p><?php echo $d['ketinggian']; ?> cm</p>
                    </div>
               </div>
          </div>
     </div>