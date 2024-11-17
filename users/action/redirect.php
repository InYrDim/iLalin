<script>
var redirectTimeout = parseInt(<?= isset($redirect_location_timeout) ? $redirect_location_timeout : 1000 ?>);
if (redirectTimeout > 0) {
    setTimeout(function() {
        location.href = "<?= $location_url ?>";
    }, redirectTimeout);
} else {
    location.href = "<?= $location_url ?>";
}
</script>