<input type='text' name='term' placeholder='Search' class='right search' id='search' />
<div id='results'><span>Start searching!</span><a href='#' class='right' id='close'><img src='pix/close.svg' class='close' /></a></div>

<script>
$(function(){
    // Search
    $('#search').focus(function(){
    	$('#results').show();
    });
    $('#close').click(function(){
		$('#results').toggle();
		return false;
	});
    $('#search').keyup(function(){
    	$.ajax({
    		type: 'get',
    		url: 'search.php',
    		data: $(this).serialize(),
    		success: function(html){
    			$('#results').html(html);
    		}
    	});
    });
});
</script>