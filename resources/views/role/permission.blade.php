@extends('layouts.master')
@section('content')

    <div id="layoutSidenav_content">
        <main>
            <form method="post" action="{{route('role.permissionUpdate',['id'=>$role->id])}}" id="save-permission-form">
                {{csrf_field()}}
                <input type="hidden" name="role_id" value="{{ $role->id }}">
                <div class="row skin skin-square">
                    <div class="col-md-12 col-sm-12">
                        <fieldset>
                            <input type="checkbox" id="input-select-all" name="select-all" @if(isset($role) && $role->permissions()->count() > 0) checked @endif>
                            <label for="input-select-all">Select All</label>
                        </fieldset>
                    </div>
                    <div class="col-md-12 col-sm-12">
                        <div class="ml-3 mt-2">
                            @foreach(permissions as $key => $permission)
                                <fieldset>
                                    <input type="checkbox" class="permissions" id="input-{{ $key }}" name="{{ $key }}" @if(isset($role) && $role->hasPermissionTo($permission)) checked @endif>
                                    <label for="input-{{ $key }}">{{ $permission }}</label>
                                </fieldset>
                            @endforeach
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <a href="{{ route('role.index') }}"  class="btn grey btn-danger" >Cancel</a>
                <button type="button" class="btn btn-success" onclick="savePermission('save-permission-form');">Save</button>
            </div>
        </main>

    </div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {

        $("#input-select-all").on('ifChanged', function (e) {
            PermissionsSetting($(this));
        });

        PermissionsSetting($('#input-select-all'));
    });
    function PermissionsSetting(ele) {
        @foreach(permissions as $key => $permission)
        if(ele.is(':checked')) {
            @if($role->hasPermissionTo($permission))
            $('#input-{{ $key }}').iCheck('check');
            @else
            $('#input-{{ $key }}').iCheck('uncheck');
            @endif
        }else{
            $('.permissions').iCheck('uncheck');
        }
        @endforeach
    }

    function savePermission(form_id)
    {

        var status = true;
        $("form#" + form_id + " :input").each(function () {
            status = validation(this, status);
        });

        if (status === true) {
            $.ajax({
                type: 'POST',
                url: $('#save-permission-form').attr('action'),
                dataType: "json",
                processData: false,
                contentType: false,
                data: new FormData($('#save-permission-form')[0]),
                success: function (response) {
                    if (response.success) {
                        console.log(response.success);
                        window.location = '{{route('role.index')}}';
                    } else {
                        console.log(response.error);
                        if (response.success == NULL) {
                            printErrorMsg(['Something Went Wrong, please Reload or try Again Later!']);
                        } else {
                            printErrorMsg([response.message]);
                        }
                    }
                }
            });
        }else{
            return status;
        }
    }
    function validation(object, status) {
        var input = $(object); // This is the jquery object of the input, do what you will
        if (input.prop('required') && !input.val()) {

            input.addClass('is-invalid');
            status = false;
            input.siblings('span.select2-container--default').addClass('invalid-select');
            input.siblings('div.invalid-feedback').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');

        } else {
            input.siblings('span.select2-container--default').removeClass('invalid-select');
            input.removeClass('is-invalid');
            input.addClass('is-valid');
            // status = true;
        }

        return status;
    }
</script>
@endpush

