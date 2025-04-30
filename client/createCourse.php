<div class="container w-650 bg-white p-4  rounded">
    <h1 class="my-3 text-danger text-center">Create New Course</h1>

    <!-- Error Message -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <form action="./server/requests.php" method="post" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="courseTitle" class="form-label text-danger">Course Title</label>
            <input type="text" class="form-control" name="title" id="courseTitle" >
        </div>

        <div class="mb-3">
            <label for="courseDesc" class="form-label text-danger">Course Description</label>
            <textarea class="form-control" name="description" id="courseDesc" rows="3" ></textarea>
        </div>

        <div class="mb-3">
            <label for="thumbnail" class="form-label text-danger">Course Thumbnail</label>
            <input class="form-control" type="file" name="thumbnail" id="thumbnail" accept="image/*" >
        </div>

        <div class="text-center">
            <img id="thumbnailPreview" src="" alt="Thumbnail Preview" class="d-none rounded shadow mt-2" width="200">
        </div>

        <div class="text-center mt-3 d-flex flex-row justify-content-center align-items-center">
            <button type="submit" name="createCourse" class="btn btn-danger mt-2 d-flex flex-row justify-content-center align-items-center gap-2">
                <span>Create Course</span>
                <img src="./assets/right-arrow.png" alt="arrow" width="22" height="22">
            </button>
        </div>
    </form>
</div>

<!-- JavaScript for Thumbnail Preview -->
<script>
document.getElementById('thumbnail').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('thumbnailPreview');
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});
</script>
