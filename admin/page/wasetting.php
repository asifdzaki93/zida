<link rel="stylesheet" href="<?php echo $base_url; ?>/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.css" />


<div class="row h-auto">
    <div class="col mt-4 col-md-12 col-lg-6">
        <div class="card">
            <form action="save_settings.php" method="post">
                <div class="card-body">
                    <h5 class="card-title">Pengaturan Gateway</h5>
                    <div class="form-group">
                        <label for="endpoint">Endpoint:</label>
                        <input type="text" class="form-control" id="endpoint" name="endpoint" placeholder="Masukkan Endpoint" required>
                    </div>
                    <div class="form-group">
                        <label for="api_key">API Key:</label>
                        <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Masukkan API key anda" required>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col mt-4 col-md-12 col-lg-6">

        <div class="card">
            <form action="<?php echo $base_url; ?>admin/data/send_message.php" method="post">
                <div class="card-body">
                    <h5 class="card-title">Test Kirim Pesan</h5>

                    <div class="form-group">
                        <label for="phone_number">Nomor Telepon:</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan nomor telepon" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Isi Pesan:</label>
                        <textarea class="form-control" rows="1" id="message" name="message" placeholder="Masukkan isi pesan" required></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Kirim</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="mt-4">
    <div class="app-chat card overflow-hidden">
        <div class="row g-0">
            <!-- Sidebar Left -->
            <div class="col app-chat-sidebar-left app-sidebar overflow-hidden" id="app-chat-sidebar-left">
                <div class="chat-sidebar-left-user sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-4 pt-5">
                    <div class="avatar avatar-xl avatar-online w-px-75 h-px-75">
                        <img src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                    </div>
                    <h5 class="mt-3 mb-1 fw-semibold">John Doe</h5>
                    <span>UI/UX Designer</span>
                    <i class="mdi mdi-close mdi-20px cursor-pointer close-sidebar" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left"></i>
                </div>
                <div class="sidebar-body px-4 pb-4">
                    <div class="my-4 pt-2">
                        <label for="chat-sidebar-left-user-about" class="text-uppercase">About</label>
                        <textarea id="chat-sidebar-left-user-about" class="form-control chat-sidebar-left-user-about mt-3" rows="3" maxlength="120">
