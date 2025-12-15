<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="modern-profile p-3 pb-0">
        
        <div class="sidebar-nav mb-3">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent"
                role="tablist">
                <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar-header p-3 pb-0 pt-2">
        
        <div class="d-flex align-items-center justify-content-between menu-item mb-3">
            <div class="me-3">
                <a href="calendar.html" class="btn btn-icon border btn-menubar">
                    <i class="ti ti-layout-grid-remove"></i>
                </a>
            </div>
            <div class="me-3">
                <a href="chat.html" class="btn btn-icon border btn-menubar position-relative">
                    <i class="ti ti-brand-hipchat"></i>
                </a>
            </div>
            <div class="me-3 notification-item">
                <a href="activities.html" class="btn btn-icon border btn-menubar position-relative me-1">
                    <i class="ti ti-bell"></i>
                    <span class="notification-status-dot"></span>
                </a>
            </div>
            <div class="me-0">
                <a href="email.html" class="btn btn-icon border btn-menubar">
                    <i class="ti ti-message"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="clinicdropdown">
                    <a href="javascript:void(0);">
                        <img src="<?php echo base_url('assets/img/authentication/dc-cut-logo.png'); ?>" class="img-fluid" alt="Profile">
                        <div class="user-names">
                            <h5>Deccan Clap</h5>
                            <h6>Welcome</h6>
                        </div>
                    </a>
                </li>
            </ul>
            <ul>
                <li>
                    <h6 class="submenu-hdr">Main Menu</h6>
                    <ul>
                        <li>
                            <a href="<?php echo base_url('dashboard'); ?>">
                                <i class="ti ti-layout-2"></i><span>Dashboard</span>
                            </a>
                        </li>
                        <li class="submenu">
                            <a href="#" class="">
                                <i class="ti ti-user-star"></i><span>User Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?php echo base_url('super_admins'); ?>" class="active">Super Admins</a></li>
                                <li><a href="<?php echo base_url('admins'); ?>" class="active">Admins</a></li>
                                <li><a href="<?php echo base_url('sales_managers'); ?>" class="active">Sales Managers</a></li>
                                <li><a href="<?php echo base_url('inside_sales_executives'); ?>" class="active">Inside Sales Executives</a></li>
                                <li><a href="<?php echo base_url('field_sales_executives'); ?>" class="active">Field Sales Executives</a></li>
                                <li><a href="<?php echo base_url('follow_up_executives'); ?>" class="active">Follow-Up Executive</a></li>
                                <li><a href="<?php echo base_url('vendor_managers'); ?>" class="active">Vendor Managers</a></li>
                                <li><a href="<?php echo base_url('vendors'); ?>" class="active">Vendor</a></li>
                                <li><a href="<?php echo base_url('accounts_executives'); ?>" class="active">Accounts Executive</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
               <li>
                    <h6 class="submenu-hdr">Leads</h6>
                    <ul>
                        <li class="submenu">
                            <a href="#">
                                <i class="fa-solid fa-users-between-lines"></i>
                                <span>Lead Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?= base_url('leads'); ?>">All Leads</a></li>
                                <li><a href="<?= base_url('add_leads'); ?>">Add Lead</a></li>
                                <li><a href="<?= base_url('lead_sources'); ?>">Lead Sources</a></li>
                                <li><a href="<?= base_url('all_leads_calls'); ?>">Call History</a></li>
                                <li><a href="<?= base_url('followups_leads'); ?>">Follow-Ups</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                 <li>
                    <h6 class="submenu-hdr">Services</h6>
                    <ul>
                        <li class="submenu">
                            <a href="#">
                                <i class="fa-solid fa-users-between-lines"></i>
                                <span>Services Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?= base_url('services'); ?>" >All Services</a></li>
                                <li><a href="<?= base_url('products'); ?>" >Products</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <h6 class="submenu-hdr">Cities</h6>
                    <ul>
                        <li class="submenu">
                            <a href="#">
                                <i class="fa-solid fa-users-between-lines"></i>
                                <span>Cities Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?= base_url('cities'); ?>" >Cities</a></li>
                               
                            </ul>
                        </li>
                    </ul>
                </li>

                <!-- <li>
                    <h6 class="submenu-hdr">Vendors Management</h6>
                    <ul>
                        <li class="submenu">
                            <a href="#" class="">
                                <i class="fa-solid fa-file-lines"></i><span>Vendors</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?php //echo base_url('vendors'); ?>" class="active">Vendors</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <h6 class="submenu-hdr">CCTV Management</h6>
                    <ul>
                        <li class="submenu">
                            <a href="#" class="">
                                <i class="fa-solid fa-file-lines"></i><span>CCTV Management</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?php //echo base_url('cctv_types'); ?>" class="active">CCTV Types</a></li>
                                <li><a href="<?php //echo base_url('add_cctv'); ?>" class="active">Add CCTV</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <h6 class="submenu-hdr">CCTV Inventory Management</h6>
                    <ul>
                        <li class="submenu">
                            <a href="#" class="">
                                <i class="fa-solid fa-file-lines"></i><span>Inventory</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="<?php //echo base_url('categories'); ?>" class="active">Categories</a></li>
                                <li><a href="<?php //echo base_url('part_names'); ?>" class="active">Part Names</a></li>
                                <li><a href="<?php //echo base_url('cctv_inventory'); ?>" class="active">Inventory</a></li>
                            </ul>
                        </li>
                    </ul>
                </li> -->
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->