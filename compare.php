<?php 

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "data";

// Create a connection to the database
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

define('IMAGE_DIR', 'C:\xampp\htdocs\demo'); // Replace with the path to your directory containing images
define('SIMILARITY_THRESHOLD', 0.9); // Replace with your desired similarity threshold

if(isset($_POST['submit'])) {
    $surveyNo = mysqli_real_escape_string($conn, $_POST['surveyNo']); // Retrieve the survey number submitted by user

    // Retrieve image1 from the database
    $sql = "SELECT fp FROM details WHERE SERVEYNo='$surveyNo'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image1 = $row['fp'];
    } else {
        echo "Error: Image1 not found";
        exit();
    }

    // Retrieve image2 uploaded by user
    $image2 = $_FILES['image2']['tmp_name'];
    $image2_type = $_FILES['image2']['type'];

    // Check if image2 is a valid image file
    if($image2_type == "image/jpeg" || $image2_type == "image/png" || $image2_type == "image/gif") {
        // Compare the two images
        $image1 = imagecreatefromstring($image1);
        $image2 = imagecreatefromstring(file_get_contents($image2));
        $result = compareImages($image1, $image2);
        if($result) {
            $message = '<span style="color: green;">&#10004;</span>  Verification successful: fingerprint matches the authorized owner. <a href="verify.php"> Click here</a> to continue.';
          } else {
            $message = '<span style="color: red;">&#10006;</span>  Verification failed: fingerprint does not match the authorized owner. You will be redirected to the login page .';
          // Delay the redirect to the login page by 1 minute
    echo '<script>setTimeout(function() { window.location.href = "verify.php"; }, 4500);</script>';
        }
          echo '<div class="popup-overlay"></div>';
    echo '<div class="popup">';
    echo '<h2>' . $message . '</h2>';
    echo '<span class="close" onclick="closePopup()">&times;</span>';
    echo '</div>';
    } else {
        echo "Error: Invalid file type";
        exit();
    }
}

// Function to compare two images
function compareImages($image1, $image2) {
    // Get the width and height of the images
    $width1 = imagesx($image1);
    $height1 = imagesy($image1);
    $width2 = imagesx($image2);
    $height2 = imagesy($image2);

    // Check if the dimensions of the images match
    if($width1 != $width2 || $height1 != $height2) {
        return false;
    }

    // Set the tolerance level for pixel values
    $tolerance = 10;

    // Loop through each pixel in the images and compare their RGB values
    for($x = 0; $x < $width1; $x++) {
        for($y = 0; $y < $height1; $y++) {
            $rgb1 = imagecolorat($image1, $x, $y);
            $r1 = ($rgb1 >> 16) & 0xFF;
            $g1 = ($rgb1 >> 8) & 0xFF;
            $b1 = $rgb1 & 0xFF;

            $rgb2 = imagecolorat($image2, $x, $y);
            $r2 = ($rgb2 >> 16) & 0xFF;
            $g2 = ($rgb2 >> 8) & 0xFF;
            $b2 = $rgb2 & 0xFF;

            // Compare the RGB values with the tolerance level
            if(abs($r1 - $r2) > $tolerance || abs($g1 - $g2) > $tolerance || abs($b1 - $b2) > $tolerance) {
                return false;
            }
        }
    }

    // If all pixels are similar, return true
    return true;
}


?>

<!DOCTYPE html>
<html>
<head>
    <title>Compare Images</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #008000;
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="file"]{
            margin: 10px 0;
            width: 100%;
            padding: 5px;
        }

        input[type="submit"] {
            margin: 10px 0;
            width:15%;
            padding: 5px;
        }

        input[type="submit"] {
            background-color: #008000;
            color: #ffffff;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }

        .img-prev {
            width: 100%;
            max-width: 300px;
            text-align: center;
        }

        img {
            width: 100%;
            height: auto;
        }

        .col {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .popup {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
      z-index: 999;
    }
    .popup h2 {
      font-size: 20px;
      margin-top: 0;
    }
    .popup .close {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }
    
    /* Style for the blurred background */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 998;
      filter: blur(5px);
    }
.popup span {
  font-size: 30px;
  margin-right: 10px;
}
.popup span[color="green"] {
  color: green;
}
.popup span[color="red"] {
  color: red;
}
    </style>
</head>
<body>
<script>
    var popup = document.querySelector('.popup');
    var overlay = document.querySelector('.popup-overlay');
    
    function openPopup() {
      popup.style.display = 'block';
      overlay.style.display = 'block';
    }
    
    function closePopup() {
      popup.style.display = 'none';
      overlay.style.display = 'none';
    }
  </script>
    <div class="container">
        <h1>Compare Fingerprints</h1>
        <form action="" method="post" enctype="multipart/form-data">
            <div>
                <label for="surveyNo">ServeryNo</label>
                <input type="text" name="surveyNo" id="surveyNo" value="<?php echo isset($_POST['surveyNo']) ? htmlspecialchars($_POST['surveyNo']) : ''; ?>" required="required" readonly>
            </div>
            <div class="col">
                <div id="s-image1" class="img-prev">
                    <?php 
                    if(isset($_POST['submit'])) 
                    {
                        $surveyNo = mysqli_real_escape_string($conn, $_POST['surveyNo']);
                        // Retrieve the survey number submitted by user
                        // Retrieve image1 from the database
                        $sql = "SELECT fp FROM details WHERE SERVEYNo='$surveyNo'";
                        $result = mysqli_query($conn, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $image1 = $row['fp'];
                        echo '<img src="data:image/jpeg;base64,'.base64_encode($image1).'">';
                    }
                    ?>
                </div>
            </div>
            <div class="col">
                <input type="file" name="image2" id="image2" required="required" onchange="loadFile(event)">
                <div id="s-image2"  class="img-prev">
                    <img id="previewImg" src="" >
                </div>
            </div> 
            <div class="clearfix"></div>
            <input type="submit" name="submit" value="SUBMIT">
        </form>
    </div>
    <script>
        function loadFile(event) {
            var output = document.getElementById('previewImg');
            output.src = URL.createObjectURL(event.target.files[0]);
        };
        setTimeout(function() {
    var popup = document.querySelector('.popup');
    if (popup) {
      popup.style.display = 'none';
    }
  }, 5000); // Close the popup after 5 seconds
    </script>
</body>
</html>