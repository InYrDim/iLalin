<script>
var redirectTimeout = <?= isset($redirect_location_timeout) ? $redirect_location_timeout : 0 ?>;
if (redirectTimeout > 0) {
    setTimeout(function() {
        location.href = "<?= $location_url ?>";
    }, redirectTimeout);
} else {
    location.href = "<?= $location_url ?>";
}
</script>