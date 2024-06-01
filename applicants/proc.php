<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Homepage</title>
    <link rel="stylesheet" href="style.css" />
 <style>
 .card {
        background-color: rgba(255, 255, 255, 0.8);
        padding: 10px;
        margin: 10px auto;
        max-width: 80%;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
      }

      .card h2 {
        color: #333;
        font-size: 2rem;
      }

      .step {
        margin-bottom: 20px;
        text-align: justify;
      }

      .step h3 {
        color: #333;
      }

      .step p {
        color: #555;
        text-align: justify;
      }

      @media (min-width: 600px) {
        .card {
          max-width: 80%;
          padding: 30px;
        }
      }

      @media (min-width: 900px) {
        .card {
          max-width: 60%;
          padding: 40px;
        }
      }

      @media (min-width: 1200px) {
        .card {
          max-width: 50%;
          padding: 50px;
        }
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
        <section class="card">
            <h2>How It Works</h2>
            <div class="steps">
                <div class="step">
                    <h3>Step 1</h3>
                    <p>Create an account to get started. If you have institutional email then, it is better to use.</p>
                </div>
                <div class="step">
                    <h3>Step 2</h3>
                    <p>Login to your account and fill in your details.</p>
                </div>
                <div class="step">
                    <h3>Step 3</h3>
                    <p>Apply for Educational Assistance.</p>
                </div>
                <div class="step">
                    <h3>Step 3</h3>
                    <p>Make sure to check your email account for necessary announcement.</p>
                </div>
            </div>
        </section>
       
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
