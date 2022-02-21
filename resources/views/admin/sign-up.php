<form method="post">
    <div class="form-floating mb-3">
        <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="<?= $_POST['name'] ?? '' ?>">
        <label for="name">Name</label>
    </div>
    <div class="form-floating mb-3">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="<?= $_POST['email'] ?? '' ?>">
        <label for="email">Email address</label>
    </div>
    <div class="form-floating mb-5">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
        <label for="password">Password</label>
    </div>
    <button class="w-100 btn btn-lg btn-primary mb-3" type="submit">Sign Up</button>
    <a href="<?= APP_URL . '/admin/sign-in' ?>">Back Sign In</a>
</form>