<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/websites/RonsAcademy/">
            <img src="./assets/logo.png" alt="" width="30" height="30">
            <span class="<?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?> logo-text">Rounak's Academy</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/websites/RonsAcademy/">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Courses</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active <?php echo isset($_SESSION['isUserAdmin']) ? 'text-danger' : 'text-primary'; ?>" aria-current="page"><?php echo isset($_SESSION['isUserAdmin']) ? ucfirst($_SESSION['username']) . "(Admin)" : ucfirst($_SESSION['username']) ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active text-primary" aria-current="page" href="?login">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active text-primary" aria-current="page" href="?register=true">Register</a>
                    </li>
                <?php endif; ?>

                <li class="nav-item dropdown d-flex align-items-center">
                    <?php if (isset($_SESSION['avatar'])): ?>
                        <img src='<?php echo './server/uploads/' . $_SESSION['avatar']; ?>'
                            alt="User Avatar"
                            width="35"
                            height="35"
                            class="rounded-circle border border-2 <?php echo isset($_SESSION['isUserAdmin']) ? 'border-danger' : 'border-primary'; ?> shadow-sm me-">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Account
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">My Account</a></li>
                            <?php if (!isset($_SESSION['isUserAdmin'])): ?>
                                <li><a class="dropdown-item" href="?adminlogin=true">Admin Login</a></li>
                            <?php endif; ?>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <?php if (isset($_SESSION['isUserAdmin'])): ?>
                                    <a class="dropdown-item text-danger" href="./server/requests.php?logout=true">Admin Logout</a>
                                <?php else : ?>
                                    <a class="dropdown-item text-danger" href="./server/requests.php?logout=true">Logout</a>
                                <?php endif; ?>

                            </li>

                        </ul>
                    <?php endif ?>
                </li>

                <?php if (isset($_SESSION['isUserAdmin'])): ?>
                    <li class="nav-item">
                        <a class="nav-link active text-danger" aria-current="page" href="?create=true">Create couses</a>
                    </li>
                <?php endif; ?>

            </ul>
            <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Search Courses. . ." aria-label="Search">
                <button class="btn <?php echo isset($_SESSION['isUserAdmin']) ? 'btn-outline-danger' : 'btn-outline-primary'; ?>" type="submit">Search</button>
            </form>
        </div>
    </div>
</nav>