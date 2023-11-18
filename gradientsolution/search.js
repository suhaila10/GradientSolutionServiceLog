$(document).ready(function() {
    // Handle input change
    $('#searchInput').on('input', function() {
        const query = $(this).val();

        // Send the query to the server for suggestions
        $.ajax({
            url: 'get_suggestions.php',
            method: 'POST',
            data: { query: query },
            success: function(response) {
                $('#suggestions').html(response);
            }
        });
    });

    // Handle form submission
    $('#searchForm').submit(function(e) {
        e.preventDefault();
        const query = $('#searchInput').val();

        // Send the query to the server for search results
        $.ajax({
            url: 'search_records.php',
            method: 'POST',
            data: { query: query },
            success: function(response) {
                $('#searchResults').html(response);
            }
        });
    });
});
