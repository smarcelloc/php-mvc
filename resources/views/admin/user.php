<?php

if (empty($_POST)) {
    $_POST = $user;
}
?>

<div class="col-12">
    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" required class="form-control" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" />
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Your Email</label>
            <input type="email" required class="form-control" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" />
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Your Password</label>
            <input type="password" class="form-control" id="password" name="password" />
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>