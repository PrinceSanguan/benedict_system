<script>
    let carbonTable;

    function initializeCarbonTable() {
        carbonTable = $('#carbon-table').DataTable({
            "serverSide": true,
            "ajax": {
                "url": "/carbon-footprint-all/getCarbonDataAll",
                "type": "GET",
                "data": function(d) {
                    d.table = ""; // Default table value (no filtering)
                }
            },
            "paging": true,
            "searching": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "pageLength": 10,
            "autoWidth": false,
            "responsive": true,
            "sScrollX": "100%",
            "columns": [
                { "data": "campus" },
                { "data": "category" },
                { "data": "month" },
                { "data": "quarter" },
                { "data": "year" },
                { "data": "prev_reading" },
                { "data": "total_amount" }
            ]
        });
    }

    // Reload data dynamically
    function loadCarbonData(table) {
    carbonTable.ajax.url(`/carbon-footprint-all/getCarbonDataAll/${table}`).load();
}

    // Initialize the table on page load
    $(document).ready(function() {
        initializeCarbonTable();
    });
</script>
    