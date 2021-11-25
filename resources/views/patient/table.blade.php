<div class="container-fluid px-4">

    <div class="filters-div">
        <div class="row mt-2 mb-2">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="keyword">Search By Keyword</label>
                    <input id="keyword" type="search" class="form-control" placeholder="Enter Keyword" name="">
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
                <label></label>
                <div class="form-group" style="margin-top: 6px;">
                    <button class="btn btn-primary bg-darken-2 text-white" onclick="patienttable.draw();"><i class="ft-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="patient_table" class="table border-dark">
            <thead>
            <tr  class="dp-style">
                <th>Id</th>
                <th width="50px">Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Weight</th>
                <th>Address</th>
                <th>Disease</th>
                <th>Gender</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>
    @include('patient.appointment')
</div>
@push('scripts')
    <script>
        $(document).ready(function () {
            patienttable = $('#patient_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{route('patient.datatable')}}',
                    data: function (d) {
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
                        data: 'age',
                        name: 'age',
                        sortable: false
                    },
                    {
                        data: 'weight',
                        name: 'weight',
                        sortable: false
                    },
                    {
                        data: 'address',
                        name: 'address',
                        sortable: false
                    },
                    {
                        data: 'disease',
                        name: 'disease',
                        sortable: false
                    },
                    {
                        data: 'gender',
                        name: 'gender',
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

        function deletePatient(id) {
            swal({
                title: "Are you sure?",
                text: "Do you really Want to remove This User?",
                icon: "warning",
                buttons: {
                    No: {
                        text: "No!",
                        value: false,
                    },
                    Yes: {
                        text: "Yes!",
                        value: true,
                    }
                },
            }).then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "POST",
                        url: '{{ route('patient.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            patienttable.draw();
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
