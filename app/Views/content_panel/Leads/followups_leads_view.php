<!-- Page Wrapper -->
		<div class="page-wrapper">
			<div class="content">

				<div class="row">
					<div class="col-md-12">

						<!-- Page Header -->
						<div class="page-header">
							<div class="row align-items-center">
								<div class="col-8">
									<h4 class="page-title">Leads</h4>
								</div>
								<div class="col-4 text-end">
									<div class="head-icons">
										<a href="manage-users.html" data-bs-toggle="tooltip" data-bs-placement="top"
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

							<div class="card-header">
								<!-- Search -->
								<div class="row align-items-center">
									<div class="col-sm-4">
										<div class="icon-form mb-3 mb-sm-0">
											<span class="form-icon"><i class="ti ti-search"></i></span>
											<input type="text" class="form-control" placeholder="Search Lead">
										</div>
									</div>
									<div class="col-sm-8">
										<div
											class="d-flex align-items-center flex-wrap row-gap-2 justify-content-sm-end">
											<div class="dropdown me-2">
												<a href="javascript:void(0);" class="dropdown-toggle"
													data-bs-toggle="dropdown"><i
														class="ti ti-package-export me-2"></i>Export</a>
												<div class="dropdown-menu  dropdown-menu-end">
													<ul>
														<li>
															<a href="javascript:void(0);" class="dropdown-item"><i
																	class="ti ti-file-type-pdf text-danger me-1"></i>Export
																as PDF</a>
														</li>
														<li>
															<a href="javascript:void(0);" class="dropdown-item"><i
																	class="ti ti-file-type-xls text-green me-1"></i>Export
																as Excel </a>
														</li>
													</ul>
												</div>
											</div>
											<!-- <a href="javascript:void(0);" class="btn btn-primary"
												data-bs-toggle="offcanvas" data-bs-target="#offcanvas_add"><i
													class="ti ti-square-rounded-plus me-2"></i>Create Leads</a> -->
										</div>
									</div>
								</div>
								<!-- /Search -->
							</div>

							<div class="card-body">

								<!-- Manage Users List -->
								<div class="table-responsive custom-table">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Lead Name</th>
                                                <th>Phone</th>
                                                <th>Source</th>
                                                <th>Lead Status</th>
                                                <th>Last Follow-Up</th>
                                                <th>Next Follow-Up</th>
                                                <th>Priority</th>
                                                <th class="text-end">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <!-- Row 1 - Earliest Follow-Up -->
                                            <tr>
                                                <td>1</td>
                                                <td>Darlee Robertson</td>
                                                <td>1234567890</td>
                                                <td>Google</td>
                                                <td><span class="badge bg-primary">Active</span></td>
                                                <td>22 Nov 2023, 04:15 PM</td>
                                                <td><span class="badge bg-danger">25 Nov 2023, 10:00 AM</span></td>
                                                <td><span class="badge bg-danger">High</span></td>
                                                <td class="text-end">
                                                    <div class="dropdown table-action">
                                                        <a href="#" class="action-icon" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"><i class="ti ti-phone text-success"></i> Call Now</a>
                                                            <a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                                <i class="ti ti-clock text-warning"></i> Update Follow-Up
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Row 2 -->
                                            <tr>
                                                <td>2</td>
                                                <td>Adams</td>
                                                <td>+1 546555455</td>
                                                <td>Campaigns</td>
                                                <td><span class="badge bg-warning">In Progress</span></td>
                                                <td>19 Nov 2023, 01:50 PM</td>
                                                <td><span class="badge bg-warning">27 Nov 2023, 03:30 PM</span></td>
                                                <td><span class="badge bg-warning">Medium</span></td>
                                                <td class="text-end">
                                                    <div class="dropdown table-action">
                                                        <a href="#" class="action-icon" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"><i class="ti ti-phone text-success"></i> Call Now</a>
                                                            <a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                                <i class="ti ti-clock text-warning"></i> Update Follow-Up
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Row 3 -->
                                            <tr>
                                                <td>3</td>
                                                <td>Collins</td>
                                                <td>+1 875455453</td>
                                                <td>Paid Social</td>
                                                <td><span class="badge bg-info">Qualified</span></td>
                                                <td>15 Nov 2023, 11:40 AM</td>
                                                <td><span class="badge bg-success">29 Nov 2023, 02:00 PM</span></td>
                                                <td><span class="badge bg-success">Low</span></td>
                                                <td class="text-end">
                                                    <div class="dropdown table-action">
                                                        <a href="#" class="action-icon" data-bs-toggle="dropdown"><i class="fa fa-ellipsis-v"></i></a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item"><i class="ti ti-phone text-success"></i> Call Now</a>
                                                            <a class="dropdown-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_edit">
                                                                <i class="ti ti-clock text-warning"></i> Update Follow-Up
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>

								<div class="row align-items-center">
									<div class="col-md-6">
										<div class="datatable-length"></div>
									</div>
									<div class="col-md-6">
										<div class="datatable-paginate"></div>
									</div>
								</div>
								<!-- /Manage Users List -->

							</div>
						</div>

					</div>
				</div>

			</div>
		</div>
		<!-- /Page Wrapper -->

		<!-- Add User -->
		<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_add">
			<div class="offcanvas-header border-bottom">
				<h5 class="fw-semibold">Add New User</h5>
				<button type="button"
					class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
					data-bs-dismiss="offcanvas" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<div class="offcanvas-body">
				<form action="manage-users.html">
					<div>
                        <div class="row">
                            <!-- Lead Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Lead Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Lead Name">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" placeholder="Phone">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Location</label>
                                    <input type="text" class="form-control" placeholder="Location">
                                </div>
                            </div>

                            <!-- Created Date (Disabled) -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Created</label>
                                    <input type="date" class="form-control">
                                </div>
                            </div>

                            <!-- Lead Source -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Lead Source <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Choose Source</option>
                                        <option selected>Google</option>
                                        <option>Facebook</option>
                                        <option>Referral</option>
                                        <option>Website</option>
                                        <option>Cold Call</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Status <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Status</option>
                                        <option>Connected</option>
                                        <option>Not Responding</option>
                                        <option>Rescheduled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Lead Status <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Status</option>
                                        <option>Active</option>
                                        <option>Inprogress</option>
                                        <option>Qualified</option>
                                        <option>Lost</option>
                                    </select>
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
		<div class="offcanvas offcanvas-end offcanvas-large" tabindex="-1" id="offcanvas_edit">
			<div class="offcanvas-header border-bottom">
				<h5 class="fw-semibold">Edit User</h5>
				<button type="button"
					class="btn-close custom-btn-close border p-1 me-0 d-flex align-items-center justify-content-center rounded-circle"
					data-bs-dismiss="offcanvas" aria-label="Close">
					<i class="ti ti-x"></i>
				</button>
			</div>
			<div class="offcanvas-body">
				<form action="update-lead.php">
                    <div>
                        <div class="row">

                            <!-- Lead Name -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Lead Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="Darlee Robertson">
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="1234567890">
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" value="robertson@example.com">
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Location</label>
                                    <input type="text" class="form-control" value="HYD">
                                </div>
                            </div>

                            <!-- Created Date (Disabled) -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Created</label>
                                    <input type="text" class="form-control" value="25 Sep 2023, 12:12 pm" disabled>
                                </div>
                            </div>

                            <!-- Lead Source -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Lead Source <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Choose Source</option>
                                        <option selected>Google</option>
                                        <option>Facebook</option>
                                        <option>Referral</option>
                                        <option>Website</option>
                                        <option>Cold Call</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Status <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Status</option>
                                        <option selected>Connected</option>
                                        <option>Not Responding</option>
                                        <option>Rescheduled</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="col-form-label">Lead Status <span class="text-danger">*</span></label>
                                    <select class="select">
                                        <option>Select Status</option>
                                        <option selected>Active</option>
                                        <option>Inprogress</option>
                                        <option>Qualified</option>
                                        <option>Lost</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-end mt-3">
                        <a href="#" class="btn btn-light me-2" data-bs-dismiss="offcanvas">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>

			</div>

		</div>
		<!-- /Edit User -->

		<!-- Delete User -->
		<div class="modal fade" id="delete_contact" role="dialog">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-body">
						<div class="text-center">
							<div class="avatar avatar-xl bg-danger-light rounded-circle mb-3">
								<i class="ti ti-trash-x fs-36 text-danger"></i>
							</div>
							<h4 class="mb-2">Remove users?</h4>
							<p class="mb-0">Are you sure you want to remove it</p>
							<div class="d-flex align-items-center justify-content-center mt-4">
								<a href="#" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</a>
								<a href="manage-users.html" class="btn btn-danger">Yes, Delete it</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /Delete User -->