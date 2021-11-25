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
                    <button class="btn btn-primary bg-darken-2 text-white" onclick="doctortable.draw();"><i class="ft-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="doctor_table" class="table border-dark">
            <thead>
            <tr  class="dp-style">
                <th>Id</th>
                <th>Name</th>

                <th>Email</th>
                <th>Phone</th>
                <th>Title</th>
                <th width="200">Address</th>
                <th>Experience</th>
                <th width="300">Actions</th>
            </tr>
            </thead>
        </table>
    </div>
@include('doctors.appointment')
</div>

@push('scripts')
    <script>
        $(document).ready(function () {
            doctortable = $('#doctor_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{route('doctor.datatable')}}',
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
                        data: 'title',
                        name: 'title',
                        sortable:false
                    },
                    {
                        data: 'address',
                        name: 'address',
                        sortable:false
                    },
                    {
                        data: 'experience',
                        name: 'experience',
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

        function delete_doctor(id) {

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
                        url: '{{ route('doctor.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            doctortable.draw();
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
