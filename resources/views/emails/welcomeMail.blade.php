<!DOCTYPE html>
<html>
<head>
  <title>Welcome Email</title>
  <style>
    /* Global Styles */
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
    }

    /* Container Styles */
    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: #f7f7f7;
    }

    /* Header Styles */
    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header img {
      max-width: 200px;
    }

    /* Content Styles */
    .content {
      background-color: #fff;
      padding: 30px;
      border-radius: 5px;
    }

    .content p {
      color: #000;
    }

    /* Button Styles */
    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
      margin-top: 20px;
    }

    /* Media Queries */
    @media only screen and (max-width: 500px) {
      .container {
        max-width: 100%;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="header">
      <img src="smartsub-logo.png" alt="SmartSub Logo">
    </div>
    <div class="content">
      <p>Dear {{ $mailData['name'] }},</p>
      <p>Welcome to SmartSub!</p>
      <p>Use the code below to activate your account:</p>
      <h2>Activation code: 12345</h2>
      <p>Thank you!</p>
    </div>
  </div>
</body>
</html>
