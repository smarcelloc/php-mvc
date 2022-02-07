<?php if (isset($pagination)) : ?>

  <nav aria-label="Page navigation example">
    <ul class="pagination justify-content-center">
      <li class="page-item <?= $pagination->getCurrentPage() == 1 ? 'disabled' : '' ?>">
        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination->getCurrentPage() - 1])) ?>">
          Previous
        </a>
      </li>

      <?php foreach ($pagination->getPages() as $paginate) : ?>
        <li class="page-item <?= $paginate['current'] ? 'active' : '' ?>">
          <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $paginate['page']])) ?>">
            <?= $paginate['page'] ?>
          </a>
        </li>
      <?php endforeach ?>

      <li class="page-item <?= $pagination->getTotalPage() <= $pagination->getCurrentPage() ? 'disabled' : '' ?>">
        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $pagination->getCurrentPage() + 1])) ?>">
          Next
        </a>
      </li>
    </ul>
  </nav>

<?php endif ?>