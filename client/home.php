<div class="container">
    <h3 class="my-3 logo-text <?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?>">Our New Launched Courses</h3>
    <div class="row g-4">
        <?php
        include('./common/db.php');
        $query = "SELECT * FROM `courses`";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $title = $row['title'];
            $description = $row['description'];
            $thumbnail = $row['thumbnail']; // Assuming you store image filename
        ?>
            <div class="col-md-4"> <!-- Responsive Grid -->
                <div class="card h-100 shadow">
                    <img src="./server/courses/<?php echo $thumbnail ?>" class="card-img-top" height="150" style="object-fit: cover;" alt="Course Thumbnail">
                    <div class="card-body">
                        <h5 class="card-title <?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?>"><?php echo htmlspecialchars($title); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($description); ?></p>
                        <div class="text-center">
                            <a href="#" class="btn <?php echo isset($_SESSION['isUserAdmin']) ? 'btn-danger' : 'btn-primary'; ?>">View Course</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>