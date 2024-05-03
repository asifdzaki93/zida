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
                <textarea class="form-control" id="message" name="message" placeholder="Masukkan isi pesan" required></textarea>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Kirim</button>
        </div>
    </form>
</div>