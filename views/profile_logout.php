<script src="../includes/js/jquery-3.5.1.min.js"></script>
<script src="../includes/js/main.js"></script>
<script src="../includes/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        requestAjax({'process': 'logout'}, profilesControllerURL, function (result) {
            if (result === "Success") {
                window.location.href = "..";
            }
        });
    });
</script>