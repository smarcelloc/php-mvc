<?php

if (empty($_POST) && isset($testimony['id'])) {
    $_POST = $testimony;
}
?>


<div class="col-12">
    <form method="post">
        <?php if (isset($testimony['id'])) : ?>
            <input type="hidden" name="id" value="<?= $testimony['id'] ?>" />
        <?php endif ?>
        <div class="mb-3">
            <label for="name" class="form-label">Your Name</label>
            <input type="text" required class="form-control" id="name" name="name" value="<?= $_POST['name'] ?? '' ?>" />
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" required><?= $_POST['message'] ?? '' ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>