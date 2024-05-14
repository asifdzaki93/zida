<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .details-row {
            display: none;
        }
    </style>
</head>

<body>
    <h2>Laporan Keuangan</h2>
    <form id="filters">
        <label for="fromDate">Dari tanggal:</label>
        <input type="date" id="fromDate" name="fromDate">
        <label for="toDate">Sampai tanggal:</label>
        <input type="date" id="toDate" name="toDate">
        <label for="branch">Cabang:</label>
        <select id="branch" name="branch">
            <option value="">Pilih Cabang</option>
            <option value="1">Cabang 1</option>
            <option value="2">Cabang 2</option>
        </select>
        <button type="button" onclick="loadData()">Filter</button>
    </form>
    <button onclick="window.print()">Print Laporan</button>
    <table id="financeTable" border="1" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody id="financeData">
            <!-- Data akan dimuat menggunakan AJAX -->
        </tbody>
    </table>

    <script>
        $(document).ready(function() {
            loadData(); // Load data on document ready
        });

        function loadData() {
            var formData = $('#filters').serialize(); // Collect filter data
            $.ajax({
                url: 'fetch_data.php',
                type: 'POST',
                data: formData,
                dataType: 'json', // Expect JSON
                success: function(data) {
                    renderData(data); // Handle data rendering
                },
                error: function(xhr, status, error) {
                    console.error("Error: " + status + " " + error);
                }
            });
        }

        function renderData(data) {
            let html = '';
            let count = 1;

            // Handle Pemasukan
            for (const category in data.pemasukan) {
                const categoryDetails = data.pemasukan[category];
                html += generateCategoryHtml(category, categoryDetails, count++, "Pemasukan");
            }

            // Handle Pengeluaran
            for (const category in data.pengeluaran) {
                const categoryDetails = data.pengeluaran[category];
                html += generateCategoryHtml(category, categoryDetails, count++, "Pengeluaran");
            }

            // Tambahkan baris untuk total
            html += `<tr>
        <td colspan="2">Total</td>
        <td>${data.totalPemasukan}</td>
        <td>${data.totalPengeluaran}</td>
        <td></td>
    </tr>`;

            $('#financeData').html(html); // Update the table body
        }

        function generateCategoryHtml(categoryName, details, id, type) {
            let html = `<tr id="row-${id}">
        <td>${id}</td>
        <td>${categoryName}</td>
        <td>${type === "Pemasukan" ? details.total : '-'}</td>
        <td>${type === "Pengeluaran" ? details.total : '-'}</td>
        <td><button onclick="toggleDetails(${id})">Toggle Details</button></td>
    </tr>`;
            html += `<tr id="details-${id}" class="details-row"><td colspan="5"><div>`;
            details.transaksi.forEach(trans => {
                html += `<p>No Invoice: ${trans.no_invoice}, Jumlah: ${trans.jumlah}, Keterangan: ${trans.keterangan}</p>`;
            });
            html += `</div></td></tr>`;
            return html;
        }

        function toggleDetails(id) {
            $("#details-" + id).toggle(); // Toggle visibility of details row
        }
    </script>
</body>

</html>