$(function() {
    $('#penjualan').DataTable({
        "order": [[0, 'desc']],
        "processing": true,
        "responsive": true,
        "serverSide": true,
        "ordering": true,
        "stateSave": true,
        "columnDefs": [
            {"className": "dt-left", "targets": 2},
            {"className": "dt-left", "targets": 3},
            {"className": "dt-center", "targets": 4},
            {"responsivePriority": 1, "targets": 0},
            {"responsivePriority": 2, "targets": 1},
            {"responsivePriority": 3, "targets": 2},
            {"responsivePriority": 14, "targets": 3},
            {"responsivePriority": 5, "targets": 4},
            {"responsivePriority": 6, "targets": 5}
        ],
        "ajax": {
            "url": "http://localhost/zida/admin/data/history.php?action=sales_data&user=082322345757",
            "data": function (d) {
                d.action = 'sales_data';
                d.user = userData;
            },
            "dataType": "json",
            "type": "POST"
        },
        "columns": [
            {"data": "no"},
            {"data": "aksi"},
            {"data": "due_date"},
            {"data": "status"},
            {"data": "totalorder"},
            {"data": "note"},
            {"data": "image"}
        ],
        "buttons": ['pdf', 'excel']
    });
});
