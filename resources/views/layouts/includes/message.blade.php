
@foreach (session('flash_notification', collect())->toArray() as $message)
    <script>
        $( document ).ready(function() {
            <?php if($message['message']) { ?>
                var type = "{{ $message['level'] }}";
                toastr.options = {
                    positionClass : 'toast-bottom-right',
                }
                switch(type){
                    case 'info':
                        toastr.info("{{ $message['message'] }}");
                        break;

                    case 'warning':
                        toastr.warning("{{ $message['message'] }}");
                        break;

                    case 'success':
                        toastr.success("{{ $message['message'] }}");
                        break;

                    case 'danger':
                        toastr.error("{{ $message['message'] }}");
                        break;
                }
            <?php } ?>
        });
    </script>
   {{ session()->forget('flash_notification') }}
@endforeach


