<div class="modal" id="view-doctor_appointment-Modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-x-blue bg-darken-2">
                <h4 id="add-edit-department-modal-heading" class="modal-title">Doctor's Appointments</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <?php echo $__env->make('partials.js-validation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="table-responsive">
                    <table id="view_appointment_table" class="table border-dark">
                        <thead>
                        <tr>
                            <th>Id</th>
                            <th>Patient Name</th>
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


<?php $__env->startPush('scripts'); ?>
    <script>
        let doctor_id = null;
        function appointment(id)
        {
            doctor_id = id;
            viewdoctorAppointmentTable.draw();
            $('#view-doctor_appointment-Modal').modal('show');
        }

        $(document).ready(function (){
            viewdoctorAppointmentTable = $('#view_appointment_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url:'<?php echo e(route('doctor.viewAppointment')); ?>',
                    data:function (d){
                        d.id = doctor_id;
                    }
                },
                columns:[
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false
                    },
                    {
                        data: 'patient',
                        name: 'patient',
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
<?php $__env->stopPush(); ?>
<?php /**PATH F:\Projects\HospitalManagement\resources\views/doctors/appointment.blade.php ENDPATH**/ ?>