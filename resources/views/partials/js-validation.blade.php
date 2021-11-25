
<div class="alert bg-danger alert-dismissible mb-2 print-error-msg" role="alert" style="display:none">
    <button type="button" class="close" onclick="displayNone()" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="alert-heading mb-2">Error!</h4>
    <ul></ul>
</div>

@push('scripts')
    <script>
        function displayNone(){
            $(".print-error-msg").css('display','none');
        }
    </script>
@endpush
