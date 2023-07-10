<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <title>SMARTFARMING IOT</title>
  </head>
  <body>
    <div class="container">
      <div class="head">
        <div class="logo">
          <span class="material-symbols-outlined">psychiatry</span>  
          CABE
          <span class="material-symbols-outlined">psychiatry</span>  
        </div>
        <div class="menu">
          <ul>
            <li>
              <a href="?p=dashboard"><span class="material-symbols-outlined">home</span>DASHBOARD</a>
            </li>
            <li>
              <a href="?p=history"><span class="material-symbols-outlined">table</span>HISTORY</a>
            </li>
          </ul>
        </div>
        
      </div>
      <div class="content">
        <div class="isi">
          <?php
            if (isset($_GET['p'])) {
              $p = $_GET['p'];

              switch ($p) {
                case 'dashboard':
                  include 'dashboard.php';
                  break;
                case 'history':
                    include 'history.php';
                    break;
                default:
                  include 'dashboard.php';
                  break;
              }
            }
            else{
              include 'dashboard.php';
            }
          ?>
        </div>
      </div>
      <div class="foot">
        &#169; AFA - ProAction Palu 2023 &#169;
      </div>
    </div>
  </body>
</html>