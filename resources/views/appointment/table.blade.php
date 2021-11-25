<div class="container-fluid px-4">

    <div class="filters-div">
        <div class="row mt-2 mb-2">
            <div class="col-md-4 col-sm-6 col-12">
                <div class="form-group">
                    <label for="keyword">Search by Date</label>
                    <input id="keyword" type="date" class="form-control" placeholder="Enter Keyword" name="">
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-12">
                <label></label>
                <div class="form-group" style="margin-top: 6px;">
                    <button class="btn btn-primary bg-darken-2 text-white" onclick="appointmenttable.draw();"><i class="ft-search"></i> Search</button>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive mt-4">
        <table id="appointment_table" class="table border-dark">
            <thead>
            <tr class="dp-style">
                <th>Id</th>
                <th>Patient</th>
                <th>Doctor</th>
                <th>Fee</th>
                <th>Date</th>
                <th>Time</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

</div>

@push('scripts')
    <script>
        $(document).ready(function () {
           appointmenttable = $('#appointment_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'{{route('appointment.datatable')}}',
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
                        data: 'patient',
                        name: 'patient',
                        sortable:false
                    },
                    {
                        data: 'doctor',
                        name: 'doctor',
                        sortable:false
                    },
                    {
                        data: 'fee',
                        name: 'fee',
                        sortable:false
                    },
                    {
                        data: 'date',
                        name: 'date',
                        sortable:false
                    },
                    {
                        data: 'time',
                        name: 'time',
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

        function deleteAppointment(id) {
            swal({
                title: "Are you sure?",
                text: "Do you really Want to delete this User?",
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
                        url: '{{ route('appointment.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            appointmenttable.draw();
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

