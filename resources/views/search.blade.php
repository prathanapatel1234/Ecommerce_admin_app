{{-- <!DOCTYPE html>
<html>
<head>
    <title>Laravel 7 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

<div class="container">
    <h1>Laravel 7 Autocomplete Search using Bootstrap Typeahead JS - ItSolutionStuff.com</h1>
    <input id="tags" class="typeahead form-control" type="text">
</div>

<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    // $( "#tags" ).autocomplete({
    //   source: path
    // });

    $('#tags').autocomplete({
    serviceUrl: path,
    onSelect: function (suggestion) {
        alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    }
});


    // $('input.typeahead').typeahead({
    //     source:  function (query, process) {
    //     return $.get(path, { query: query }, function (data) {
    //             return process(data);
    //         });
    //     }
    // });
</script>

</body>
</html> --}}


