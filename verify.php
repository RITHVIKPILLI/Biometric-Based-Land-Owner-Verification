<!DOCTYPE html>
<html>
   <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>verification</title>
      <link rel="stylesheet" href="style.css">
      <script src="https://kit.fontawesome.com/03475aa693.js" crossorigin="anonymous"></script>
   </head>
   <body>
      <div class="container">
         <div class="form-box">
            <h1>VERIFICATION</h1>
            <form method="post" action="data.php">
               <div class="input-group">
                  <div class="input-field">
                     <i class="fa-regular fa-id-card"></i>
                     <label for="surveyNo"></label>
                     <input type="text" placeholder="Enter Survey Number" id="surveyNo" name="surveyNo" value="<?php echo isset($_POST['surveyNo']) ? htmlspecialchars($_POST['surveyNo']) : ''; ?>" required>
                  </div>
                  <div class="captcha">
                     <div id="captchaValue"><i class="fa-solid fa-check"></i></div>
                     <input id="inputCaptcha" type="text" name="captcha" placeholder="Captcha">
                  </div>
                  <div class="submitBtn">
                     <button type="submit" value="submit">submit</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <script src="script.js"></script>
   </body>
</html>
