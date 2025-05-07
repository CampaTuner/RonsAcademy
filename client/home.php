<div class="container">
    <h3 class="my-3 logo-text <?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?>">
        Our New Launched Courses
    </h3>
    <div class="row g-4">
        <?php
        include('./common/db.php');
        $query = "SELECT * FROM `courses`";
        $result = $conn->query($query);

        while ($row = $result->fetch_assoc()) {
            $id = $row['id']; // Important: get ID
            $title = $row['title'];
            $description = $row['description'];
            $thumbnail = $row['thumbnail'];
        ?>
            <div class="col-md-4">
    <div class="card h-100 shadow" style="justify-content: space-between; height: 300px;">
        <!-- Course Thumbnail -->
        <img src="./server/courses/<?php echo htmlspecialchars($thumbnail); ?>" class="card-img-top" height="150" style="object-fit: cover;" alt="Course Thumbnail">

        <!-- Card Body -->
        <div class="card-body" style=" display: flex; flex-direction: column; justify-content: space-between;">
            <!-- Course Title -->
            <h5 class="card-title <?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?>">
                <?php echo htmlspecialchars($title); ?>
            </h5>

            <!-- Course Description -->
            <p class="card-text" style="">
                <?php echo htmlspecialchars($description); ?>
            </p>

            <!-- View Course Button -->
            <div class="text-center">
                <a href="?details=<?php echo $id; ?>" class="btn <?php echo isset($_SESSION['isUserAdmin']) ? 'btn-danger' : 'btn-primary'; ?>">
                    View Course
                </a>
            </div>
        </div>
    </div>
</div>

        <?php } ?>
    </div>
</div>