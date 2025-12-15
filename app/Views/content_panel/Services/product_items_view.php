<div class="page-wrapper" style="min-height: 523px;">
  <div class="content container-fluid">
<?= $this->include('nav/flash_message_view') ?>
    <div class="page-header mt-5">
      <div class="row">
        <div class="col">
          <h3 class="page-title">Products</h3>
        </div>
      </div>
    </div>

    <!-- SERVICES DROPDOWN -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Select Service</h4>
          </div>
          <div class="card-body">
            <div class="form-group row">
              <div class="col-md-6">
                <select class="form-control" onchange="category_redirect(this);">
                  <option value="-1">-- select service --</option>
                  <?php foreach($services as $service) { ?>
                    <option value="<?php echo deccan_encode($service['service_id']); ?>"
                      <?php if(isset($selected_service_id) && $selected_service_id == $service['service_id']) { echo 'selected'; } ?>>
                      <?php echo $service['service_name']; ?>
                    </option>
                  <?php } ?>
                </select>
              </div>
               <?php if(!empty($selected_service_id)) { ?>
              <div class="col-md-6">
                  <select class="form-control" onchange="product_redirect(this);">
                  <option value="">-- select Product --</option>
                  <?php foreach($products as $product) { ?>
                  <option value="<?php echo deccan_encode($product['product_id']); ?>"
                    <?php if(isset($selected_product_id) && $selected_product_id == $product['product_id']) { echo 'selected'; } ?>>
                    <?php echo $product['product_name']; ?>
                  </option>
                  <?php } ?>
                </select>  
              </div>
              <?php }?>
            </div>
          </div>
        </div>
      </div>
    </div>

   <?php if (!empty($selected_product_id)) { ?>
   <div class="row align-items-center mb-4">
                            <div class="col-sm-4">
                                <div class="icon-form mb-3 mb-sm-0">
                                    <span class="form-icon"><i class="ti ti-search"></i></span>
                                    <input type="text" id="serviceSearch" class="form-control" placeholder="Search ">
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="d-flex justify-content-sm-end align-items-center flex-wrap row-gap-2">
                                    <a href="javascript:void(0);" class="btn btn-primary"
                                       data-bs-toggle="offcanvas"
                                       data-bs-target="#addItemOffcanvas">
                                        <i class="ti ti-square-rounded-plus me-2"></i>Add Item
                                    </a>
                                </div>
                            </div>
                        </div>
    <!-- Add Button -->
    <div class="row">
      
      <br>                    

      <!-- Product Table -->
      <div class="col-sm-12">
        <div class="card mb-0">
          <div class="card-body">
            <div class="table-responsive">
            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Item Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php $i=1; foreach($items as $item) { ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td><?php echo $item['item_name']; ?></td>

                                        <td>
                                            <div class="dropdown table-action">
                                                <a href="#" class="action-icon" data-bs-toggle="dropdown">
                                                    <i class="fa fa-ellipsis-v"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">

                                                    <!-- EDIT -->
                                                    <a class="edit_value dropdown-item"
                                                       type="button"
                                                       data_id="<?php echo deccan_encode($item['item_id']); ?>"
                                                       data_url="<?php echo base_url('ajax_edit_item'); ?>"
                                                       data-bs-toggle="offcanvas" 
                                                       data-bs-target="#editItemCanvas">
                                                        <i class="ti ti-edit text-blue"></i> Edit
                                                    </a>

                                                    <!-- DELETE -->
                                                    <a class="delete-button dropdown-item"
                                                       data-id="<?php echo deccan_encode($item['item_id']); ?>"
                                                       href="#"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteItemModal">
                                                        <i class="ti ti-trash text-danger"></i> Delete
                                                    </a>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    <?php } ?>

                                </tbody>
                            </table>
            </div>
          </div>
        </div>
      </div>

    </div>

    <?php } ?>

  </div>
</div>
<!-- ADD ITEM OFFCANVAS -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="addItemOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Add Item</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="generic_form" method="POST" action="<?php echo base_url('ajax_add_item'); ?>">

            <div class="modal-body">

                <div class="form-group">
                    <label>Item Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="item_name" required>
                </div>

                <input type="hidden" name="product_id"
                    value="<?php echo isset($selected_product_id) ? $selected_product_id : ''; ?>">

            </div>

            <div class="submit-section">
                <button class="btn btn-primary submit-btn">Submit</button>
            </div>

        </form>
    </div>
</div>

<!-- EDIT ITEM OFFCANVAS -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="editItemCanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Edit Item</h5>
        <button type="button" class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle" data-bs-dismiss="offcanvas">
            <i class="ti ti-x"></i>
        </button>
    </div>

    <div class="offcanvas-body">
        <form id="generic_form" action="<?php echo base_url('ajax_update_item'); ?>" method="post">
            <div id="row">
                <div id="edit_body">
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-end">
                <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
                <button type="submit" class="btn btn-primary">Update</button>
            </div>

        </form>
    </div>
</div>

<!-- DELETE MODAL -->
<div class="modal fade" id="deleteItemModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="text-center">
                <div class="avatar avatar-xl bg-danger-light rounded-circle mb-3">
                    <i class="ti ti-trash-x fs-36 text-danger"></i>
                </div>
                <h4 class="mb-2">Delete?</h4>
                <p class="mb-0">Are you sure you want to delete this item?</p>

                <div class="d-flex align-items-center justify-content-center mt-4">
                    <a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
                    <a href="<?php echo base_url('ajax_delete_item'); ?>"
                       data_value=""
                       class="btn btn-danger common_delete">Delete</a>
                </div>
                <br>
            </div>

        </div>
    </div>
</div>




