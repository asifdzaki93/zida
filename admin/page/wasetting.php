<div class="row">
    <div class="card mt-4 col-md-12 col-lg-6">
        <form action="save_settings.php" method="post">
            <div class="card-body">
                <h5 class="card-title">Pengaturan Endpoint dan API Key</h5>
                <div class="form-group">
                    <label for="endpoint">Endpoint:</label>
                    <input type="text" class="form-control" id="endpoint" name="endpoint" placeholder="Masukkan Endpoint" required>
                </div>
                <div class="form-group">
                    <label for="api_key">API Key:</label>
                    <input type="text" class="form-control" id="api_key" name="api_key" placeholder="Masukkan API Key" required>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>

    <div class="card mt-4 col-md-12 col-lg-6">
        <form action="<?php echo $base_url; ?>admin/data/send_message.php" method="post">
            <div class="card-body">
                <h5 class="card-title">Test Kirim Pesan</h5>

                <div class="form-group">
                    <label for="phone_number">Nomor Telepon:</label>
                    <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan nomor telepon" required>
                </div>
                <div class="form-group">
                    <label for="message">Isi Pesan:</label>
                    <textarea class="form-control" id="message" name="message" placeholder="Masukkan isi pesan" required></textarea>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
        </form>
    </div>
</div>