jQuery( function($) {
    $(document).ready( function() {
        $("table.matches a.show-all").click(function(event){
            event.preventDefault();

            $("table.matches tr.hide").show();

            $(this).parent().parent().remove();
        });
    })
});
