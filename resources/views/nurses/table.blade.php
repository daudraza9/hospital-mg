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
                    <button class="btn btn-primary bg-darken-2 text-white" onclick="nursetable.draw();"><i class="ft-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <div>
        <table id="nurse_table" class="table table-responsive border-dark">
            <thead>
            <tr class="dp-style">
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Position</th>
                <th>Joined At</th>
                <th>Department</th>
                <th width="200px">Actions</th>
            </tr>
            </thead>
        </table>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            nursetable = $('#nurse_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{route('nurse.datatable')}}',
                    data: function (d){
                        d.keyword = $('#keyword').val();
                    }
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false
                    },
                    {
                        data: 'name',
                        name: 'name',
                        sortable: false
                    },

                    {
                        data: 'email',
                        name: 'email',
                        sortable: false
                    },
                    {
                        data: 'phone',
                        name: 'phone',
                        sortable: false
                    },
                    {
                        data: 'position',
                        name: 'position',
                        sortable: false
                    },
                    {
                        data: 'joined_at',
                        name: 'joined_at',
                        sortable: false
                    },
                    {
                        data: 'department',
                        name: 'department',
                        sortable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable:false,
                        searchable:true
                    },
                ]
            })
        });

        function deleteNurse(id)
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
                        url: '{{ route('nurse.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            nursetable.draw();
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
