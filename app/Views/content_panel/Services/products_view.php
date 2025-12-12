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
              <div class="col-md-12">
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
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php if (!empty($selected_service_id)) { ?>
   <div class="row align-items-center mb-4">
                            <div class="col-sm-4">
                                <div class="icon-form mb-3 mb-sm-0">
                                    <span class="form-icon"><i class="ti ti-search"></i></span>
                                    <input type="text" id="serviceSearch" class="form-control" placeholder="Search Service">
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="d-flex justify-content-sm-end align-items-center flex-wrap row-gap-2">
                                    <a href="javascript:void(0);" class="btn btn-primary"
                                       data-bs-toggle="offcanvas"
                                       data-bs-target="#addServiceOffcanvas">
                                        <i class="ti ti-square-rounded-plus me-2"></i>Add Service
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
                    <th>Product Name</th>
                    
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>

                  <?php $i=1; foreach($products as $product) { ?>
                    <tr>
                      <td><?php echo $i++; ?></td>
                      <td><?php echo $product['product_name']; ?></td>

                      <!-- STATUS -->
                     

                      <!-- ACTION -->
                     
                                            	<td>
											<div class="dropdown table-action">
												<a href="#" class="action-icon" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="edit_value dropdown-item" type="button"
														data_id="<?php echo deccan_encode($product['product_id']); ?>"
                                                        data_url="<?php echo base_url('ajax_edit_product'); ?>"
														 data-bs-toggle="offcanvas" data-bs-target="#edit_data"><i class="ti ti-edit text-blue"></i> Edit</a>
													<a class="delete-button dropdown-item" 
                                                         data-id="<?php echo deccan_encode($product['product_id']); ?>"
                                                        href="#"
                                                         data-bs-toggle="modal" data-bs-target="#delete_data">
                                                            <i class="ti ti-trash text-danger"></i>
                                                                Delete
													</a>
													<a class="dropdown-item" data-id="<?php echo deccan_encode($product['product_id']); ?>"
                                                        href="<?php echo base_url('items/'.deccan_encode($product['product_id']));?>"
                                                         >
                                                        <i class="ti ti-arrow-right text-danger"></i>
                                                                Items
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
<!-- ADD SERVICE -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="addServiceOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Add Product</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="generic_form" method="POST" action="<?php echo base_url('ajax_add_product'); ?>">
        

        <div class="modal-body">

          <div class="form-group">
            <label>Product Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="product_name" required>
          </div>

          <input type="hidden" name="service_id" value="<?php echo isset($selected_service_id) ? $selected_service_id : ''; ?>">

        </div>

        <div class="submit-section">
          <button class="btn btn-primary submit-btn">Submit</button>
        </div>

      </form>
    </div>
</div>

<!-- ADD PRODUCT MODAL -->
<!-- Edit User -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="edit_data">
	<div class="offcanvas-header border-bottom">
		<h5 class="fw-semibold">Edit Product</h5>
		<button type="button"
			class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
			data-bs-dismiss="offcanvas" aria-label="Close">
			<i class="ti ti-x"></i>
		</button>
	</div>
	<div class="offcanvas-body">
		<form id="generic_form" action="<?php echo base_url('ajax_update_product') ?>" method="post">
			<div>
				<!-- Basic Info -->
				<div id="row">
					
					<div id="edit_body">
						
					</div>
				</div>
				<!-- /Basic Info -->
			</div>
			<div class="d-flex align-items-center justify-content-end">
				<a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
				<button type="submit" class="btn btn-primary">Update</button>
			</div>
		</form>
	</div>

</div>
<!-- /Edit User -->


<!-- DELETE MODAL -->
<div class="modal fade" id="delete_data">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="text-center">
					<div class="avatar avatar-xl bg-danger-light rounded-circle mb-3">
						<i class="ti ti-trash-x fs-36 text-danger"></i>
					</div>
					<h4 class="mb-2">Delete?</h4>
					<p class="mb-0">Are you sure you want to Delete?</p>
                    
					<div class="d-flex align-items-center justify-content-center mt-4">
						<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
						 <a href="<?php echo base_url('ajax_delete_product'); ?>" data_value="" class="btn btn-danger common_delete">Delete</a>
					</div>
					<br>
				</div>

        </div>
    </div>
</div>



