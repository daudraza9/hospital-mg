{{--    <div id="layoutSidenav_content">--}}

<div class="container-fluid px-4">

    <div>
        <table id="role_table" class="table border-dark">
            <thead>
            <tr class="dp-style">
                <th>Id</th>
                <th>Name</th>
                @can(permissions['roleEdit'])
                <th>Action</th>
                @endcan
            </tr>
            </thead>
        </table>
    </div>

</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            roletable = $('#role_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('role.datatable')}}",
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
                    @can(permissions['roleEdit'])
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    }
                    @endcan
                ]
            })
        });

        function deleteRole(id) {

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
                        url: '{{ route('role.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            roletable.draw();
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                }
            });

        }
    </script>
@endpush


