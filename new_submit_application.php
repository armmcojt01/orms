<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job Application Form</title>
  <!-- Bootstrap CSS for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
  <h2>Job Application Form</h2>
  <form id="job-application-form" action="new_submit_query.php" method="POST" enctype="multipart/form-data">
    
    <!-- First Name -->
    <div class="mb-3">
      <label for="firstname" class="form-label">First Name</label>
      <input type="text" class="form-control" id="firstname" name="firstname" required>
    </div>

    <!-- Middle Name -->
    <div class="mb-3">
      <label for="middlename" class="form-label">Middle Name</label>
      <input type="text" class="form-control" id="middlename" name="middlename">
    </div>

    <!-- Last Name -->
    <div class="mb-3">
      <label for="lastname" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="lastname" name="lastname" required>
    </div>

    <!-- Gender -->
    <div class="mb-3">
      <label for="gender" class="form-label">Gender</label>
      <select class="form-select" id="gender" name="gender" required>
        <option value="" selected disabled>Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Other">Other</option>
      </select>
    </div>

    <!-- Email -->
    <div class="mb-3">
      <label for="email" class="form-label">Email</label>
      <input type="email" class="form-control" id="email" name="email" required>
    </div>

    <!-- Contact Number -->
    <div class="mb-3">
      <label for="contact" class="form-label">Contact Number</label>
      <input type="tel" class="form-control" id="contact" name="contact" required>
    </div>

    <!-- Complete Address -->
    <div class="mb-3">
      <label for="address" class="form-label">Complete Address</label>
      <textarea class="form-control" id="address" name="address" rows="4" required></textarea>
    </div>

    <!-- Position Applied For / Department / Item No -->
    <div class="mb-3">
      <label for="position" class="form-label">Position Applied For / Department / Item No</label>
      <input type="text" class="form-control" id="position" name="position" required>
    </div>

    <!-- Custom File Input for File Submission -->
    <div class="mb-3">
      <label for="resume" class="form-label">Upload Resume</label>
      <div class="custom-file">
        <input type="file" class="custom-file-input" id="resume" name="resume" accept="application/msword,application/pdf,.docx,.txt" onchange="displayfname(this)">
        <label class="custom-file-label" for="resume">Choose file</label>
      </div>
    </div>

    <!-- Save and Cancel Buttons -->
    <div class="modal-footer">
      <button type="submit" class="btn btn-primary" id="submit">Save</button>
      <button type="reset" class="btn btn-secondary" id="cancel">Cancel</button>
    </div>
  </form>
</div>

<!-- Bootstrap JS and JQuery (required for custom file input) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Function to update file name on file selection
  function displayfname(input) {
    var fileName = input.files[0].name;
    $(input).next('.custom-file-label').html(fileName);
  }
</script>

</body>
</html>
