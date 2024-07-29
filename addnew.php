<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assignment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
    .profile-picture {
      max-width: 150px;
      max-height: 150px;
      object-fit: cover;
      border-radius: 50%;
    }

    .form-container {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }

    .form-container .form-group {
      flex: 1;
    }

    .profile-picture-container {
      margin-left: 3px;
      width: 483px;
    }
  </style>
</head>

<body>
  <div class="section bg-dark">
    <nav class="navbar navbar-expand-lg navbar-light p-2  container">
      <a class="navbar-brand text-light logo" href="#"><img class="w-100" src="sl_z_072523_61700_05.jpg" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse " id="navbarNavDropdown">
        <ul class="navbar-nav ">
          <li class="nav-item active">
            <a class="nav-link text-light" href="#"></a>
          </li>
          <li class="nav-item">
          <a href="index.php"><h4>Twitter</h4></a>
          </li>
          <li class="nav-item">
            <a href="view.php" class="btn btn-primary mx-2">View Record</a>
            </a>
          </li>
        </ul>
      </div>
    </nav>
  </div>
  <div class="container mt-1">
    <div class="alert">
      <?php if (isset($_SESSION['status'])) echo "<p class='text-white bg-success p-2 rounded'>" . $_SESSION['status'] . "</p>";
      unset($_SESSION["status"]); ?>
    </div>
    <form class="bg-primary rounded p-5" action="upload.php" method="post" enctype="multipart/form-data">
      <h1>Add Submission</h1>
      <div class="form-container">
        <div class="">
          <div class="form-group mb-2">
            <label class="text-light" for="username"><b>Name</b></label>
            <input type="text" class="form-control" name="username" id="name" placeholder="Enter your name" required>
          </div>
          <div class="form-group mb-2">
            <label class="text-light" for="rollno"><b>Roll Number</b></label>
            <input type="number" class="form-control" name="rollno" id="rollno" placeholder="Enter your roll number" required>
          </div>
          <div class="form-group mb-2 bg-light p-2 mt-4 rounded">
            <label for="documents[]">Relevent Documents</label>
            <input type="file" class="form-control-file" id="documents" name="documents[]" multiple required>
          </div>
        </div>
        <div class="profile-picture-container bg-white rounded p-2">
          <img id="profilePicPreview" class="profile-picture " src="9720027.jpg" alt="Profile Picture Preview">
          <br>
          <label for="profilepicture">Profile Picture</label>
          <input type="file" class="form-control-file mb-2" id="profilepicture" name="profilepicture" accept="image/*" required>
        </div>
      </div>
      <button type="submit" name="submit" class="btn btn-success mt-3">Submit</button>
    </form>
  </div>
  <script>
    const avatar = '9720027.jpg'; // Default image URL

    document.getElementById('profilepicture').addEventListener('change', function(event) {
      const input = event.target;
      const file = input.files[0];

      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          const inputimage = document.getElementById('profilePicPreview');
          inputimage.src = e.target.result;
        };

        reader.readAsDataURL(file);
      } else {

        const inputimage = document.getElementById('profilePicPreview');
        inputimage.src = avatar;
      }
    });


    document.getElementById('profilepicture').addEventListener('click', function(event) {
      const input = event.target;
      input.value = '';
      const inputimage = document.getElementById('profilePicPreview');
      inputimage.src = avatar;
    });
  </script>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>