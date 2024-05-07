<?php
include 'layout/header.php';
?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basic">
    Launch modal 2
</button>

<!-- Modal -->
<div class="modal fade" id="basic" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="dropdown btn-pinned">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical mdi-24px text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);">Share connection</a></li>
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);">Block connection</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger waves-effect" href="javascript:void(0);">Delete</a></li>
                        </ul>
                    </div>
                    <div class="mx-auto mb-4">
                        <img src="<?= $base_url; ?>/assets/img/avatars/1.png" alt="Avatar Image" class="rounded-circle w-px-100">
                    </div>
                    <h5 class="mb-1 card-title">Mark Gilbert</h5>
                    <span class="text-muted">UI Designer</span>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#Invoice</th>
                                    <th><i class="mdi mdi-trending-up"></i></th>
                                    <th>Total</th>
                                    <th class="text-truncate">Dibuat</th>
                                    <th>Tagihan</th>
                                    <th class="cell-fit">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- List Data Menggunakan DataTable -->
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="javascript:;" class="btn btn-primary d-flex align-items-center me-3 waves-effect waves-light"><i class="mdi mdi-account-check-outline me-1"></i>Connected</a>
                        <a href="javascript:;" class="btn btn-outline-secondary btn-icon waves-effect"><i class="mdi mdi-email-outline"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#basicModal">
    Launch modal
</button>

<!-- Modal -->
<div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="card">
                <div class="card-body text-center">
                    <div class="dropdown btn-pinned">
                        <button type="button" class="btn dropdown-toggle hide-arrow p-0" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="mdi mdi-dots-vertical mdi-24px text-muted"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);">Share connection</a></li>
                            <li><a class="dropdown-item waves-effect" href="javascript:void(0);">Block connection</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger waves-effect" href="javascript:void(0);">Delete</a></li>
                        </ul>
                    </div>
                    <div class="mx-auto mb-4">
                        <img src="<?= $base_url; ?>/assets/img/avatars/1.png" alt="Avatar Image" class="rounded-circle w-px-100">
                    </div>
                    <h5 class="mb-1 card-title">Mark Gilbert</h5>
                    <span class="text-muted">UI Designer</span>
                    <div class="card-datatable table-responsive pt-0">
                        <table class="invoice-list-table datatables-basic table dt-table dt-responsive display table-striped table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>#Invoice</th>
                                    <th><i class="mdi mdi-trending-up"></i></th>
                                    <th>Total</th>
                                    <th class="text-truncate">Dibuat</th>
                                    <th>Tagihan</th>
                                    <th class="cell-fit">Aksi</th>

                                </tr>
                            </thead>
                            <tbody>
                                <!-- List Data Menggunakan DataTable -->
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="card-footer">
                    <div class="d-flex align-items-center justify-content-center">
                        <a href="javascript:;" class="btn btn-primary d-flex align-items-center me-3 waves-effect waves-light"><i class="mdi mdi-account-check-outline me-1"></i>Connected</a>
                        <a href="javascript:;" class="btn btn-outline-secondary btn-icon waves-effect"><i class="mdi mdi-email-outline"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<?php
include 'layout/footer.php';
?>