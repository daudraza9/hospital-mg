<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('file.view-file', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div id="layoutSidenav_content">

        <div class="container-fluid px-4">

            <div class="container-fluid px-1 py-5 mx-auto">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                        <h3>Upload File</h3>

                        <div class="card" id="form-style">

                                <form id="Uppy" action="<?php echo e(route('file.store')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="file" name="file" multiple>
                                    <button type="submit">Upload</button>
                                </form>



























        </div>
                        <?php echo $__env->make('file.table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>

        let maxFileSize = 5000000;
        const Dashboard = Uppy.Dashboard;
        let fileUpload = '#Uppy';

        let uploadAjaxRoute= {
            endpoint: '<?php echo e(route('file.storeMedia')); ?>',
            formData: true,
            accept: 'application/json',
            fieldName: 'file',
            headers: {
                'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>"
            }
        }
        let options = {
            showRemoveButtonAfterComplete: true,
            proudlyDisplayPoweredByUppy: false,
            disableThumbnailGenerator: true,
            hideProgressAfterFinish: true,
            browserBackButtonClose: true,
            replaceTargetContent: true,
            showProgressDetails: true,
            doneButtonHandler: null,
            hideUploadButton: true,
            hideCancelButton: true,
            inline: true,
            height: 250,
        };

        fileUploadDashboard =  new Uppy.Core({
            autoProceed: true,
            restrictions: {
                maxFileSize: maxFileSize,
                allowedFileTypes: ['image/*','.pdf','.docx','.xlsx']
            }
        });
        options.target = fileUpload;
        fileUploadDashboard.use(Dashboard,options);
        fileUploadDashboard.use(Uppy.XHRUpload,uploadAjaxRoute);
        fileUploadDashboard.on('upload-success',(file,data)=>{
            photoUploadCallBack(file,data,fileUploadDashboard);
        });

        function photoUploadCallBack(file, data, uploaderRef){
            uploaderRef.setFileState(file.id, {
                preview: data.body.thumbnailPath
            });
            if(data.body.success) {
                isImage = true;
                notificationSuccess(data.body.message);
            }
            else {
                notificationSuccess(data.body.message);
            }
        }

        

        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        

        

        
        //
        //     var input = $(object);
        //     if (input.prop('required') && !input.val()) {
        //         input.addClass('is-invalid');
        //         input.addClass('invalid');
        //         status = false;
        //         input.siblings('span.error-text').html((input.data('field-name') !== 'undefined') ? input.data('field-name') + ' is required.' : 'is required.');
        //     }
        //     else if (input.val()) {
        //         var input_id = input.attr('id');
        //         if (input_id === 'name') {
        //             status = validate.first_name(input, status);
        //         }
        //         else {
        //             input.removeClass('is-invalid');
        //             input.siblings('span.error-text').html('');
        //         }
        //
        //     }
        //     else {
        //         input.siblings('span.select2-container--default').removeClass('invalid-select');
        //         input.removeClass('is-invalid');
        //     }
        //     return status;
        // }
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\Projects\HospitalManagement\resources\views/file/file_upload.blade.php ENDPATH**/ ?>