<?php
include('./common/db.php');
if (!isset($_GET['details'])) {
    echo "<div class='alert alert-danger'>Invalid course ID.</div>";
    exit;
}

$courseId = intval($_GET['details']);

// Fetch main course
$stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
$stmt->bind_param("i", $courseId);
$stmt->execute();
$mainResult = $stmt->get_result();

if ($mainResult->num_rows === 0) {
    echo "<div class='alert alert-warning'>Course not found.</div>";
    exit;
}
$mainCourse = $mainResult->fetch_assoc();

// Fetch other courses
$otherCourses = $conn->query("SELECT * FROM courses WHERE id != $courseId LIMIT 6");
?>

<div class="container py-5">
    <div class="row g-5">
        <!-- Main Course Detail -->
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <img src="./server/courses/<?php echo htmlspecialchars($mainCourse['thumbnail']); ?>" class="card-img-top" height="300" style="object-fit: cover;" alt="Course Image">
                <div class="card-body">
                    <h3 class="card-title <?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?>">
                        <?php echo htmlspecialchars($mainCourse['title']); ?>
                    </h3>
                    <p class="card-text fs-5"><?php echo htmlspecialchars($mainCourse['description']); ?></p>

                    <!-- Sample Additions -->
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong>Instructor:</strong> John Doe</li>
                        <li class="list-group-item"><strong>Duration:</strong> 6 weeks</li>
                        <li class="list-group-item"><strong>Language:</strong> English</li>
                    </ul>

                    <a href="#" class="btn btn-success">Enroll Now</a>
                </div>
            </div>
        </div>

        <!-- Sidebar: Other Courses -->
        <div class="col-lg-4 " style=" height: 600px; overflow:scroll; cursor:pointer">
            <h4 class="mb-3 text-primary">Other Courses</h4>
            <div class="row g-3">
                <?php while ($course = $otherCourses->fetch_assoc()) { ?>
                    <div class="col-12">
                        <div class="card h-100 border-0 shadow-sm">
                            <img src="./server/courses/<?php echo htmlspecialchars($course['thumbnail']); ?>" class="card-img-top" height="120" style="object-fit: cover;" alt="Other Course Thumbnail">
                            <div class="card-body">
                                <h6 class="card-title text-primary"><?php echo htmlspecialchars($course['title']); ?></h6>
                                <p class="card-text small"><?php echo substr(htmlspecialchars($course['description']), 0, 60) . '...'; ?></p>
                                <a href="?details=<?php echo $course['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>