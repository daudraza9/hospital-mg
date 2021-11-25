
<div class="container-fluid px-4">

    Hi !!! this is datatable for Manage Patient of Doctor
    <div class="table-responsive">
        <table id="patients_table" class="table border-dark">
            <thead>
            <tr>
                <th>Id</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Age</th>
                <th>Weight</th>
                <th>Address</th>
                <th>Disease</th>
                <th>Gender</th>
                <th width="100">Delete</th>
            </tr>
            </thead>
        </table>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function () {

        });

        patienttable = $('#patients_table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{route('doctor.patient.patientdatatable')}}",
                data: function (d) {
                    d.id = {{$doctor->id}};
                },
                error: function (xhr, error, thrown) {
                    console.log(error);
                },
            },
            columns: [
                {
                    data: 'id',
                    name: 'id',
                    sortable: false
                },
                {
                    data: 'first_name',
                    name: 'first_name',
                    sortable: false
                },
                {
                    data: 'last_name',
                    name: 'last_name',
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
                        url: '{{ route('doctor.patient.deletePatient') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                            'doctor_id':'@if(isset($doctor)){{$doctor->id}}@endif'
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
