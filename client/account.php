<div class="container py-5">
    <h3 class="mb-4 text-primary">Account Settings</h3>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= $_SESSION['success']; unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php elseif (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- Update Username -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Update Username</h5>
                    <form action="./server/requests.php" method="POST">
                        <input type="hidden" name="action" value="update_username">
                        <input type="text" class="form-control mb-2" name="new_username" placeholder="New Username" required>
                        <button type="submit" class="btn btn-primary">Update Username</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Update Email -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Update Email</h5>
                    <form action="./server/requests.php" method="POST">
                        <input type="hidden" name="action" value="update_email">
                        <input type="email" class="form-control mb-2" name="new_email" placeholder="New Email" required>
                        <button type="submit" class="btn btn-primary">Update Email</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Change Password</h5>
                    <form action="./server/requests.php" method="POST">
                        <input type="hidden" name="action" value="update_password">
                        <input type="password" class="form-control mb-2" name="current_password" placeholder="Current Password" required>
                        <input type="password" class="form-control mb-2" name="new_password" placeholder="New Password" required>
                        <button type="submit" class="btn btn-warning">Change Password</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="col-md-6">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    <h5 class="card-title text-danger">Delete Account</h5>
                    <form action="./server/requests.php" method="POST" onsubmit="return confirm('Are you sure you want to delete your account?');">
                        <input type="hidden" name="action" value="delete_account">
                        <button type="submit" class="btn btn-danger">Delete My Account</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
