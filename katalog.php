<?php 
  if(isset($_POST['submit'])){ // Checking if the Submit button is pressed
    $file = $_FILES['file']; // Selecting the input with the name file

    $fileName = $file['name'];
    $fileTemp = $file['tmp_name'];
    $fileError = $file['error'];

    $fileDT = explode('.', $fileName);
    $fileActualDT = strtolower(end($fileDT));
    $allowedFormats = array('jpg', 'png', 'jpeg');
    
    if($fileName == NULL){
      $väljFileError = "<p class='defaultSearchText'>Välj en fil innan du skickar</p>";
    }elseif(in_array($fileActualDT, $allowedFormats)){
      if($fileError === 0){
          $fileUniqueName = uniqid('', true).'.'.$fileActualDT;
          $fileDestination = 'KatalogBilder/'.$fileUniqueName;
          move_uploaded_file($fileTemp, $fileDestination);
      }else{
        $ErrorUploadingFile = "<p class='defaultSearchText'>Error uploading the file</p>";
      };
    }else{
      $ifNotFileSelect = "<p class='defaultSearchText'>Vi stöder inte den bild format</p>";
    };
  };

  $fileSystemIterator = new FilesystemIterator('KatalogBilder');// Checking the KatalogBilder Folder
  $KatalogBilder = array(); // Array to store
  foreach ($fileSystemIterator as $fileInfo){
      $KatalogBilder[] = $fileInfo->getFilename(); //Every Item inside the folder gets to our Array
  };
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
    <div class="KatalogSearch">
      <form action="katalog.php" method="POST" enctype="multipart/form-data">
        <h1>Lägg till en bild till katalogen!</h1>
        <input type="file" name="file">
        <br> <br>
        <input type="submit" name="submit" value="Skicka">
      </form>
    </div>
    <div class=" uploadedIMGBox ">
      <?php 
        //Error Handling
        echo "$väljFileError";
        echo "$ifNotFileSelect";
        echo "$ErrorUploadingFile";

        foreach($KatalogBilder as $MinaBilder){
          echo <<<EOD
          <div class="KatalogCenterIMG"><img src="./KatalogBilder/$MinaBilder"></div>
EOD;
        };
        // var_dump($KatalogBilder);
      ?>
    </div>
  </main>
</body>
</html>