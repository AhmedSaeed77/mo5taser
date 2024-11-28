<script>

    $("#pac-input").focusin(function() {
        $(this).val('');
    });

    $('#latitude').val('');
    $('#longitude').val('');

    function initAutocomplete() {

        var input = document.getElementById('search_map');
        var autocomplete = new google.maps.places.Autocomplete(input);

    }

</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCiLiP7yN19IETSMdiZEcu_QjjeNaPyGak&libraries=places&callback=initAutocomplete&language=ar&region=EG
     async defer"></script>
