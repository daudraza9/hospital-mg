<div class="modal" id="add-room-Modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-gradient-x-blue bg-darken-2">
                <h4 id="add-edit-department-modal-heading" class="modal-title">Add Patients to Rooms</h4>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                @include('partials.js-validation')
                <form class="form" method="post" id="save-patient-form"
                      action="{{route('room.patient.store')}}">
                    {{csrf_field()}}
                    <div class="form-body">
                        <input type="hidden" value="@if(isset($room)){{$room->id}}@endif" name="room_id">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="patient">Patients</label>
                                    <select id="patient" data-field-name="Patients"
                                            class="form-control select2-reset"
                                            name="patient[]" multiple="multiple" required style="width: 100%;">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="modal-footer">
                    <button type="button" style="float: right;" id="save-person-form-btn"
                            data-loading="<i class='la la-spinner la-spin'></i> Saving..."
                            onclick="storePatient('save-patient-form');"
                            class="btn btn-success">
                        <i class="ft ft-check-square"></i> Save
                    </button>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function () {
            $('#patient').select2({
                placeholder: 'Select Patient',
                dropdownParent: $('#add-room-Modal'),
                ajax: {
                    url: '{{route('room.patient.select')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            room_id: '@if(isset($room)){{$room->id}}@endif',
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.first_name + ' ' + item.last_name + ' - ' + item.email
                                }
                            }),
                            pagination: {
                                more: (data.current_page < data.last_page)
                            }
                        };
                    },
                    cache: true
                }
            });
        });

        function addRoomPatientModal() {
            $('#add-room-Modal').modal('show');
        }

        function storePatient(form_id) {
            $.ajax({
                type: 'POST',
                url: $('#save-patient-form').attr('action'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: new FormData($('#save-patient-form')[0]),
                success: function (response) {
                    if (response.success) {
                        $('#add-room-Modal').modal('hide');
                        patienttable.draw();
                    } else {
                        if (response.success == NULL) {
                            printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                        } else {
                            printErrorMsg([response.message]);
                        }
                    }
                }
            });
        }
    </script>
@endpush
