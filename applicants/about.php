<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css" />

    <style>
       .text{
        text-align: justify;
       }
       
      
      </style>
</head>
  <body>
    <main>
      <div class="big-wrapper dark">
        <img src="./img/shape.png" alt="" class="shape" />

        <header>
          <div class="container">
            <div class="logo">
              <img src="./img/saq.png" alt="Logo" />
              <h3>Educational Assistance</h3>
            </div>

            <div class="links">
              <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="proc.php">Procedure</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php" class="btn">Login</a></li>
              </ul>
            </div>

            <div class="overlay"></div>

            <div class="hamburger-menu">
              <div class="bar"></div>
            </div>
          </div>
        </header>

        <div class="showcase-area">
            
          <div class="container">
          <div class="right">
              <img src="./img/boun.jpg" alt="Person Image" class="person" />
            </div>
            <div class="left">
              <div class="big-title">
                <br>
                <h3>About Us </h3>
             
              </div>

              <p class="text">
              <strong>About the System </strong> <br>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                Laudantium rem quo quod modi ex. Illo fuga reprehenderit, corrupti 
                nisi omnis consectetur maxime qui molestias ut voluptas sit excepturi 
                inventore!Lorem ipsum dolor sit, amet consectetur adipisicing elit. 
                Laudantium rem quo quod modi ex. Illo fuga reprehenderit, corrupti 
                nisi omnis consectetur maxime qui molestias ut voluptas sit excepturi 
                inventore!</p>
              <div class="cta">
               <!-- <a href="#" class="btn">Get started</a> -->
              </div>
            </div>

            
          </div>
        </div>


        <div class="bottom-area">
          <div class="container">
            <button class="toggle-btn">
              <i class="far fa-moon"></i>
              <i class="far fa-sun"></i>
            </button>
          </div>
        </div>
      </div>
    </main>

    <!-- JavaScript Files -->

    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <script src="./app.js"></script>
  </body>
</html>
