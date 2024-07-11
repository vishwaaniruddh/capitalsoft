<?php include ('./header.php'); ?>

<div class="page-content">
    <?php include ('./part1Dashboard.php'); ?>
    <?php include ('./part2Dashboard.php'); ?>

    <div id="part3Dashboard"></div>
</div>

<script>
    $(document).ready(function () {
        var customer = '<?php echo $customer ; ?>'
        $.ajax({
            type: "POST",
            url: "./part3Dashboard.php",
            data: {customer : customer},
            success: function (response) {
                $("#part3Dashboard").html(response);
            }
        });
    });
</script>

<?php include ('./footer.php'); ?>
