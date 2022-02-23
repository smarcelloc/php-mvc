<a href="<?= APP_URL ?>/admin/testimonials/add" class="btn btn-success mb-5">Add testimonial</a>

<div class="col-12 mb-3">
    <form method="get">
        <div class="input-group">
            <input value="<?= $_GET['search'] ?? '' ?>" type="text" class="form-control" name="search" placeholder="Search Testimonials ..." aria-label="Search Testimonials" aria-describedby="button-search">
            <?php if (isset($_GET['search'])) : ?>
                <a href="<?= APP_URL ?>/admin/testimonials" class="btn btn-outline-danger">X</a>
            <?php endif ?>
            <button class="btn btn-secondary" type="submit" id="button-search">Search</button>
        </div>
    </form>
</div>

<?php if (!empty($testimonials)) : ?>
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Message</th>
                <th scope="col">Created</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($testimonials as $testimony) : ?>
                <tr>
                    <th scope="row"><?= $testimony['id'] ?></th>
                    <td><?= $testimony['name'] ?></td>
                    <td><?= $testimony['message'] ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($testimony['created_at'])) ?></td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="<?= APP_URL ?>/admin/testimonials/update/<?= $testimony['id'] ?>">Update</a>
                        <a class="btn btn-danger btn-sm" onclick="return confirm('Are you delete?')" href="<?= APP_URL ?>/admin/testimonials/delete/<?= $testimony['id'] ?>">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <?php include DIR_VIEW . '/components/pagination.php' ?>
<?php else : ?>
    <p>No testimonials were found in our system.</p>
<?php endif ?>