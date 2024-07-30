<?php
include("dbcon.php");
session_start();

// Fetch data from the database
$sql = "SELECT * FROM `information` ORDER BY ID DESC";
$result = $conn->query($sql);
$row = $result->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="icon" type="image/jpg" href="sl_z_072523_61700_05.jpg">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <style>
    .profile-picture {
      width: 40%;
    }
  </style>
</head>

<body>
  <div class="section bg-dark">
    <nav class="navbar navbar-expand-lg navbar-light p-2 container">
      <a href="#">
        <img class="w-50" src="social_fb_facebook_14206.ico" alt="">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link text-light" href="#"></a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-light" href="#"></a>
          </li>
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addmodal"> Add Submission</button>
        </ul>
      </div>
    </nav>
  </div>

  <div class="modal fade" id="addmodal" tabindex="-1" aria-labelledby="addmodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addmodalLabel">Add Submission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="fupForm" class="" method="post" enctype="multipart/form-data">
            <div id="statusMsg"></div>
            <div class="form-container">
              <div class="profile-picture-container bg-white rounded p-2">
                <img id="profilePicPreview" class="profile-picture rounded-circle" src="9720027.jpg" alt="Profile Picture Preview">
                <br>
                <label for="profilepicture">Profile Picture</label>
                <input type="file" class="form-control-file mb-2" id="profilepicture" name="profilepicture" accept="image/*" required>
              </div>
              <div class="form-group">
                <label class="mb-2" for="name">Name:</label>
                <input class="rounded" type="text" id="name" name="name" placeholder="Enter name" required><br>
              </div>
              <div class="form-group mb-2">
                <label class="" for="email">Email :</label>
                <input class="rounded" type="email" id="email" name="email" placeholder="Enter email" required><br>
              </div>
              <div class="form-group">
                <label for="files">Documents:</label>
                <input type="file" id="files" name="files[]" multiple><br>
              </div>
            </div>
            <button id="submitBtn" type="submit" value="Submit" class="btn btn-success mt-3">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="container mt-5">
    <h2 class="text-center">All Submissions</h2>
    <table class="table table-striped">
      <thead class="table-dark">
        <tr>
          <th>S.No</th>
          <th>Name</th>
          <th>Email</th>
          <th>Relevant Documents</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $i = 0;
        foreach ($row as $user) {
          $i++;
        ?>
          <tr>
            <td><?php echo $i; ?></td>
            <td>
              <img src="uploads/<?php echo htmlspecialchars($user['profile']); ?>" width="30" height="30">
              <?php echo htmlspecialchars($user['name']); ?>
            </td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td>
              <?php
              $documents = explode(',', $user['files']);
              foreach ($documents as $document) {
                echo '<a href="uploads/' . htmlspecialchars($document) . '" target="_blank" class="d-block">View Online</a>';
              }
              ?>
            </td>
            <td>
              <a class="btn btn-primary edit-btn" data-id="<?php echo $user['id']; ?>" data-name="<?php echo htmlspecialchars($user['name']); ?>" data-email="<?php echo htmlspecialchars($user['email']); ?>" data-profile="<?php echo htmlspecialchars($user['profile']); ?>" data-files="<?php echo htmlspecialchars($user['files']); ?>" data-bs-toggle="modal" data-bs-target="#editmodal">Edit</a>

              <button class="btn btn-danger delete-btn" data-id="<?php echo $user['id']; ?>">Delete</button>
            </td>

          </tr>
        <?php
        }
        ?>
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="editmodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editmodalLabel">Edit Submission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm" class="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="editId" name="id">
            <div id="statusMsg"></div>
            <div class="form-container">
              <label for="editProfilePicture">Profile Picture</label>
              <input type="file" class="form-control-file mb-2" id="editProfilePicture" name="profilepicture" accept="image/*">
            </div>
            <div class="form-group">
              <label class="mb-2" for="editName">Name:</label>
              <input value="" class="rounded" type="text" id="editName" name="name" placeholder="Enter name" required><br>
            </div>
            <div class="form-group mb-2">
              <label class="" for="editEmail">Email :</label>
              <input value="" class="rounded" type="email" id="editEmail" name="email" placeholder="Enter email" required><br>
            </div>
            <div class="form-group">
              <label for="editFiles">Documents:</label>
              <input type="file" id="editFiles" name="files[]" multiple><br>
            </div>
        </div>
        <button id="editSubmitBtn" type="submit" value="Submit" class="btn btn-success mt-3">Submit</button>
        </form>
      </div>
    </div>
  </div>
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

  <script>
    $(document).ready(function() {
      $("#fupForm").on('submit', function(e) {
        e.preventDefault();
        $.ajax({
          type: 'POST',
          url: 'upload.php',
          data: new FormData(this),
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false,
          beforeSend: function() {
            $('#submitBtn').attr("disabled", "disabled");
          },
          success: function(response) {
            $('#statusMsg').html('');
            if (response.status == 1) {
              // Reset form
              $('#fupForm')[0].reset();
              $('#profilePicPreview').attr('src', avatar);
              let newRecord = response.record;
              let newRow = `<tr>
                              <td>${newRecord.ID}</td>
                              <td>
                                <img src="uploads/${newRecord.profile}" width="30" height="30">
                                ${newRecord.name}
                              </td>
                              <td>${newRecord.email}</td>
                              <td>
                                ${newRecord.files.split(',').map(file => `<a href="uploads/${file}" target="_blank" class="d-block">View Online</a>`).join('')}
                              </td>
                              <td>
                                <a class="btn btn-primary" href="">Edit</a>
                                <a class="btn btn-danger" href="">Delete</a>
                              </td>
                            </tr>`;
              $('table tbody').prepend(newRow);
              $('#statusMsg').html('<h5 class="alert alert-success" role="alert">' + response.message + '</h5>');
            } else {
              $('#statusMsg').html('<p class="alert alert-danger" role="alert">' + response.message + '</p>');
            }
            $('#submitBtn').removeAttr("disabled");
          }
        });
      });
    });
    $(document).ready(function() {
      // Existing form submission AJAX handler...

      // Handle deletion
      $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        $.ajax({
          type: 'POST',
          url: 'delete.php',
          data: {
            id: id
          },
          dataType: 'json',
          success: function(response) {
            if (response.status == 1) {
              $(`button.delete-btn[data-id="${id}"]`).closest('tr').remove();
            } else {
              (response.message);
            }
          }
        });
      });
    });
    $(document).ready(function() {
      // Existing AJAX handlers...

      // Populate edit modal with data
      $(document).on('click', '.edit-btn', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        const profile = $(this).data('profile');
        const files = $(this).data('files');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editEmail').val(email);
        $('#editProfilePicture').val('');
        $('#editFiles').val('');
        $('#editProfilePicture').next('img').attr('src', profile);
      });

      // Handle edit form submission
      $('#editForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
          type: 'POST',
          url: 'edit.php',
          data: new FormData(this),
          dataType: 'json',
          contentType: false,
          cache: false,
          processData: false,
          success: function(response) {
            if (response.status == 1) {
              // Update the record in the table
              const updatedRecord = response.record;
              const row = $(`a.edit-btn[data-id="${updatedRecord.ID}"]`).closest('tr');
              row.find('td:eq(1)').html(`<img src="uploads/${updatedRecord.profile}" width="30" height="30"> ${updatedRecord.name}`);
              row.find('td:eq(2)').text(updatedRecord.email);
              row.find('td:eq(3)').html(updatedRecord.files.split(',').map(file => `<a href="uploads/${file}" target="_blank" class="d-block">View Online</a>`).join(''));
              $('#editmodal').modal('hide');
              (response.message);
            } else {
              alert(response.message);
            }
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>