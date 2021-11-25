{{--    <div id="layoutSidenav_content">--}}

<div class="container-fluid px-4">

    <div class="filters-div">
        <div class="row mt-2 mb-2">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="keyword">Search by Keyword</label>
                    <input id="keyword" type="search" class="form-control" placeholder="Enter Keyword" name="">
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
                <label></label>
                <div class="form-group" style="margin-top: 6px;">
                    <button class="btn btn-primary bg-darken-2 text-white" onclick="stafftable.draw();"><i class="ft-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="staff_table" class="table border-dark">
            <thead>
            <tr class="dp-style">
                <th>Id</th>
                <th width="150px">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Joined At</th>
                <th>Salary</th>
                <th>Department</th>
                <th width="200">Action</th>
            </tr>
            </thead>
        </table>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            stafftable = $('#staff_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{route('staff.datatable')}}',
                    data:function (d){
                        d.keyword = $('#keyword').val();
                    }
                },
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
                        data: 'email',
                        name: 'email',
                        sortable:false
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        sortable:false
                    },
                    {
                        data: 'address',
                        name: 'address',
                        sortable:false
                    },
                    {
                        data: 'joined_at',
                        name: 'joined_at',
                        sortable:false
                    },
                    {
                        data: 'salary',
                        name: 'salary',
                        sortable:false
                    },{
                        data: 'department',
                        name: 'department',
                        sortable:false
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    }

                ]
            })
        });

        function deleteStaff(id)
        {

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
                        url: '{{ route('staff.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            stafftable.draw();
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
