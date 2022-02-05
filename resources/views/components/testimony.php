<?php foreach ($testimonials as $testimony) : ?>

  <div class="col-sm-6 mb-3">
    <div class="card">
      <div class="card-header">
        <div class="d-flex align-items-center justify-content-between">
          <h5 class="card-title m-0"><?= $testimony['name'] ?></h5>
          <a href="<?= APP_URL ?>/testimonials/delete/<?= $testimony['id'] ?>" class="btn-close" aria-label="Close"></a>
        </div>
      </div>
      <div class="card-body">
        <p class="card-text"><?= $testimony['message'] ?></p>
        <p class="card-text">
          <small class="text-muted"><?= date('D, d M Y H:i', strtotime($testimony['created_at'])) ?></small>
        </p>
      </div>
    </div>
  </div>

<?php endforeach ?>