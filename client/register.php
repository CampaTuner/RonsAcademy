<div class="container w-650 bg-white">
    <h1 class="my-3 text-primary text-center logo-text">
        <img src="./assets/user.png" alt="user" width="40" height="40">
        Register User
    </h1>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
        </div>
    <?php endif; ?>
    
    <form action="./server/requests.php" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="username" class="form-label text-primary">User Name</label>
            <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label text-primary">Email Address</label>
            <input type="email" class="form-control" name="email" id="email">
        </div>

        <div class="mb-3">
            <label for="password" class="form-label text-primary">Password</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>

        <div class="mb-3">
            <label for="formFile" class="form-label text-primary">Profile Picture</label>
            <input class="form-control" type="file" name="avatar" id="formFile">
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="terms" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">I agree to the <span class="text-primary">Rounak's Academy</span> Terms and Condition.</label>
        </div>


        <div class="text-center d-flex flex-row justify-content-center align-items-center">
            <button type="submit" name="register" class="btn btn-primary mt-3 d-flex flex-row justify-content-center align-items-center gap-2 "> <span>Register as a New User</span>
                <img src="./assets/right-arrow.png" alt="user" width="22" height="22">
            </button>
        </div>
    </form>
</div>