<script>
    $(document).ready(function() {
        $('#carbon-table').DataTable({
            "serverSide": true,
            "ajax": {
                "url": "/carbon-footprint/getCarbonData", // URL to the JSON endpoint
                "type": "GET"
            },
            "paging": true,
            "searching": true,
            "info": true,
            "lengthMenu": [10, 25, 50, 75, 100],
            "pageLength": 10,
            "autoWidth": false, // Ensures better responsive design
            "responsive": true, // Enables responsive tables
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
    });
    </script>
    