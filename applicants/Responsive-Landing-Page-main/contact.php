<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Page</title>
    <link rel="stylesheet" href="style.css" />
    <style>
      @import url('https://fonts.googleapis.com/css?family=Roboto');

      * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        outline: none;
        font-family: 'Roboto', sans-serif;
      }

      body {
        background: url('https://i.imgur.com/kk76J5I.jpg') no-repeat top center;
        background-size: cover;
        height: 100vh;
      }

      .wrapper {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        max-width: 550px;
        background: rgba(255, 255, 255, 0.8);
        padding: 30px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      }

      .wrapper .title h1 {
        color: green;
        text-align: center;
        margin-bottom: 25px;
      }

      .contact-form {
        display: flex;
      }

      .input-fields {
        display: flex;
        flex-direction: column;
        margin-right: 4%;
      }

      .input-fields,
      .msg {
        width: 48%;
      }

      .input-fields .input,
      .msg textarea {
        margin: 10px 0;
        background: transparent;
        border: 0px;
        border-bottom: 2px solid green;
        padding: 10px;
        color: green;
        width: 100%;
      }

      .msg textarea {
        height: 212px;
      }

      ::-webkit-input-placeholder {
        /* Chrome/Opera/Safari */
        color: green;
      }
      ::-moz-placeholder {
        /* Firefox 19+ */
        color: #c5ecfd;
      }
      :-ms-input-placeholder {
        /* IE 10+ */
        color: #c5ecfd;
      }

      .btnsend {
        background: #39b7dd;
        text-align: center;
        padding: 15px;
        border-radius: 5px;
        color: #fff;
        cursor: pointer;
        text-transform: uppercase;
      }

      @media screen and (max-width: 600px) {
        .contact-form {
          flex-direction: column;
        }
        .msg textarea {
          height: 80px;
        }
        .input-fields,
        .msg {
          width: 100%;
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

        <div class="wrapper">
          <div class="title">
            <h1>Contact Us </h1>
          </div>
          <form action="send_mail.php" method="POST" class="contact-form">
            <div class="input-fields">
              <input type="text" name="name" class="input" placeholder="Name" required>
              <input type="email" name="email" class="input" placeholder="Email Address" required>
              <input type="text" name="phone" class="input" placeholder="Phone">
              <input type="text" name="subject" class="input" placeholder="Subject" required>
            </div>
            <div class="msg">
              <textarea name="message" placeholder="Message" required></textarea>
              <button type="submit" class="btnsend">Send</button>
            </div>
          </form>
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
