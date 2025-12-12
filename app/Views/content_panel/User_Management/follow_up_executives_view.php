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
							<h4 class="page-title">Follow-Up Executive</h4>
						</div>
						<div class="col-4 text-end">
							<div class="head-icons">
								<a href="<?= base_url('follow_up_executive'); ?>" data-bs-toggle="tooltip" data-bs-placement="top"
									data-bs-original-title="Refresh"><i class="ti ti-refresh-dot"></i></a>
								<a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top"
									data-bs-original-title="Collapse" id="collapse-header"><i
										class="ti ti-chevrons-up"></i></a>
							</div>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 p-2">
                                <div class="mb-3">
                                    <div class="icon-form mb-3 mb-sm-0">
                                        <h4>Select Admin</h4>
                                    </div>
                                </div>
                                <select class="form-control select2jsMultiSelect select2" onchange="category_redirect(this);">
                                    <option value="" selected disabled>Select Admin</option>
                                    <?php if($active_admin_data) { ?>
                                    <?php foreach($active_admin_data as $active_admin_det) { ?>
                                    <option value="<?php echo deccan_encode($active_admin_det['user_id']) ;?>"
                                    <?php if (isset($selected_parent_id) && $selected_parent_id == $active_admin_det['user_id'])
                                                {
                                                    echo 'selected';
                                                }
                                                ?>><?php echo $active_admin_det['user_name']; ?></option>
                                    <?php } }?>
                                </select>  
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($selected_parent_id)) { ?>
                        <div class="card-header">
                            <!-- Search -->
                            <div class="row align-items-center">
                                <div class="col-sm-4">
                                    <div class="icon-form mb-3 mb-sm-0">
                                        <h4>Follow-Up Executive</h4>
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div
                                        class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
                                                    
                                        <a href="javascript:void(0);" class="btn btn-primary"
                                            data-bs-toggle="offcanvas" data-bs-target="#createUserMode"><i
                                                class="ti ti-square-rounded-plus me-2"></i>Create Follow-Up Executive</a>
                                    </div>
                                </div>
                            </div>
                            <!-- /Search -->
                        </div>

                        <div class="card-body">

                            <!-- Manage Users List -->
                            <div class="table-responsive custom-table">
                                <table class="table bell_of_arms_table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="no-sort">S:NO</th>
                                            <th>Name</th>
                                            <th>Employee Code</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>DOB</th>
                                            <th>Identification 1</th>
                                            <th>Identification 2</th>
                                            <th>Date of Joining</th>
                                            <th>Address</th>
                                            <th>Status</th>
                                            <th>Active/Inactive</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (isset($follow_up_executive_data) && !empty($follow_up_executive_data)) {
                                            $i = 1; foreach ($follow_up_executive_data as $user_details) { ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <td>
                                                <h2 class="d-flex align-items-center">
                                                    <?php $profile_image = !empty($user_details['profile_image'])
                                                            && file_exists('assets/images/profile/'.$user_details['profile_image'])
                                                            ? $user_details['profile_image']
                                                            : 'profile_icon.png'; // your default image name
                                                        ?>
                                                        <a href="<?php echo base_url('assets/images/profile/'.$profile_image); ?>" target="_blank" class="avatar avatar-sm me-2">
                                                            <img class="w-auto h-auto" src="<?php echo base_url('assets/images/profile/'.$profile_image); ?>" alt="User Image">
                                                        </a>
                                                    <a href="#" class="d-flex flex-column">
                                                        <?php echo $user_details['user_name']; ?>
                                                        <span class="text-default"><?php echo $user_details['role_name']; ?></span>
                                                    </a>
                                                </h2>
                                            </td>
                                            <td><?php echo $user_details['employee_code']; ?></td>
                                            <td><?php echo $user_details['email_id']; ?></td>
                                            <td><?php echo $user_details['phone']; ?></td>
                                            <td><?php echo $user_details['dob']; ?></td>
                                            <td><?php echo $user_details['pan_card'] ? $user_details['pan_card'] : 'NA'; ?></td>
                                            <td><?php echo $user_details['aadhaar_card'] ? $user_details['aadhaar_card'] : 'NA'; ?></td>
                                            <td><?php echo $user_details['date_of_joining']; ?></td>
                                            <td><?php echo $user_details['address']; ?></td>
                                            <td>
                                                <?php if($user_details['status'] === "Active") { ?>
                                                    <span class="badge badge-pill badge-status bg-success"><?php echo $user_details['status']; ?></span>
                                                <?php } elseif($user_details['status'] === 'Inactive') { ?>
                                                    <span class="badge badge-pill badge-status bg-danger"><?php echo $user_details['status']; ?></span>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <?php if($user_details['status'] === "Active") { ?>
                                                    <a type="button" class="status_change btn btn-primary"
                                                            data_id="<?php echo deccan_encode($user_details['user_id']); ?>"
                                                            data_url="<?php echo base_url('ajax_get_user_status_details/'.deccan_encode(INACTIVE)); ?>"
                                                            data-bs-toggle="modal" data-bs-target="#userStatusChange">Inactive</a>
                                                <?php } elseif($user_details['status'] === 'Inactive') { ?>
                                                    <a type="button" class="status_change btn btn-success"
                                                            data_id="<?php echo deccan_encode($user_details['user_id']); ?>"
                                                            data_url="<?php echo base_url('ajax_get_user_status_details/'.deccan_encode(ACTIVE)); ?>"
                                                            data-bs-toggle="modal" data-bs-target="#userStatusChange">Active</a>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <div class="dropdown table-action">
                                                    <a href="#" class="action-icon" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="edit_value dropdown-item" type="button"
                                                            data_id="<?php echo deccan_encode($user_details['user_id']); ?>"
                                                            data_url="<?php echo base_url('ajax_get_edit_follow_up_executive_details'); ?>"
                                                            data-bs-toggle="offcanvas" data-bs-target="#editUserModel"><i class="ti ti-edit text-blue"></i> Edit</a>
                                                        <a class="delete_value dropdown-item" type="button"
                                                            data_id="<?php echo deccan_encode($user_details['user_id']); ?>"
                                                            data_url="<?php echo base_url('ajax_get_delete_user_details'); ?>"
                                                            data-bs-toggle="modal" data-bs-target="#delete_user">
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
                        <?php } ?>
						<!-- /Manage Users List -->
					</div>
				</div>

			</div>
		</div>

	</div>
</div>
<!-- /Page Wrapper -->

<!-- Add User -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="createUserMode">
	<div class="offcanvas-header border-bottom">
		<h5 class="fw-semibold">Create New Inside Sales Executive</h5>
		<button type="button"
			class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
			data-bs-dismiss="offcanvas" aria-label="Close">
			<i class="ti ti-x"></i>
		</button>
	</div>
	<div class="offcanvas-body">
		<form id="generic_form" action="<?php echo base_url('ajax_add_follow_up_executive'); ?>" method="post">
			<div>
                <!-- Basic Info -->
                <div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-pic-upload">
                                <div class="profile-pic" id="previewContainer">
                                    <img id="previewImage" src="" alt="" style="display:none; width:100px; height:100px; object-fit:cover; border-radius:8px;">
                                    <span id="defaultIconAdd"><i class="ti ti-photo"></i></span>
                                </div>
                                <div class="upload-content">
                                    <div class="upload-btn">
                                        <input type="file" name="profile_image" id="profileImageInput" accept="image/*">
                                        <span><i class="ti ti-file-broken"></i>Upload Profile Pic</span>
                                    </div>
                                    <p>JPG, PNG. Max size of 1MB</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">User Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="user_name">
                                <input type="hidden" class="form-control" name="parent_id" value="<?= isset($selected_parent_id) && !empty($selected_parent_id) ? deccan_encode($selected_parent_id) : '' ?>">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email_id">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Password <span class="text-danger">*</span></label>
                                <div class="icon-form-end">
                                    <span class="form-icon" id="togglePassword" style="cursor:pointer;">
                                        <i class="ti ti-eye-off" id="toggleIcon"></i>
                                    </span>
                                    <input type="password" class="form-control" name="password" id="passwordField">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="phone">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">DOB <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="dob">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">Date of joining <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date_of_joining">
                            </div>
                        </div>

                        <!-- PAN & Aadhar Images -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">PANCARD</label>
                                <input type="text" class="form-control" name="pan_card">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Upload Pancard Image</label>
                                <input type="file" class="form-control" name="pan_image" accept="image/*">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="col-form-label">AADHAAR CARD</label>
                                <input type="text" class="form-control" name="aadhaar_card">
                            </div>
                            <div class="mb-3">
                                <label class="col-form-label">Upload Aadhaar Image</label>
                                <input type="file" class="form-control" name="aadhaar_image" accept="image/*">
                            </div>
                        </div>

                        <!-- Agreement Upload -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Upload Agreement</label>
                                <input type="file" class="form-control" name="agreement_file" accept="application/pdf,image/*">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                <textarea class="form-control" name="address"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bank Details Section -->
                <hr>
                <h5 class="fw-semibold mb-3">Bank Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Bank Account Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bank_account_number">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">IFSC Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="ifsc_code">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Bank Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bank_name">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="col-form-label">Branch Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="branch_name">
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="col-form-label">Upload Bank Passbook Image <span class="text-danger">*</span></label>
                            <input type="file" class="form-control" name="bank_passbook_image" accept="image/*">
                        </div>
                    </div>
                </div>
            </div>
			<div class="d-flex align-items-center justify-content-end">
				<a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
				<button type="submit" class="btn btn-primary">Create</button>
			</div>
		</form>
	</div>

</div>
<!-- /Add User -->

<!-- Edit User -->
<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="editUserModel">
	<div class="offcanvas-header border-bottom">
		<h5 class="fw-semibold">Edit User</h5>
		<button type="button"
			class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
			data-bs-dismiss="offcanvas" aria-label="Close">
			<i class="ti ti-x"></i>
		</button>
	</div>
	<div class="offcanvas-body">
		<form id="generic_form" action="<?php echo base_url('ajax_update_follow_up_executive') ?>" method="post">
			<div>
				<!-- Basic Info -->
				<div id="row">
					<div class="col-md-12">
						<div class="profile-pic-upload">
							<div class="profile-pic" id="previewContainer">
								<img id="previewEditImage" src="" alt="" style="display:none; width:100px; height:100px; object-fit:cover; border-radius:8px;">
								<span id="defaultIconEdit"><i class="ti ti-photo"></i></span>
							</div>
							<div class="upload-content">
								<div class="upload-btn">
									<input type="file" name="profile_image" id="profileEditImageInput" accept="image/*">
									<span>
										<i class="ti ti-file-broken"></i>Upload Profile Pic
									</span>
								</div>
								<p>JPG, PNG. Max size of 1MB</p>
							</div>
						</div>
					</div>
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

<!-- Delete User -->
<div class="modal fade" id="delete_user" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="generic_form" action="<?php echo base_url('ajax_delete_user'); ?>" method="post">
				<div class="modal-body" id="delete_body">
					
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Delete User -->

<!-- Delete User -->
<div class="modal fade" id="userStatusChange" role="dialog">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<form id="generic_form" action="<?php echo base_url('ajax_status_update_user'); ?>" method="post">
				<div class="modal-body" id="status_body">
					
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Delete User -->
		 
<script>
// Common file preview function
function handleImagePreview(inputId, previewId, iconId, removeBtnId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const icon = document.getElementById(iconId);
    const removeBtn = document.getElementById(removeBtnId);

    input.addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            icon.style.display = "none";
            if (removeBtn) removeBtn.style.display = "inline-block";
        };
        reader.readAsDataURL(file);
    });

    if (removeBtn) {
        removeBtn.addEventListener("click", function() {
            preview.src = "";
            preview.style.display = "none";
            icon.style.display = "block";
            input.value = ""; // clear input
            removeBtn.style.display = "none";
        });
    }
}

// For ADD
handleImagePreview("profileImageInput", "previewImage", "defaultIconAdd", "removeImageBtn");

// For EDIT
handleImagePreview("profileEditImageInput", "previewEditImage", "defaultIconEdit", "removeEditImageBtn");


document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('passwordField');
    const icon = document.getElementById('toggleIcon');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        icon.classList.remove('ti-eye-off');
        icon.classList.add('ti-eye');
    } else {
        passwordField.type = "password";
        icon.classList.remove('ti-eye');
        icon.classList.add('ti-eye-off');
    }
});
</script>
