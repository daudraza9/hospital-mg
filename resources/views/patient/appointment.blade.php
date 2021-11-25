<div class="modal" id="view-appointment-Modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-x-blue bg-darken-2">
                <h4 id="add-edit-department-modal-heading" class="modal-title">Appointments</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                @include('partials.js-validation')
                <div class="table-responsive">
                    <table id="view_appointment_table" class="table border-dark">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Doctor Name</th>
                            <th>Fee</th>
                            <th>Date</th>
                            <th>Time</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        let patient_id = null;
        function viewAppointment(id)
        {
            patient_id = id;
            viewAppointmentTable.draw();
            $('#view-appointment-Modal').modal('show');
        }
        $(document).ready(function (){
            viewAppointmentTable = $('#view_appointment_table').DataTable({
                processing: true,
                serverSide: true,

                ajax: {
                    url:'{{route('patient.viewAppointment')}}',
                    data:function (d){
                        d.id = patient_id;
                    }
                },
                columns:[
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false
                    },
                    {
                        data: 'doctor',
                        name: 'doctor',
                        sortable:false
                    },{
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
                    }
                ]
            });
        });


    </script>
@endpush
