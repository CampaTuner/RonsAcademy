<div class="container w-650 bg-white pt-5">
    <h1 class="my-3 text-danger text-center logo-text">
        Admin Login
        <img src="./assets/login.png" alt="user" width="40" height="40">
    </h1>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    
    <form action="./server/requests.php" method="post">
        <div class="mb-3">
            <label for="email" class="form-label text-danger">Email Address</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-danger">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="text-center d-flex flex-row justify-content-center align-items-center">
            <button type="submit" name="adminlogin" class="btn btn-danger mt-3 d-flex flex-row justify-content-center align-items-center gap-2 "> <span>Login as a Admin</span>
                <img src="./assets/right-arrow.png" alt="user" width="22" height="22">
            </button>
        </div>
    </form>
</div>