Dessert chocolate cake lemon drops jujubes. Biscuit cupcake ice cream bear claw brownie brownie marshmallow.</textarea>
                    </div>
                    <div class="my-4">
                        <p class="text-uppercase">Status</p>
                        <div class="d-grid gap-2">
                            <div class="form-check form-check-success">
                                <input name="chat-user-status" class="form-check-input" type="radio" value="active" id="user-active" checked />
                                <label class="form-check-label" for="user-active">Active</label>
                            </div>
                            <div class="form-check form-check-danger">
                                <input name="chat-user-status" class="form-check-input" type="radio" value="busy" id="user-busy" />
                                <label class="form-check-label" for="user-busy">Busy</label>
                            </div>
                            <div class="form-check form-check-warning">
                                <input name="chat-user-status" class="form-check-input" type="radio" value="away" id="user-away" />
                                <label class="form-check-label" for="user-away">Away</label>
                            </div>
                            <div class="form-check form-check-secondary">
                                <input name="chat-user-status" class="form-check-input" type="radio" value="offline" id="user-offline" />
                                <label class="form-check-label" for="user-offline">Offline</label>
                            </div>
                        </div>
                    </div>
                    <div class="my-4">
                        <p class="text-uppercase">Settings</p>
                        <ul class="list-unstyled d-grid gap-3 me-3">
                            <li class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="mdi mdi-check-circle-outline me-1"></i>
                                    <span class="align-middle">Two-step Verification</span>
                                </div>
                                <label class="switch switch-primary me-4">
                                    <input type="checkbox" class="switch-input" checked="" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                </label>
                            </li>
                            <li class="d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="mdi mdi-bell-outline me-1"></i>
                                    <span class="align-middle">Notification</span>
                                </div>
                                <label class="switch switch-primary me-4">
                                    <input type="checkbox" class="switch-input" />
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                </label>
                            </li>
                            <li>
                                <i class="mdi mdi-account-outline me-1"></i>
                                <span class="align-middle">Invite Friends</span>
                            </li>
                            <li>
                                <i class="mdi mdi-delete-outline me-1"></i>
                                <span class="align-middle">Delete Account</span>
                            </li>
                        </ul>
                    </div>
                    <div class="d-flex mt-4">
                        <button class="btn btn-primary" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-left">
                            Logout
                        </button>
                    </div>
                </div>
            </div>
            <!-- /Sidebar Left-->

            <!-- Chat & Contacts -->
            <div class="col app-chat-contacts app-sidebar flex-grow-0 overflow-hidden border-end" id="app-chat-contacts">
                <div class="sidebar-header py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center me-3 me-lg-0">
                        <div class="flex-shrink-0 avatar avatar-online me-3" data-bs-toggle="sidebar" data-overlay="app-overlay-ex" data-target="#app-chat-sidebar-left">
                            <img class="user-avatar rounded-circle cursor-pointer" src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" />
                        </div>
                        <div class="flex-grow-1 input-group input-group-merge rounded-pill">
                            <span class="input-group-text" id="basic-addon-search31"><i class="mdi mdi-magnify lh-1"></i></span>
                            <input type="text" class="form-control chat-search-input" placeholder="Search..." aria-label="Search..." aria-describedby="basic-addon-search31" />
                        </div>
                    </div>
                    <i class="mdi mdi-close mdi-20px cursor-pointer position-absolute top-0 end-0 mt-2 me-2 fs-4 d-lg-none d-block" data-overlay data-bs-toggle="sidebar" data-target="#app-chat-contacts"></i>
                </div>
                <div class="sidebar-body">
                    <!-- Chats -->
                    <ul class="list-unstyled chat-contact-list" id="chat-list">
                        <li class="chat-contact-list-item chat-contact-list-item-title">
                            <h5 class="text-primary mb-0">Chats</h5>
                        </li>
                        <li class="chat-contact-list-item chat-list-item-0 d-none">
                            <h6 class="text-muted mb-0">No Chats Found</h6>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar avatar-online">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/13.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Waldemar Mannering</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Refer friends. Get rewards.</p>
                                </div>
                                <small class="text-muted mb-auto">5 Minutes</small>
                            </a>
                        </li>
                        <li class="chat-contact-list-item active">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar avatar-offline">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Felecia Rower</h6>
                                    <p class="chat-contact-status text-truncate mb-0">I will purchase it for sure. 👍</p>
                                </div>
                                <small class="text-muted mb-auto">30 Minutes</small>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar avatar-busy">
                                    <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Calvin Moore</h6>
                                    <p class="chat-contact-status text-truncate mb-0">
                                        If it takes long you can mail inbox user
                                    </p>
                                </div>
                                <small class="text-muted mb-auto">1 Day</small>
                            </a>
                        </li>
                    </ul>
                    <!-- Contacts -->
                    <ul class="list-unstyled chat-contact-list" id="contact-list">
                        <li class="chat-contact-list-item chat-contact-list-item-title">
                            <h5 class="text-primary mb-0">Contacts</h5>
                        </li>
                        <li class="chat-contact-list-item contact-list-item-0 d-none">
                            <h6 class="text-muted mb-0">No Contacts Found</h6>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Natalie Maxwell</h6>
                                    <p class="chat-contact-status text-truncate mb-0">UI/UX Designer</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Jess Cook</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Business Analyst</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="avatar d-block flex-shrink-0">
                                    <span class="avatar-initial rounded-circle bg-label-primary">LM</span>
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Louie Mason</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Resource Manager</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/7.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Krystal Norton</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Business Executive</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/8.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Stacy Garrison</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Marketing Ninja</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="avatar d-block flex-shrink-0">
                                    <span class="avatar-initial rounded-circle bg-label-success">CM</span>
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Calvin Moore</h6>
                                    <p class="chat-contact-status text-truncate mb-0">UX Engineer</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/10.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Mary Giles</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Account Department</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/13.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Waldemar Mannering</h6>
                                    <p class="chat-contact-status text-truncate mb-0">AWS Support</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="avatar d-block flex-shrink-0">
                                    <span class="avatar-initial rounded-circle bg-label-danger">AJ</span>
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Amy Johnson</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Frontend Developer</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">Felecia Rower</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Cloud Engineer</p>
                                </div>
                            </a>
                        </li>
                        <li class="chat-contact-list-item mb-3">
                            <a class="d-flex align-items-center">
                                <div class="flex-shrink-0 avatar">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/11.png" alt="Avatar" class="rounded-circle" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="chat-contact-name text-truncate m-0">William Stephens</h6>
                                    <p class="chat-contact-status text-truncate mb-0">Backend Developer</p>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- /Chat contacts -->

            <!-- Chat History -->
            <div class="col app-chat-history">
                <div class="chat-history-wrapper">
                    <div class="chat-history-header border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex overflow-hidden align-items-center">
                                <i class="mdi mdi-menu mdi-24px cursor-pointer d-lg-none d-block me-3" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-contacts"></i>
                                <div class="flex-shrink-0 avatar avatar-online">
                                    <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right" />
                                </div>
                                <div class="chat-contact-info flex-grow-1 ms-3">
                                    <h6 class="m-0">Felecia Rower</h6>
                                    <span class="user-status text-body">NextJS developer</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="mdi mdi-phone-outline mdi-24px cursor-pointer d-sm-block d-none me-1 btn btn-text-secondary btn-icon rounded-pill"></i>
                                <i class="mdi mdi-video-outline mdi-24px cursor-pointer d-sm-block d-none me-1 btn btn-text-secondary btn-icon rounded-pill"></i>
                                <i class="mdi mdi-magnify mdi-24px cursor-pointer d-sm-block d-none me-1 btn btn-text-secondary btn-icon rounded-pill"></i>
                                <div class="dropdown">
                                    <button class="btn btn-icon btn-text-secondary rounded-pill dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="true" id="chat-header-actions">
                                        <i class="mdi mdi-dots-vertical mdi-24px"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="chat-header-actions">
                                        <a class="dropdown-item" href="javascript:void(0);">View Contact</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Mute Notifications</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Block Contact</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Clear Chat</a>
                                        <a class="dropdown-item" href="javascript:void(0);">Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="chat-history-body">
                        <ul class="list-unstyled chat-history">
                            <li class="chat-message chat-message-right">
                                <div class="d-flex overflow-hidden">
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">How can we help? We're here for you! 😄</p>
                                        </div>
                                        <div class="text-end text-muted">
                                            <i class="mdi mdi-check-all mdi-14px text-success me-1"></i>
                                            <small>10:00 AM</small>
                                        </div>
                                    </div>
                                    <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message">
                                <div class="d-flex overflow-hidden">
                                    <div class="user-avatar flex-shrink-0 me-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Hey John, I am looking for the best admin template.</p>
                                            <p class="mb-0">Could you please help me to find it out? 🤔</p>
                                        </div>
                                        <div class="chat-message-text mt-3">
                                            <p class="mb-0">It should be Bootstrap 5 compatible.</p>
                                        </div>
                                        <div class="text-muted">
                                            <small>10:02 AM</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message chat-message-right">
                                <div class="d-flex overflow-hidden">
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Materialize has all the components you'll ever need in a app.</p>
                                        </div>
                                        <div class="text-end text-muted">
                                            <i class="mdi mdi-check-all mdi-14px text-success me-1"></i>
                                            <small>10:03 AM</small>
                                        </div>
                                    </div>
                                    <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message">
                                <div class="d-flex overflow-hidden">
                                    <div class="user-avatar flex-shrink-0 me-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Looks clean and fresh UI. 😃</p>
                                        </div>
                                        <div class="chat-message-text mt-3">
                                            <p class="mb-0">It's perfect for my next project.</p>
                                        </div>
                                        <div class="chat-message-text mt-3">
                                            <p class="mb-0">How can I purchase it?</p>
                                        </div>
                                        <div class="text-muted">
                                            <small>10:05 AM</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message chat-message-right">
                                <div class="d-flex overflow-hidden">
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Thanks, you can purchase it.</p>
                                        </div>
                                        <div class="text-end text-muted">
                                            <i class="mdi mdi-check-all mdi-14px text-success me-1"></i>
                                            <small>10:06 AM</small>
                                        </div>
                                    </div>
                                    <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message">
                                <div class="d-flex overflow-hidden">
                                    <div class="user-avatar flex-shrink-0 me-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">I will purchase it for sure. 👍</p>
                                        </div>
                                        <div class="chat-message-text mt-3">
                                            <p class="mb-0">Thanks.</p>
                                        </div>
                                        <div class="text-muted">
                                            <small>10:08 AM</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message chat-message-right">
                                <div class="d-flex overflow-hidden">
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Great, Feel free to get in touch.</p>
                                        </div>
                                        <div class="text-end text-muted">
                                            <i class="mdi mdi-check-all mdi-14px text-success me-1"></i>
                                            <small>10:10 AM</small>
                                        </div>
                                    </div>
                                    <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message">
                                <div class="d-flex overflow-hidden">
                                    <div class="user-avatar flex-shrink-0 me-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                    <div class="chat-message-wrapper flex-grow-1">
                                        <div class="chat-message-text">
                                            <p class="mb-0">Do you have design files for Vuexy?</p>
                                        </div>
                                        <div class="text-muted">
                                            <small>10:15 AM</small>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="chat-message chat-message-right">
                                <div class="d-flex overflow-hidden">
                                    <div class="chat-message-wrapper flex-grow-1 w-50">
                                        <div class="chat-message-text">
                                            <p class="mb-0">
                                                Yes that's correct documentation file, Design files are included with the template.
                                            </p>
                                        </div>
                                        <div class="text-end text-muted">
                                            <i class="mdi mdi-check-all mdi-14px me-1"></i>
                                            <small>10:15 AM</small>
                                        </div>
                                    </div>
                                    <div class="user-avatar flex-shrink-0 ms-3">
                                        <div class="avatar avatar-sm">
                                            <img src="<?php echo $base_url; ?>/assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- Chat message form -->
                    <div class="chat-history-footer">
                        <form class="form-send-message d-flex justify-content-between align-items-center">
                            <input class="form-control message-input me-3 shadow-none" placeholder="Type your message here" />
                            <div class="message-actions d-flex align-items-center">
                                <i class="btn btn-text-secondary btn-icon rounded-pill speech-to-text mdi mdi-microphone mdi-20px cursor-pointer"></i>
                                <label for="attach-doc" class="form-label mb-0">
                                    <i class="mdi mdi-paperclip mdi-20px cursor-pointer btn btn-text-secondary btn-icon rounded-pill me-2 ms-1"></i>
                                    <input type="file" id="attach-doc" hidden />
                                </label>
                                <button class="btn btn-primary d-flex send-msg-btn">
                                    <span class="align-middle">Send</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /Chat History -->

            <!-- Sidebar Right -->
            <div class="col app-chat-sidebar-right app-sidebar overflow-hidden" id="app-chat-sidebar-right">
                <div class="sidebar-header d-flex flex-column justify-content-center align-items-center flex-wrap px-4 pt-5">
                    <div class="avatar avatar-xl avatar-online w-px-75 h-px-75">
                        <img src="<?php echo $base_url; ?>/assets/img/avatars/4.png" alt="Avatar" class="rounded-circle" />
                    </div>
                    <h5 class="mt-3 mb-1 fw-semibold">Felecia Rower</h5>
                    <span>NextJS Developer</span>
                    <i class="mdi mdi-close mdi-20px cursor-pointer close-sidebar d-block" data-bs-toggle="sidebar" data-overlay data-target="#app-chat-sidebar-right"></i>
                </div>
                <div class="sidebar-body px-4">
                    <div class="my-4 pt-2">
                        <p class="text-uppercase mb-2">About</p>
                        <p class="mb-0">
                            A Next. js developer is a software developer who uses the Next. js framework alongside ReactJS
                            to build web applications.
                        </p>
                    </div>
                    <div class="my-4 py-1">
                        <p class="text-uppercase mb-2">Personal Information</p>
                        <ul class="list-unstyled d-grid gap-3 mb-0">
                            <li class="d-flex align-items-center">
                                <i class="mdi mdi-email-outline"></i>
                                <span class="align-middle ms-2">josephGreen@email.com</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="mdi mdi-phone"></i>
                                <span class="align-middle ms-2">+1(123) 456 - 7890</span>
                            </li>
                            <li class="d-flex align-items-center">
                                <i class="mdi mdi-clock-outline"></i>
                                <span class="align-middle ms-2">Mon - Fri 10AM - 8PM</span>
                            </li>
                        </ul>
                    </div>
                    <div class="my-4">
                        <p class="text-uppercase">Options</p>
                        <ul class="list-unstyled d-grid gap-3 mt-3">
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="mdi mdi-tag-outline"></i>
                                <span class="align-middle ms-2">Add Tag</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="mdi mdi-star-outline"></i>
                                <span class="align-middle ms-2">Important Contact</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="mdi mdi-image-outline"></i>
                                <span class="align-middle ms-2">Shared Media</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="mdi mdi-delete-outline"></i>
                                <span class="align-middle ms-2">Delete Contact</span>
                            </li>
                            <li class="cursor-pointer d-flex align-items-center">
                                <i class="mdi mdi-block-helper"></i>
                                <span class="align-middle ms-2">Block Contact</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Sidebar Right -->

            <div class="app-overlay"></div>
        </div>
    </div>
