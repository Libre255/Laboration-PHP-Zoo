<?php
    //Values from Form input
    $DjurName = $_POST['Djurnämn']; // Text Input
    $KSelected = explode("_", $_POST['DjurCategory']);
    $DjurKategori = $KSelected[0]; //Kategori Selected

    $host = 'localhost';
    $user = 'zooVisitor';
    $password = 'one123';
    $dbName = 'zoo';

    //SET DSN = command to connect to database
    $DSN = 'mysql:host='.$host.';dbname='.$dbName;
    $PDO = new PDO($DSN, $user, $password); //Setting PDO connect login info
    $PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); //Auto Format to FETCH_OBJ when fetching

    //Setting the Query
    // +++ Fetching Name 
    $SQLsearchA = 'SELECT * FROM animals WHERE name = ?';
    $stmtA = $PDO->prepare($SQLsearchA); 
    $stmtA->execute([$DjurName]);
    $FetchNameResult = $stmtA->fetchAll();
    $NameResultA = $FetchNameResult[0]->name;
    $ImgResultA = $FetchNameResult[0]->img;
    $BirthdayResultA = $FetchNameResult[0]->birthday;
    $CategoryResultA = $FetchNameResult[0]->category;
    //+++ Fetching everything in the same Category
    $SQLsearchB = 'SELECT * FROM animals WHERE  category = ?';
    $stmtB = $PDO->prepare($SQLsearchB); 
    $stmtB->execute([$DjurKategori]);
    $CategoryResult = $stmtB->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./CSS/style.css">
  <title>Document</title>
</head>
<body>
  <header>
    <div class="Menu-Main">
      <div class="MenuButtons"><a href="index.php">Hem</a></div>
      <div class="MenuButtons"><a href="SearchAnimal.php">Mina Djur</a></div>
      <div class="MenuButtons LogoMenu"><a href="index.php">PHP Zoo</a></div>
      <div class="MenuButtons">Om mig</div>
      <div class="MenuButtons"><a href="katalog.php">Katalog</a></div>
    </div>
  </header>
  <main>
    <div class="myForm">
        <form action="SearchAnimal.php" method="POST" id="SearchDjur">
          <table>
            <caption>Sök Djur</caption>
            <tr>
              <td>Nämn</td>
              <td><input type="text" name="Djurnämn"></td>
            </tr>
            <tr>
              <td>Kategori </td>
              <td>
                <select id="cars" name="DjurCategory" form="SearchDjur">
                  <option value="Däggdjur">Däggdjur</option>
                  <option value="Fågel">Fågel</option>
                  <option value="Fisk">Fisk</option>
                  <option value="Insekt">Insekt</option>
                </select>
              </td>
            </tr>
                <tr>
                  <td>
                    <br>
                    <input type="submit" value="Sök">
                  </td>
                </tr>
          </table>
        </form>
    </div>
    <div class="centerdiv SearchBoxResult">
      <?php 
       if($DjurName && $DjurKategori){
          if($CategoryResultA == $CategoryResult[0]->category){
            echo <<<EOD
            <div class="animalSearchResultBox">
            <img class="AnimalIMG" src='$ImgResultA' alt='$NameResultA'> <br> <br>
            <p class="AnimalInfo"> Nämn:$NameResultA </p> <br>
            <p class="AnimalInfo">Föddelsedag:$BirthdayResultA</p> <br>
            <p class="AnimalInfo">Kategori:$CategoryResultA</p> <br>
            </div>
EOD;
          }else{
            echo "<p class='defaultSearchText'>Nämnen och kategoriet matchar inte</p>";
          };
       }elseif($DjurKategori){
          foreach($CategoryResult as $Kanimals){
            echo <<<EOD
            <div class="animalSearchResultBox">
            <img class="AnimalIMG" src='$Kanimals->img' alt='$Kanimals->name'> <br> <br>
           <p class="AnimalInfo">Nämn:$Kanimals->name</p> <br>
           <p class="AnimalInfo">Föddelsedag:$Kanimals->birthday</p> <br>
           <p class="AnimalInfo">Kategori:$Kanimals->category</p> <br>
            </div>
EOD;
          };
       }else{
         echo "<p class='defaultSearchText'>Välj en kategori och sök eller skriv djur nämn med rätt Kategori </p>";
       };
      ?>
    </div>
  </main>
</body>
</html>