<?php
include '../auth/db.php';
$where = [];
$params = [];

if (!empty($_GET['name'])) {
  $where[] = "`name` LIKE ?";
  $params[] = "%" . $_GET['name'] . "%";
}
if (!empty($_GET['class'])) {
  $where[] = "`class` = ?";
  $params[] = $_GET['class'];
}
if (!empty($_GET['gender'])) {
  $where[] = "`gender` = ?";
  $params[] = $_GET['gender'];
}
if (!empty($_GET['age'])) {
  $where[] = "`age` = ?";
  $params[] = $_GET['age'];
}
if (!empty($_GET['rmt_status'])) {
  $where[] = "`rmt_status` = ?";
  $params[] = $_GET['rmt_status'];
}

$sql = "SELECT * FROM students";
if ($where) {
  $sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY id DESC"; 

try {
  $stmt = $pdo->prepare($sql);
  $stmt->execute($params);
  $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Query failed: " . $e->getMessage());
}

$classes = [
  '1A','1B','1C','1D','1E','1F',
  '2A','2B','2C','2D','2E','2F',
  '3A','3B','3C','3D','3E','3F',
  '4A','4B','4C','4D','4E','4F',
  '5A','5B','5C','5D','5E','5F',
  '6A','6B','6C','6D','6E','6F'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Student List</title>
  <link rel="stylesheet" href="../CSS/dashboard.css">
  <link rel="stylesheet" href="../CSS/view_students.css?v=3">
</head>
<body>
  <div class="table-container">
    <h2>RMT Student List</h2>

    <!-- FILTER FUNCTION PART -->
    <form method="GET" class="filter-form">
      <input
        type="text"
        name="name"
        placeholder="Search name…"
        value="<?= htmlspecialchars($_GET['name'] ?? '') ?>"
      />

      <select name="class">
        <option value="">All classes</option>
        <?php foreach ($classes as $cls): ?>
          <option value="<?= $cls ?>" <?= (($_GET['class'] ?? '') === $cls) ? 'selected' : '' ?>>
            <?= $cls ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="gender">
        <option value="">All genders</option>
        <option value="Male"   <?= (($_GET['gender'] ?? '') === 'Male')   ? 'selected' : '' ?>>Male</option>
        <option value="Female" <?= (($_GET['gender'] ?? '') === 'Female') ? 'selected' : '' ?>>Female</option>
      </select>

      <select name="age">
        <option value="">All ages</option>
        <?php for ($i=7; $i<=12; $i++): ?>
          <option value="<?= $i ?>" <?= (($_GET['age'] ?? '') == $i) ? 'selected' : '' ?>><?= $i ?></option>
        <?php endfor; ?>
      </select>

      <select name="rmt_status">
        <option value="">All status</option>
        <option value="Active"   <?= (($_GET['rmt_status'] ?? '') === 'Active')   ? 'selected' : '' ?>>Active</option>
        <option value="Inactive" <?= (($_GET['rmt_status'] ?? '') === 'Inactive') ? 'selected' : '' ?>>Inactive</option>
      </select>

      <button type="submit">Filter</button>
      <a class="reset-link" href="view_students.php">Reset</a>
    </form>

    <!-- TABLE PART -->
    <table>
      <tr>
        <th>Student ID</th>
        <th>Name</th>
        <th>Class</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Status</th>
        <th>Guardian</th>
        <th>Contact</th>
      </tr>
      <?php if (!empty($students)): ?>
        <?php foreach ($students as $row): ?>
          <tr>
            <td><?= htmlspecialchars($row['student_id']) ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['class']) ?></td>
            <td><?= htmlspecialchars($row['gender']) ?></td>
            <td><?= htmlspecialchars($row['age']) ?></td>
            <td><?= htmlspecialchars($row['rmt_status']) ?></td>
            <td><?= htmlspecialchars($row['guardian_name']) ?></td>
            <td><?= htmlspecialchars($row['guardian_contact']) ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="8">No students found.</td></tr>
      <?php endif; ?>
    </table>

    <div style="text-align:center; margin-top:20px">
      <a href="add_student.php"
         style="background-color:var(--button-color); color:white; padding:10px 20px; border-radius:6px; text-decoration:none;">
         Add New Student
      </a>
    </div>
  </div>
</body>
</html>
