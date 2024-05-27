<?php
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

  // Check file size (optional)
  if ($_FILES["file"]["size"] > 500000) {
    echo "File size exceeds the limit.";
    $uploadOk = 0;
  }

  // Upload file if all checks pass
  if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
      echo "File uploaded successfully.";
    } else {
      echo "Error uploading file.";
    }
  }
}
?>
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
          <p>Contact info</p>
          <div class="bullet">
            <span>2</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>House info</p>
          <div class="bullet">
            <span>3</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
        <div class="step">
          <p>upload pictures</p>
          <div class="bullet">
            <span>4</span>
          </div>
          <div class="check fas fa-check"></div>
        </div>
      </div>
      <div class="form-outer">
        <form action="#">
          <div class="page slide-page">
            <div class="title">Basic Info:</div>
            <div class="field">
              <div class="label">First Name</div>
              <input type="text" required />
            </div>
            <div class="field">
              <div class="label">Last Name</div>
              <input type="text" required />
            </div>
            <div class="field">
              <button class="firstNext next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">Contact Info:</div>
            <div class="field">
              <div class="label">Email Address</div>
              <input type="text" required />
            </div>
            <div class="field">
              <div class="label">Phone Number</div>
              <input type="Number" required />
            </div>
            <div class="field btns">
              <button class="prev-1 prev">Previous</button>
              <button class="next-1 next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">House Info:</div>
            <div class="field">
              <div class="label">House Address</div>
              <input type="text" required />
            </div>
            <div class="field">
              <div class="label">House size (m²)</div>
              <input type="Number" required />
            </div>
            <div class="field">
              <div class="label">confition of house</div>
              <select required>
                <option>Perfect</option>
                <option>Good</option>
                <option>bad</option>
              </select>
            </div>
            <div class="field">
              <div class="label">House Description (optional)</div>
              <input type="text" />
            </div>
            <div class="field btns">
              <button class="prev-1 prev">Previous</button>
              <button class="next-1 next">Next</button>
            </div>
          </div>

          <div class="page">
            <div class="title">House Image:</div>
            <div class="field">
              <input type="file" id="myFile" name="filename" />
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
