

<div class="container-fluid px-4">


    <div class="table-responsive">
        <table id="file_table" class="table border-dark">
            <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            filetable = $('#file_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('file.datatable')); ?>",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        sortable:false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable:false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    }

                ]
            })
        });

        function deletefile(id) {
            swal({
                title: "Are you sure?",
                text: "Do you really Want to remove This User?",
                icon: "warning",
                buttons: {
                    No:{
                        text: "No!",
                        value: false,
                    },
                    Yes: {
                        text: "Yes!",
                        value: true,
                    }
                },
            }).then((willDelete) => {
                if (willDelete){
                    $.ajax({
                        type: "POST",
                        url: '<?php echo e(route('file.delete')); ?>',
                        data: {
                            '_token': '<?php echo e(csrf_token()); ?>',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            filetable.draw();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });

        }
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH F:\Projects\HospitalManagement\resources\views/file/table.blade.php ENDPATH**/ ?>