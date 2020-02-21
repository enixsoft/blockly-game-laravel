<script>
@if (auth()->guest())
window.user = undefined;       
@else
window.user = {{ auth()->user() }};
@endif 
</script>