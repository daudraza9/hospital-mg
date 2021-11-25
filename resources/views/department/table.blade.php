{{--    <div id="layoutSidenav_content">--}}

<div class="container-fluid px-4">

    <div class="filters-div">
        <div class="row mt-2 mb-2">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="keyword">Keyword Search</label>
                    <input id="keyword" type="search" class="form-control" placeholder="Enter Keyword" name="">
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
                <label></label>
                <div class="form-group" style="margin-top: 6px;">
                    <button class="btn btn-primary bg-darken-2 text-white" onclick="departmenttable.draw();"><i class="ft-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive" >
        <table id="department_table" class="table border-dark length">
            <thead>
            <tr class="dp-style">
                <th class="dp-table-width">Id</th>
                <th class="dp-table-width">Name</th>
                <th class="dp-table-width">Location</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            departmenttable = $('#department_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('department.datatable') }}',
                    data: function (d) {
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
                        data: 'location',
                        name: 'location',
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

        function deleteDepartment(id) {
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
                        url: '{{ route('department.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            departmenttable.draw();
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

