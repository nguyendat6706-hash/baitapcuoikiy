<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Update User Information</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="/UTH-PHP/src/view/assets/css/homepage.css">
  <style>
    body {
      background-color: #fdf6e6;
    }

    .container__udpateInformation {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #fdf6e6;
      margin-top: 110px;
    }

    .form__updateInformation {
      width: 50%;
      margin: 50px auto;
      padding: 20px;
      border: 2px solid red;
      border-radius: 10px;
      background-color: white;
    }

    .text__updateInformation {
      text-align: center;
      color: black;
    }

    .form__updateInformation label {
      display: block;
      margin-bottom: 5px;
      color: black;
    }

    .form__updateInformation input[type="text"],
    .form__updateInformation input[type="date"],
    .form__updateInformation select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid red;
      border-radius: 5px;
      box-sizing: border-box;
    }

    .form__updateInformation input[type="submit"] {
      width: 100%;
      background-color: red;
      color: white;
      padding: 10px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 20px;
    }

    .form__updateInformation input[type="submit"]:hover {
      background-color: darkred;
    }

    .label__email {
      color: gray !important;
    }

    #email {
      background-color: lightgray !important;
    }
  </style>
</head>

<body>
  <?php
  $projectRoot = $_SERVER['DOCUMENT_ROOT'] . '/UTH-PHP';
  require_once $projectRoot . '/src/view/include/header.php';
  ?>
  <div class="container__udpateInformation">
    <form action="#" method="post" class="form__updateInformation">
      <h2 class="text__updateInformation">Update User Information</h2>
      <label for="fullName">Full Name:</label>
      <input type="text" id="fullName" name="fullName" required />

      <label for="birthDate">Birth Date:</label>
      <input type="date" id="birthDate" name="birthDate" />

      <label for="gender">Gender:</label>
      <select id="gender" name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <label for="phoneNumber">Phone Number:</label>
      <input type="text" id="phoneNumber" name="phoneNumber" />

      <label for="address">Address:</label>
      <input type="text" id="address" name="address" />

      <label for="email" class="label__email">Email: <i class="fa-solid fa-exclamation"></i></label>
      <input type="text" id="email" name="email" required disabled />

      <input type="submit" value="Update" />
    </form>
  </div>
  <?php
  require_once $projectRoot . '/src/view/include/footer.php';
  ?>
</body>

</html>