<div class="container-fluid px-4">


    <div class="table-responsive">
        <table id="room_table" class="table border-dark">
            <thead>
            <tr class="dp-style">
                <th>Id</th>
                <th>Floor No</th>
                <th>Room No</th>
                <th>Total Bed</th>
                <th>Action</th>
            </tr>
            </thead>
        </table>
    </div>

</div>
@push('scripts')
    <script>
        $(document).ready(function () {
          roomtable = $('#room_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{route('room.datatable')}}",
                columns: [
                    {
                        data: 'id',
                        name: 'id',
                        sortable: false
                    },
                    {
                        data: 'floor_no',
                        name: 'floor_no',
                        sortable: false
                    },
                    {
                        data: 'room_no',
                        name: 'room_no',
                        sortable: false
                    },
                    {
                        data: 'total_bed',
                        name: 'total_bed',
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

        function deleteRoom(id) {
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
                        url: '{{ route('room.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            roomtable.draw();
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
