<?= loadPartial('header') ?>
<?= loadPartial('navbar-admin') ?>
<?= loadPartial('breadcrumb') ?>

<main id="add-product">
  <div class="container my-4">
    <form method="POST" action="/themobilehour/admin/product-management" enctype="multipart/form-data" id="form-product">
      <?php if (isset($errors)) : ?>
        <?php foreach ($errors as $error) : ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
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
                  <input type="text" name="sku" id="sku" class="form-control" value="<?= $product->sku ?? '' ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="title" class="col-2 col-form-label">Title</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="product_name" id="title" class="form-control" value="<?= $product->product_name ?? '' ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="category" class="col-2 col-form-label">Category</label>
                <div class="col-10 col-md-6">
                  <select name="category_id" id="category" class="form-select">
                    <option selected value="">Select a
                      Category</option>
                    <?php foreach ($categories as $category) : ?>
                      <?php if ($category->category_id === $product->category_id) : ?>
                        <option selected value="<?= $category->category_id ?>"><?= $category->category_name ?>
                        </option>
                      <?php else : ?>
                        <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label for="product_model" class="col-2 col-form-label">Model</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="product_model" id="product_model" class="form-control" value="<?= $product->product_model ?? '' ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="manufacturer" class="col-2 col-form-label">Manufacturer</label>
                <div class="col-10 col-md-6">
                  <input type="text" name="manufacturer" id="manufacturer" class="form-control" value="<?= $product->manufacturer ?? '' ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="list_price" class="col-2 col-form-label">List
                  Price</label>
                <div class="col-10 col-md-6">
                  <input type="number" name="list_price" id="list_price" class="form-control" step="0.01" value="<?= $product->list_price ?? 0 ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="discount" class="col-2 col-form-label">Discount</label>
                <div class="col-10 col-md-6">
                  <input type="number" name="disc_pct" id="discount" class="form-control" step="0.01" value="<?= $product->disc_pct ?? 0 ?>">
                </div>
              </div>
              <div class="row mb-3">
                <label for="stock" class="col-2 col-form-label">Stock</label>
                <div class="col-10 col-md-6">
                  <input type="number" name="stock_on_hand" id="stock" class="form-control" value="<?= $product->stock_on_hand ?? 0 ?>">
                </div>
              </div>
              <div class="row mb-3 form-check form-switch">
                <div class="col-10">
                  <label for="displayOnline" class="form-check-label">Display
                    Online</label>
                  <input type="checkbox" class="form-check-input" role="switch" id="displayOnline" name="is_active" value="1" <?= isset($product->is_active) && $product->is_active == 1 ? 'checked' : '' ?>>
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
              <textarea name="product_desc" id="description" rows="15" class="form-control">
              <?= $product->product_desc ?? '' ?>
              </textarea>
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
              <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#product-image-upload-form-modal">Select
                and upload images</button>
              <div class="modal fade" id="product-image-upload-form-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="product-image-upload-form-modal-label" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="product-image-upload-form-modal-label">
                        Select and upload
                        product images</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form method="POST" action="" enctype="multipart/form-data">
                        <label for="productImages" class="form-label">Upload
                          Multiple
                          Images</label>
                        <input class="form-control" type="file" id="productImages" multiple accept="image/*">
                        <button type="submit" class="btn btn-primary" id="btn-productImageUpload">Upload</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div> -->
              <table class="table" id="product-imagegallery-table">
                <thead>
                  <tr>
                    <th scope="col">Thumbnail
                    </th>
                    <th scope="col">File Name
                    </th>
                    <th scope="col">File Size
                    </th>
                    <th scope="col">Alt text
                    </th>
                    <th scope="col">Delete</th>
                  </tr>
                </thead>
                <!-- <tbody>
                  <tr>
                    <td><img src="uploads/images/IP15PRMX256NT.jpg" alt="" width="50" height="50"></td>
                    <td>file-name.jpg</td>
                    <td>120 KB</td>
                    <td><input type="text" name="img-alt" class="form-control">
                    </td>
                    <td><button type="button" class="btn btn-danger">Delete</button>
                    </td>
                  </tr>
                  <tr>
                    <td><img src="uploads/images/IP15PRMX256NT_2.jpg" alt="" width="50" height="50"></td>
                    <td>file-name.jpg</td>
                    <td>120 KB</td>
                    <td><input type="text" name="img-alt" class="form-control">
                    </td>
                    <td><button type="button" class="btn btn-danger">Delete</button>
                    </td>
                  </tr>
                </tbody> -->
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
                  <input type="number" name="weight" id="weight" class="form-control" step="0.001" value="<?= $product->weight ?>">
                </div>
                <div class="col">
                  <label for="dimensions" class="form-label">Dimensions</label>
                  <input type="text" name="dimensions" id="dimensions" class="form-control" value="<?= $product->dimensions ?? '' ?>">
                </div>
                <div class="col">
                  <label for="os" class="form-label">OS</label>
                  <input type="text" name="os" id="os" class="form-control" value="<?= $product->os ?? '' ?>">
                </div>
                <div class="col">
                  <label for="screensize" class="form-label">Screensize
                    (inches)</label>
                  <input type="number" name="screensize" id="screensize" class="form-control" step="0.01" value="<?= $product->screensize ?? '' ?>">
                </div>
                <div class="col">
                  <label for="resolution" class="form-label">Resolution
                    (Pixels)</label>
                  <input type="text" name="resolution" id="resolution" class="form-control" value="<?= $product->resolution ?? '' ?>">
                </div>
                <div class="col">
                  <label for="storage" class="form-label">Storage
                    (GB)</label>
                  <input type="number" name="storage" id="storage" class="form-control" step="0.01" value="<?= $product->storage ?? '' ?>">
                </div>
                <div class="col">
                  <label for="colour" class="form-label">Colour
                    (GB)</label>
                  <input type="text" name="colour" id="colour" class="form-control" value="<?= $product->colour ?? '' ?>">
                </div>
                <div class="col">
                  <label for="ram" class="form-label">RAM
                    (GB)</label>
                  <input type="number" name="ram" id="ram" class="form-control" step="0.01" value="<?= $product->ram ?? '' ?>">
                </div>
                <div class="col">
                  <label for="cpu" class="form-label">CPU
                  </label>
                  <input type="text" name="cpu" id="cpu" class="form-control" value="<?= $product->cpu ?? '' ?>">
                </div>
                <div class="col">
                  <label for="battery" class="form-label">Battery
                    (mAh)
                  </label>
                  <input type="number" name="battery" id="battery" class="form-control" step="0.01" value="<?= $product->battery ?>">
                </div>
                <div class="col">
                  <label for="rear-camera" class="form-label">Rear
                    Camera
                  </label>
                  <input type="text" name="rear_camera" id="rear_camera" class="form-control" value="<?= $product->rear_camera ?? '' ?>">
                </div>
                <div class="col">
                  <label for="front-camera" class="form-label">Front
                    Camera
                  </label>
                  <input type="text" name="front_camera" id="front_camera" class="form-control" value="<?= $product->front_camera ?? '' ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row justify-content-center my-5 action-buttons">
        <div class="col-6 d-flex justify-content-end">
          <!-- <input type="submit" value="Submit" name="submit" class="btn btn-primary w-25"> -->
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