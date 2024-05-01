<?= loadPartial('header', [
  'pageTitle' => 'Edit Product ' . $product->sku
]) ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('pagetitle', ['pageTitle' => 'Edit Product ' . $product->sku]) ?>
<?= loadPartial('message') ?>
<?php
// push each product's not-null image paths to a new array
$imagePaths = [];

foreach ((array) $product as $key => $value) {
  if (strripos($key, 'imgpath') === 0 && !empty($value)) {
    $num = substr($key, -1);
    $imgpathKey = 'imgpath' . $num;
    $altKey = 'alt' . $num;
    $imagePaths[] = [
      'imgpath' => $value,
      'alt' => $product->$altKey
    ];
  }
}

?>

<main id="edit-product">
  <div class="container my-4">
    <form method="POST" action="<?= urlPath('admin/product-management/update/' . $product->product_id) ?>" enctype="multipart/form-data" id="product-edit-form" novalidate>
      <!-- <?php if (isset($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
          <?php if (!empty($error)) : ?>
            <div class="alert alert-danger" role="alert">
              <?= $error ?>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endif; ?> -->
      <div class="accordion" id="productAccordion">
        <div class="accordion-item">
          <div class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productMetaPanel" aria-expanded="true" aria-controls="productMetaPanel">
              <h2 class="fs-5">Product Meta</h2>
            </button>
          </div>
          <div id="productMetaPanel" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="row mb-3">
                <label for="sku" class="col-2 col-form-label">SKU</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="sku" id="sku" class="form-control <?= !empty($errors['sku']) ? 'is-invalid' : '' ?>" value="<?= $product->sku ?? '' ?>">
                  <div class="text-danger"><?= $errors['sku'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="title" class="col-2 col-form-label">Title</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="product_name" id="title" class="form-control <?= !empty($errors['product_name']) ? 'is-invalid' : '' ?>" value="<?= $product->product_name ?? '' ?>">
                  <div class="text-danger"><?= $errors['product_name'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="category" class="col-2 col-form-label">Category</label>
                <div class="col-10 col-md-6">
                  <select name="category_id" id="category" class="form-select <?= !empty($errors['category_id']) ? 'is-invalid' : '' ?>">
                    <option selected value="">Select a
                      Category</option>
                    <?php foreach ($categories as $category) : ?>
                      <?php if ($category->category_id == $product->category_id) : ?>
                        <option selected value="<?= $category->category_id ?>"><?= $category->category_name ?>
                        </option>
                      <?php else : ?>
                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                  <div class="text-danger"><?= $errors['category_id'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="product_model" class="col-2 col-form-label">Model</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="product_model" id="product_model" class="form-control <?= !empty($errors['product_model']) ? 'is-invalid' : '' ?>" value="<?= $product->product_model ?? '' ?>">
                  <div class="text-danger"><?= $errors['product_model'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="manufacturer" class="col-2 col-form-label">Manufacturer</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="manufacturer" id="manufacturer" class="form-control <?= !empty($errors['manufacturer']) ? 'is-invalid' : '' ?>" value="<?= $product->manufacturer ?? '' ?>">
                  <div class="text-danger"><?= $errors['manufacturer'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="list_price" class="col-2 col-form-label">List
                  Price</label>
                <div class="col-10 col-md-6">
                  <input type="number" name="list_price" id="list_price" class="form-control <?= !empty($errors['list_price']) ? 'is-invalid' : '' ?>" step="0.01" value="<?= $product->list_price ?? 0 ?>">
                  <div class="text-danger"><?= $errors['list_price'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="discount" class="col-2 col-form-label">Discount</label>
                <div class="col-10 col-md-6">
                  <input type="number" name="disc_pct" id="discount" class="form-control <?= !empty($errors['disc_pct']) ? 'is-invalid' : '' ?>" step="0.01" value="<?= $product->disc_pct ?? 0 ?>">
                  <div class="text-danger"><?= $errors['disc_pct'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3">
                <label for="stock" class="col-2 col-form-label">Stock</label>
                <div class="col-10 col-md-6">
                  <input type="number" name="stock_on_hand" id="stock" class="form-control <?= !empty($errors['stock_on_hand']) ? 'is-invalid' : '' ?>" value="<?= $product->stock_on_hand ?? 0 ?>">
                  <div class="text-danger"><?= $errors['stock_on_hand'] ?? '' ?></div>
                </div>
              </div>
              <div class="row mb-3 form-check form-switch">
                <div class="col-10">
                  <label for="displayOnline" class="form-check-label">Display
                    Online</label>
                  <input type="checkbox" class="form-check-input" role="switch" id="displayOnline" name="is_active" value="1" <?= (isset($product->product_is_active) && $product->product_is_active == 1) ? 'checked' : '' ?>>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <div class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productDescriptionPanel" aria-expanded="true" aria-controls="productDescriptionPanel">
              <h2 class="fs-5">Product
                Description</h2>
            </button>
          </div>
          <div id="productDescriptionPanel" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <label for="description" class="form-label">Product
                Description</label>
              <textarea name="product_desc" id="description" rows="15" class="quill-editor form-control <?= !empty($errors['product_desc']) ? 'is-invalid' : '' ?>"><?= $product->product_desc ?? '' ?></textarea>
              <div class="text-danger"><?= $errors['product_desc'] ?? '' ?></div>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <div class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productImagesPanel" aria-expanded="true" aria-controls="productImagesPanel">
              <h2 class="fs-5">Product
                Images</h2>
            </button>
          </div>
          <div id="productImagesPanel" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="input-group mb-3">
                <label class="input-group-text" for="product-image1">Image 1</label>
                <input type="file" name="imgpath1" id="product-image1" class="form-control <?= !empty($errors['imgpath1']) ? 'is-invalid' : '' ?>" accept="image/*" value="<?= basename($product->imgpath1) ?? '' ?>">
                <div class="text-danger"><?= $errors['imgpath1'] ?? '' ?></div>
                <label class="input-group-text" for="product-alt1">Alt-text</label>
                <input type="text" name="alt1" id="product-alt1" class="form-control <?= !empty($errors['alt1']) ? 'is-invalid' : '' ?>" value="<?= $product->alt1 ?? '' ?>">
                <div class="text-danger"><?= $errors['alt1'] ?? '' ?></div>
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="product-image2">Image 2</label>
                <input type="file" name="imgpath2" id="product-image2" class="form-control <?= !empty($errors['imgpath2']) ? 'is-invalid' : '' ?>" accept="image/*">
                <div class="text-danger"><?= $errors['imgpath2'] ?? '' ?></div>
                <label class="input-group-text" for="product-alt2">Alt-text</label>
                <input type="text" name="alt2" id="product-alt2" class="form-control <?= !empty($errors['alt2']) ? 'is-invalid' : '' ?>" value="<?= $product->alt2 ?? '' ?>">
                <div class="text-danger"><?= $errors['alt2'] ?? '' ?></div>
              </div>
              <div class="input-group mb-3">
                <label class="input-group-text" for="product-image3">Image 3</label>
                <input type="file" name="imgpath3" id="product-image3" class="form-control <?= !empty($errors['imgpath3']) ? 'is-invalid' : '' ?>" accept="image/*">
                <label class="input-group-text" for="product-alt3">Alt-text</label>
                <input type="text" name="alt3" id="product-alt3" class="form-control" value="<?= $product->alt3 ?? '' ?>">
                <div class="text-danger"><?= $errors['alt3'] ?? '' ?></div>
              </div>
              <table class="table" id="product-imagegallery-table">
                <thead>
                  <tr>
                    <th scope="col">Thumbnail
                    </th>
                    <th scope="col">File Name
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php if (!is_null($product->image_gallery_id) && count($imagePaths) > 0) : ?>
                    <?php foreach ($imagePaths as $key => $value) : ?>
                      <tr>
                        <td><img src="<?= assetPath($value['imgpath']) ?>" alt="<?= $value['alt'] ?>" width="50" height="auto"></td>
                        <td><?= basename(assetPath($value['imgpath'])) ?></td>
                      <?php endforeach; ?>
                      </tr>
                    <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <div class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#productFeaturesPanel" aria-expanded="true" aria-controls="productFeaturesPanel">
              <h2 class="fs-5">Product
                Features</h2>
            </button>
          </div>
          <div id="productFeaturesPanel" class="accordion-collapse collapse show">
            <div class="accordion-body">
              <div class="row row-cols-1 row-cols-md-2 g-3">
                <div class="col">
                  <label for="weight" class="form-label">Weight(kg)</label>
                  <input type="number" name="weight" id="weight" class="form-control <?= !empty($errors['weight']) ? 'is-invalid' : '' ?>" step="0.001" value="<?= $product->weight ?>">
                  <div class="text-danger"><?= $errors['weight'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="dimensions" class="form-label">Dimensions</label>
                  <input type="text" name="dimensions" id="dimensions" class="form-control <?= !empty($errors['dimensions']) ? 'is-invalid' : '' ?>" value="<?= $product->dimensions ?? '' ?>">
                  <div class="text-danger"><?= $errors['dimensions'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="os" class="form-label">OS</label>
                  <input type="text" name="os" id="os" class="form-control <?= !empty($errors['os']) ? 'is-invalid' : '' ?>" value="<?= $product->os ?? '' ?>">
                  <div class="text-danger"><?= $errors['os'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="screensize" class="form-label">Screensize
                    (inches)</label>
                  <input type="number" name="screensize" id="screensize" class="form-control <?= !empty($errors['screensize']) ? 'is-invalid' : '' ?>" step="0.01" value="<?= $product->screensize ?? '' ?>">
                  <div class="text-danger"><?= $errors['screensize'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="resolution" class="form-label">Resolution
                    (Pixels)</label>
                  <input type="text" name="resolution" id="resolution" class="form-control <?= !empty($errors['resolution']) ? 'is-invalid' : '' ?>" value="<?= $product->resolution ?? '' ?>">
                  <div class="text-danger"><?= $errors['resolution'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="storage" class="form-label">Storage
                    (GB)</label>
                  <input type="number" name="storage" id="storage" class="form-control <?= !empty($errors['storage']) ? 'is-invalid' : '' ?>" step="0.01" value="<?= $product->storage ?? '' ?>">
                  <div class="text-danger"><?= $errors['storage'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="colour" class="form-label">Colour
                    (GB)</label>
                  <input type="text" name="colour" id="colour" class="form-control <?= !empty($errors['colour']) ? 'is-invalid' : '' ?>" value="<?= $product->colour ?? '' ?>">
                  <div class="text-danger"><?= $errors['colour'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="ram" class="form-label">RAM
                    (GB)</label>
                  <input type="number" name="ram" id="ram" class="form-control <?= !empty($errors['ram']) ? 'is-invalid' : '' ?>" step="0.01" value="<?= $product->ram ?? '' ?>">
                  <div class="text-danger"><?= $errors['ram'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="cpu" class="form-label">CPU
                  </label>
                  <input type="text" name="cpu" id="cpu" class="form-control <?= !empty($errors['cpu']) ? 'is-invalid' : '' ?>" value="<?= $product->cpu ?? '' ?>">
                  <div class="text-danger"><?= $errors['cpu'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="battery" class="form-label">Battery
                    (mAh)
                  </label>
                  <input type="number" name="battery" id="battery" class="form-control <?= !empty($errors['battery']) ? 'is-invalid' : '' ?>" step="0.01" value="<?= $product->battery ?>">
                  <div class="text-danger"><?= $errors['battery'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="rear-camera" class="form-label">Rear
                    Camera
                  </label>
                  <input type="text" name="rear_camera" id="rear_camera" class="form-control <?= !empty($errors['rear_camera']) ? 'is-invalid' : '' ?>" value="<?= $product->rear_camera ?? '' ?>">
                  <div class="text-danger"><?= $errors['rear_camera'] ?? '' ?></div>
                </div>
                <div class="col">
                  <label for="front-camera" class="form-label">Front
                    Camera
                  </label>
                  <input type="text" name="front_camera" id="front_camera" class="form-control <?= !empty($errors['front_camera']) ? 'is-invalid' : '' ?>" value="<?= $product->front_camera ?? '' ?>">
                  <div class="text-danger"><?= $errors['front_camera'] ?? '' ?></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center my-5 action-buttons">
        <div class="col-6 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary w-25">Save</button>
        </div>
        <div class="col-6 d-flex justify-content-start">
          <a href="<?= assetPath("admin/product-management") ?>" class="btn btn-secondary w-25">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</main>

<?= loadPartial('footer') ?>