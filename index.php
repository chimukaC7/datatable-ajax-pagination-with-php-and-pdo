<!doctype html>
<html>

<head>
    <title>Datatable AJAX pagination with PHP and PDO</title>
    <!-- Datatable CSS -->
    <link href='DataTables/datatables.min.css' rel='stylesheet' type='text/css'>

    <!-- jQuery Library -->
    <script src="jquery-3.3.1.min.js"></script>

    <!-- Datatable JS -->
    <script src="DataTables/datatables.min.js"></script>

</head>

<body>

    <div>
        <!-- Table -->
        <table width="100%" id='empTable' class='table table-hover table-striped table-bordered'>
            <thead>
                <tr>
                    <th>Employee name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Salary</th>
                    <th>City</th>
                    <th></th>
                </tr>
            </thead>

        </table>
    </div>

    <!-- Script -->
    <script>
        $(document).ready(function() {
            $('#empTable').DataTable({
                'responsive': true,
                'processing': true,
                'serverSide': true,
                'destroy': true,
                'serverMethod': 'get',
                'ajax': {
                    'url': 'ajaxfile.php',
                    'async': true,
                },
                //"deferRender": true,//When working with large data sources, you might seek to improve the speed at which DataTables runs
                'columns': [{
                        data: 'emp_name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'gender'
                    },
                    {
                        data: 'salary'
                    },
                    {
                        data: 'city'
                    },
                ],
                // error: function () {  // error handling
                //     $(".employee-grid-error").html("");
                //     $("#employee-grid").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                //     $("#employee-grid_processing").css("display", "none");
                // }
                'columnDefs': [{
                    "targets": 4,
                    //"targets": "Action",
                    "data": null,
                    "defaultContent": "<button data-toggle='modal' data-target='#modalUserAddEdit'>Click</button>"
                }],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                    },
                    {
                        extend: 'excel',
                        title: 'js-tutorials.com : Export to datatable data',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                    },
                    {
                        extend: 'pdf',
                        title: 'js-tutorials.com : Export to datatable data',
                        orientation: 'landscape',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                    },
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        },
                    }
                ],
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ], //It is possible to easily customise the options shown in the length menu
            });

            $('#empTable tbody').on('click', 'button', function() {

                var data = table.row($(this).parents('tr')).data();
                //alert( data.firstname +"'s salary is: "+ data.lastname );

                $('#modalUserAddEdit').on('show.bs.modal', function(e) {

                });
            })


        });
    </script>
</body>

</html>