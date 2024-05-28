<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Multistep form</title>
    <link rel="stylesheet" href="../Style/uploadFileStyle.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
      integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>

  <?php
  include 'database.php'
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "uploads/";
    $targetFile = $targetDir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if file is a PDF
    if ($fileType != "pdf") {
      echo "Only PDF files are allowed.";
      $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
      echo "File already exists.";
      $uploadOk = 0;
    }

    if ($_FILES["file"]["size"] > 500000) {
      echo "File size exceeds the limit.";
      $uploadOk = 0;
  }
  
  // Check if file is a PDF
  $fileType = pathinfo($_FILES["file"]["name"], PATHINFO_EXTENSION);
  if($fileType != "pdf") {
      echo "Only PDF files are allowed.";
      $uploadOk = 0;
  }
  
  // Upload file if all checks pass
  if ($uploadOk == 1) {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
      
          // Get the file details
          $user_id = $_SESSION['user'];
          $name = isset($_POST['name']) ? $_POST['name'] : '';
          $location = isset($_POST['location']) ? $_POST['location'] : '';
          $pdf = file_get_contents($targetFile); // Read file content
          $status = "Waiting"; 
  
          // Create connection
          $conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);
          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }
  
          // Prepare and bind the file details
          $stmt = $conn->prepare("INSERT INTO Houses (user_id, name, location, pdf, status) VALUES (?, ?, ?, ?, ?)");
          $stmt->bind_param("issss", $user_id, $name, $location, $pdf, $status);
  
          // Execute the statement
          if ($stmt->execute()) {
              echo "File uploaded successfully.";
          } else {
              echo "Error uploading file.";
          }
  
          // Close the statement and connection
          $stmt->close();
          $conn->close();
      } else {
          echo "Error uploading file.";
      }
  ?>
    <div class="container">
      <header>upload a house</header>
      <div class="progress-bar">
        <div class="step">
          <p>Personal info</p>
          <div class="bullet">
            <span>1</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
    
        <div class="step">
          <p>House info</p>
          <div class="bullet">
            <span>2</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>upload pictures</p>
          <div class="bullet">
            <span>3</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
      </div>
      <div class="form-outer">
        <form action="uploadFile.php" method='POST'>
          <div class="page slide-page">
            <div class="title">Basic Info:</div>
            <div class="field">
              <div class="label">First Name</div>
              <input type="text" id='name' name='name' required />
            </div>
           
            <div class="field">
              <button class="firstNext next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">House Info:</div>
            <div class="field">
              <div class="label">House location</div>
              <input type="text" id='location' name='location'  required />
            </div>
         
            <div class="field btns">
              <button class="prev-1 prev">Previous</button>
              <button class="next-1 next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">House Image:</div>
            <div class="field">
              <input type="file" accept=".pdf" id="myFile" name="myFile" />
            </div>

            <div class="field btns">
              <button class="prev-1 prev">Previous</button>
              <button type="submit" class="next-1 next">submit</button>
              <!-- please make it when you click submit it takes him to index page -->
            </div>
          </div>
        </form>
      </div>
    </div>
    <script src="../Scripts/uploadingFile.js"></script>
  </body>
</html>
