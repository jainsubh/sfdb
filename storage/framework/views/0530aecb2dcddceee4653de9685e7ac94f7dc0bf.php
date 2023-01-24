<?php $__currentLoopData = session('flash_notification', collect())->toArray(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <script>
        $( document ).ready(function() {
            <?php if($message['message']) { ?>
                var type = "<?php echo e($message['level']); ?>";
                switch(type){
                    case 'info':
                        toastr.info("<?php echo e($message['message']); ?>");
                        break;

                    case 'warning':
                        toastr.warning("<?php echo e($message['message']); ?>");
                        break;

                    case 'success':
                        toastr.success("<?php echo e($message['message']); ?>");
                        break;

                    case 'danger':
                        toastr.error("<?php echo e($message['message']); ?>");
                        break;
                }
            <?php } ?>
        });
    </script>
   <?php echo e(session()->forget('flash_notification')); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


<?php /**PATH /Volumes/Data/sfdbd_new/Modules/Admin/Resources/views/flash/message.blade.php ENDPATH**/ ?>