</div>
<script src="<?php echo $base_url; ?>/assets/vendor/libs/bootstrap-maxlength/bootstrap-maxlength.js"></script>

<script>
    /**
     * App Chat
     */

    (function() {
        const chatContactsBody = document.querySelector('.app-chat-contacts .sidebar-body'),
            chatContactListItems = [].slice.call(
                document.querySelectorAll('.chat-contact-list-item:not(.chat-contact-list-item-title)')
            ),
            chatHistoryBody = document.querySelector('.chat-history-body'),
            chatSidebarLeftBody = document.querySelector('.app-chat-sidebar-left .sidebar-body'),
            chatSidebarRightBody = document.querySelector('.app-chat-sidebar-right .sidebar-body'),
            chatUserStatus = [].slice.call(document.querySelectorAll(".form-check-input[name='chat-user-status']")),
            chatSidebarLeftUserAbout = $('.chat-sidebar-left-user-about'),
            formSendMessage = document.querySelector('.form-send-message'),
            messageInput = document.querySelector('.message-input'),
            searchInput = document.querySelector('.chat-search-input'),
            speechToText = $('.speech-to-text'), // ! jQuery dependency for speech to text
            userStatusObj = {
                active: 'avatar-online',
                offline: 'avatar-offline',
                away: 'avatar-away',
                busy: 'avatar-busy'
            };

        // Initialize PerfectScrollbar
        // ------------------------------

        // Chat contacts scrollbar
        if (chatContactsBody) {
            new PerfectScrollbar(chatContactsBody, {
                wheelPropagation: false,
                suppressScrollX: true
            });
        }

        // Chat history scrollbar
        if (chatHistoryBody) {
            new PerfectScrollbar(chatHistoryBody, {
                wheelPropagation: false,
                suppressScrollX: true
            });
        }

        // Sidebar left scrollbar
        if (chatSidebarLeftBody) {
            new PerfectScrollbar(chatSidebarLeftBody, {
                wheelPropagation: false,
                suppressScrollX: true
            });
        }

        // Sidebar right scrollbar
        if (chatSidebarRightBody) {
            new PerfectScrollbar(chatSidebarRightBody, {
                wheelPropagation: false,
                suppressScrollX: true
            });
        }

        // Scroll to bottom function
        function scrollToBottom() {
            chatHistoryBody.scrollTo(0, chatHistoryBody.scrollHeight);
        }
        scrollToBottom();

        // User About Maxlength Init
        if (chatSidebarLeftUserAbout.length) {
            chatSidebarLeftUserAbout.maxlength({
                alwaysShow: true,
                warningClass: 'label label-success bg-success text-white',
                limitReachedClass: 'label label-danger',
                separator: '/',
                validate: true,
                threshold: 120
            });
        }

        // Update user status
        chatUserStatus.forEach(el => {
            el.addEventListener('click', e => {
                let chatLeftSidebarUserAvatar = document.querySelector('.chat-sidebar-left-user .avatar'),
                    value = e.currentTarget.value;
                //Update status in left sidebar user avatar
                chatLeftSidebarUserAvatar.removeAttribute('class');
                Helpers._addClass('avatar avatar-xl w-px-75 h-px-75 ' + userStatusObj[value] + '', chatLeftSidebarUserAvatar);
                //Update status in contacts sidebar user avatar
                let chatContactsUserAvatar = document.querySelector('.app-chat-contacts .avatar');
                chatContactsUserAvatar.removeAttribute('class');
                Helpers._addClass('flex-shrink-0 avatar ' + userStatusObj[value] + ' me-3', chatContactsUserAvatar);
            });
        });

        // Select chat or contact
        chatContactListItems.forEach(chatContactListItem => {
            // Bind click event to each chat contact list item
            chatContactListItem.addEventListener('click', e => {
                // Remove active class from chat contact list item
                chatContactListItems.forEach(chatContactListItem => {
                    chatContactListItem.classList.remove('active');
                });
                // Add active class to current chat contact list item
                e.currentTarget.classList.add('active');
            });
        });

        // Filter Chats
        if (searchInput) {
            searchInput.addEventListener('keyup', e => {
                let searchValue = e.currentTarget.value.toLowerCase(),
                    searchChatListItemsCount = 0,
                    searchContactListItemsCount = 0,
                    chatListItem0 = document.querySelector('.chat-list-item-0'),
                    contactListItem0 = document.querySelector('.contact-list-item-0'),
                    searchChatListItems = [].slice.call(
                        document.querySelectorAll('#chat-list li:not(.chat-contact-list-item-title)')
                    ),
                    searchContactListItems = [].slice.call(
                        document.querySelectorAll('#contact-list li:not(.chat-contact-list-item-title)')
                    );

                // Search in chats
                searchChatContacts(searchChatListItems, searchChatListItemsCount, searchValue, chatListItem0);
                // Search in contacts
                searchChatContacts(searchContactListItems, searchContactListItemsCount, searchValue, contactListItem0);
            });
        }

        // Search chat and contacts function
        function searchChatContacts(searchListItems, searchListItemsCount, searchValue, listItem0) {
            searchListItems.forEach(searchListItem => {
                let searchListItemText = searchListItem.textContent.toLowerCase();
                if (searchValue) {
                    if (-1 < searchListItemText.indexOf(searchValue)) {
                        searchListItem.classList.add('d-flex');
                        searchListItem.classList.remove('d-none');
                        searchListItemsCount++;
                    } else {
                        searchListItem.classList.add('d-none');
                    }
                } else {
                    searchListItem.classList.add('d-flex');
                    searchListItem.classList.remove('d-none');
                    searchListItemsCount++;
                }
            });
            // Display no search fount if searchListItemsCount == 0
            if (searchListItemsCount == 0) {
                listItem0.classList.remove('d-none');
            } else {
                listItem0.classList.add('d-none');
            }
        }

        // Send Message
        formSendMessage.addEventListener('submit', e => {
            e.preventDefault();
            if (messageInput.value) {
                // Create a div and add a class
                let renderMsg = document.createElement('div');
                renderMsg.className = 'chat-message-text mt-3';
                renderMsg.innerHTML = '<p class="mb-0">' + messageInput.value + '</p>';
                document.querySelector('li:last-child .chat-message-wrapper').appendChild(renderMsg);
                messageInput.value = '';
                scrollToBottom();
            }
        });

        // on click of chatHistoryHeaderMenu, Remove data-overlay attribute from chatSidebarLeftClose to resolve overlay overlapping issue for two sidebar
        let chatHistoryHeaderMenu = document.querySelector(".chat-history-header [data-target='#app-chat-contacts']"),
            chatSidebarLeftClose = document.querySelector('.app-chat-sidebar-left .close-sidebar');
        chatHistoryHeaderMenu.addEventListener('click', e => {
            chatSidebarLeftClose.removeAttribute('data-overlay');
        });
        // }

        // Speech To Text
        if (speechToText.length) {
            var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition;
            if (SpeechRecognition !== undefined && SpeechRecognition !== null) {
                var recognition = new SpeechRecognition(),
                    listening = false;
                speechToText.on('click', function() {
                    const $this = $(this);
                    recognition.onspeechstart = function() {
                        listening = true;
                    };
                    if (listening === false) {
                        recognition.start();
                    }
                    recognition.onerror = function(event) {
                        listening = false;
                    };
                    recognition.onresult = function(event) {
                        $this.closest('.form-send-message').find('.message-input').val(event.results[0][0].transcript);
                    };
                    recognition.onspeechend = function(event) {
                        listening = false;
                        recognition.stop();
                    };
                });
            }
        }
    })();
</script>