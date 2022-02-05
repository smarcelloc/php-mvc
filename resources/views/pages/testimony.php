<section class="row">
  <div class="col-12 mb-3">
    <h1>Testimonials</h1>
  </div>
  <div class="col-12 mb-5">
    <form method="get">
      <div class="input-group">
        <input value="<?= $_GET['search'] ?? '' ?>" type="text" class="form-control" name="search" placeholder="Search Testimonials ..." aria-label="Search Testimonials" aria-describedby="button-search">
        <?php if (isset($_GET['search'])) : ?>
          <a href="<?= APP_URL ?>/testimonials" class="btn btn-outline-danger">X</a>
        <?php endif ?>
        <button class="btn btn-secondary" type="submit" id="button-search">Search</button>
      </div>
    </form>
  </div>
  <div class="col-12 mb-3">
    <div class="row">
      <?php if (!empty($testimonials)) : ?>
        <?php include DIR_VIEW . '/components/testimony.php' ?>
      <?php else : ?>
        <p>No testimonials were found in our system.</p>
      <?php endif ?>
    </div>
  </div>
  <hr />
  <div class="col-12">
    <form method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" required class="form-control" id="name" name="name" />
      </div>
      <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</section>