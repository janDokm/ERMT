<?php
include '../auth/db.php';

if (isset($_POST['add_student'])) {

  $stmt = $pdo->query("SELECT student_id FROM students ORDER BY id DESC LIMIT 1");
  $lastStudent = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($lastStudent) {
    $lastNumber = (int)substr($lastStudent['student_id'], strpos($lastStudent['student_id'], '-') + 1);
    $newNumber = $lastNumber + 1;
  } else {
    $newNumber = 1;
  }

  $newStudentId = 'RMT-' . $newNumber;

  $stmt = $pdo->prepare("INSERT INTO students 
    (student_id, name, class, gender, age, rmt_status, guardian_name, guardian_contact)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
  
  $stmt->execute([
    $newStudentId,
    $_POST['name'],
    $_POST['class'],
    $_POST['gender'],
    $_POST['age'],
    $_POST['rmt_status'],
    $_POST['guardian_name'],
    $_POST['guardian_contact']
  ]);

  header("Location: view_students.php?added=1"); 
  exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Student</title>
  <link rel="stylesheet" href="../CSS/dashboard.css">
  <link rel="stylesheet" href="../CSS/add_student.css">
</head>
<body>

  <div class="form-container">
    <h2>Add New Student</h2>

    <form method="POST">
      <input type="text" name="name" placeholder="Full Name" required>

        <label for="grade">Select Grade:</label>
        <select id="grade">
          <option value="">-- Select Grade --</option>
          <option value="1">Grade 1</option>
          <option value="2">Grade 2</option>
          <option value="3">Grade 3</option>
          <option value="4">Grade 4</option>
          <option value="5">Grade 5</option>
          <option value="6">Grade 6</option>
        </select>

        <label for="class">Select Class:</label>
        <select id="class" name="class" required>
          <option value="">-- Select Class --</option>
        </select>

      <select name="gender" required>
        <option value="">Select Gender</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
      </select>

      <select type="number" name="age" required>
        <option value="">Age</option>
        <option value="">7</option>
        <option value="">8</option>
        <option value="">9</option>
        <option value="">10</option>
        <option value="">11</option>
        <option value="">12</option>
      </select>

      <select name="rmt_status">
        <option value="Active">Active</option>
        <option value="Inactive">Inactive</option>
      </select>

      <input type="text" name="guardian_name" placeholder="Guardian Name" required>
      <input type="number" name="guardian_contact" placeholder="Guardian Contact" required>

      <button type="submit" name="add_student">Add Student</button>
    </form>

    <a class="back-link" href="view_students.php">← Back to Student List</a>
  </div>

</body>

<!--js for grade & class dropdown list-->
<script>
  const classOptions = {
    1: ['1A', '1B', '1C', '1D', '1E', '1F'],
    2: ['2A', '2B', '2C', '2D', '2E', '2F'],
    3: ['3A', '3B', '3C', '3D', '3E', '3F'],
    4: ['4A', '4B', '4C', '4D', '4E', '4F'],
    5: ['5A', '5B', '5C', '5D', '5E', '5F'],
    6: ['6A', '6B', '6C', '6D', '6E', '6F'],
  };

  const gradeSelect = document.getElementById('grade');
  const classSelect = document.getElementById('class');

  gradeSelect.addEventListener('change', () => {
    const grade = gradeSelect.value;
    classSelect.innerHTML = '<option value="">-- Select Class --</option>';

    if (classOptions[grade]) {
      classOptions[grade].forEach(cls => {
        const opt = document.createElement('option');
        opt.value = cls;
        opt.textContent = cls;
        classSelect.appendChild(opt);
      });
    }
  });
</script>

</html>
