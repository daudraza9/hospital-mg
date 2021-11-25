@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <div class="filters-div">
                <div class="row mt-2 mb-2">
                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="user-filter-role">Roles</label>
                            <div class="position-relative has-icon-left">
                                <select class="form-control select2-reset"
                                        style="width: 100%;"
                                        id="role" name="role[]">
                                    <option></option>
                                </select>
                                <div class="invalid-feedback">
                                    Please enter data.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                            <label for="keyword">Keyword Search</label>
                            <input id="keyword" type="search" class="form-control" placeholder="Enter Keyword" name="">
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 col-12">
                        <label></label>
                        <div class="form-group" style="margin-top: 6px;">
                            <button class="btn btn-primary bg-darken-2 text-white" onclick="Usertable.draw();"><i
                                    class="ft-search"></i> Search
                            </button>
                        </div>
                    </div>
                </div>
            </div>


            <div class="container table-responsive">

                <table id="user_table" class="table border-dark">
                    <thead>
                    <tr class="dp-style">
                        <th>Id</th>
                        <th>Name</th>

                        <th>Email</th>

                        <th width="300">Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </main>
        <a href="{{ route('pdf.generate')}}"> <button> Download Pdf</button></a>
    </div>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Profile Picture</h4>
                </div>
                <div class="modal-body">
                    <img width="200px">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).ready(function () {
            $('#role').select2({
                placeholder: 'Select Role',
                ajax: {
                    url: '{{route('role.roleSelect')}}',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term,
                            page: params.page || 1
                        };
                    },
                    processResults: function (data) {
                        return {
                            results: $.map(data.data, function (item) {
                                return {
                                    id: item.id,
                                    text: item.name
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
        Usertable = UserTable();

        function UserTable() {
            return $('#user_table').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": false,
                "pageLength": 10,
                "order": [],
                ajax: {
                    url: "{{route('user.datatable')}}",
                    data: function (d) {
                        d.keyword = $('#keyword').val();
                        d.role = $('#role').val();
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: true
                    }

                ]
            });
        }

        function viewProfile(id) {
            imageUrl = id;
            img = document.querySelector("img");
            img.src = imageUrl;
            $('#myModal').modal('show');
        }

        function deleteUser(id) {
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
                        url: '{{ route('user.delete') }}',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': id,
                        },
                        dataType: 'json',
                        success: function (data) {
                            Usertable.draw();
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
