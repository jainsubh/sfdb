$(document).ready(function(){
    $('.basic-ladda-button').on('click', function(e) {
        var laddaBtn = e.currentTarget;
        var l = Ladda.create(laddaBtn);
        l.start();
        setTimeout(function() {
            l.stop();
        }, 3000);
    });

    $('.example-button').on('click', function(e) {
        $('form').submit(function (event) {

            var laddaBtn = e.currentTarget;
            var l = Ladda.create(laddaBtn);
            // Start loading
            l.start();
                setTimeout(function() {
                    // Will display a progress bar for 50% of the button width
                    l.setProgress(0.5);

                    l.stop();

                }, 3000);

            // Automatically trigger the loading animation on click
            //Ladda.bind('button[type=submit]');
            });
    });
});