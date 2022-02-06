<?php if (isset($pagination)) : ?>

  <?php $currentPage = $_GET['page'] ?? 1 ?>
  <?php $lastPage = count($pagination); ?>

  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item <?= $currentPage == 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="#">Previous</a>
      </li>
      <?php foreach ($pagination as $paginate) : ?>
        <li class="page-item <?= $paginate['current'] ? 'active' : '' ?>">
          <a class="page-link" href=""><?= $paginate['page'] ?></a>
        </li>
      <?php endforeach ?>
      <li class="page-item <?= $lastPage <= $currentPage ? 'disabled' : '' ?>">
        <a class="page-link" href="#">Next</a>
      </li>
    </ul>
  </nav>

<?php endif ?>