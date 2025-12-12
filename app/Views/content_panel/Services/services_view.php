<!-- Page Wrapper -->
<div class="page-wrapper">
    <div class="content">
        <?= $this->include('nav/flash_message_view') ?>

        <div class="row">
            <div class="col-md-12">

                <!-- Page Header -->
                <div class="page-header">
                    <div class="row align-items-center">
                        <div class="col-8">
                            <h4 class="page-title">Services</h4>
                        </div>
                        <div class="col-4 text-end">
                            <div class="head-icons">
                                <a href="<?= base_url('services'); ?>" data-bs-toggle="tooltip" title="Refresh">
                                    <i class="ti ti-refresh-dot"></i>
                                </a>
                                <a href="javascript:void(0);" id="collapse-header" data-bs-toggle="tooltip" title="Collapse">
                                    <i class="ti ti-chevrons-up"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Page Header -->

                <div class="card">
                    <div class="card-header">

                        <!-- Search -->
                        <div class="row align-items-center">
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
                        <!-- /Search -->
                    </div>

                    <div class="card-body">

                        <!-- Table List -->
                        <div class="table-responsive custom-table">
                            <table class="table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>S.NO</th>
                                        <th>Service Name</th>
                                        <th>Created On</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (!empty($services)) { 
                                        $i = 1;
                                        foreach ($services as $row) { ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $row['service_name']; ?></td>
                                            <td><?= $row['created_on']; ?></td>

                                            	<td>
											<div class="dropdown table-action">
												<a href="#" class="action-icon" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
												<div class="dropdown-menu dropdown-menu-right">
													<a class="edit_value dropdown-item" type="button"
														data_id="<?php echo deccan_encode($row['service_id']); ?>"
                                                        data_url="<?php echo base_url('ajax_edit_service'); ?>"
														 data-bs-toggle="offcanvas" data-bs-target="#editSuperAdminModel"><i class="ti ti-edit text-blue"></i> Edit</a>
													<a class="delete-button dropdown-item" 
                                                         data-id="<?php echo deccan_encode($row['service_id']); ?>"
                                                        href="#"
                                                         data-bs-toggle="modal" data-bs-target="#delete_data">
                                                            <i class="ti ti-trash text-danger"></i>
                                                                Delete
													</a>
												</div>
											</div>
										</td>
                                        </tr>
                                    <?php } } ?>
                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
<!-- /Page Wrapper -->



<!-- ADD SERVICE -->
<div class="offcanvas offcanvas-end offcanvas-small" tabindex="-1" id="addServiceOffcanvas">
    <div class="offcanvas-header border-bottom">
        <h5 class="fw-semibold">Add Service</h5>
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">
        <form id="generic_form" action="<?= base_url('ajax_add_service'); ?>" method="post">

            <div class="mb-3">
                <label class="form-label">Service Name <span class="text-danger">*</span></label>
                <input type="text" name="service_name" class="form-control">
            </div>

            <div class="text-end">
                <button class="btn btn-light" data-bs-dismiss="offcanvas">Cancel</button>
                <button class="btn btn-primary" type="submit">Create</button>
            </div>

        </form>
    </div>
</div>



<!-- Edit User -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="editSuperAdminModel">
	<div class="offcanvas-header border-bottom">
		<h5 class="fw-semibold">Edit Super Admin</h5>
		<button type="button"
			class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
			data-bs-dismiss="offcanvas" aria-label="Close">
			<i class="ti ti-x"></i>
		</button>
	</div>
	<div class="offcanvas-body">
		<form id="generic_form" action="<?php echo base_url('ajax_update_service') ?>" method="post">
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



<!-- DELETE SERVICE -->
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
						<a href="<?php echo base_url('ajax_delete_service') ?>" data_value="" class="btn btn-danger ms-2 common_delete">Delete</a>
					</div>
					<br>
				</div>

        </div>
    </div>
</div>



