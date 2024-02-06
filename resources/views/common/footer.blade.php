<footer class="sticky-footer bg-white">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your NBCC Admin</span>
        </div>
    </div>
</footer>
<script>
    //Only Digit Allow
    var elements = document.querySelectorAll('.digit-only');
    for (i in elements) {
        elements[i].onkeypress = function (e) {
            this.value = this.value.replace(/^0+/, '');
            if (isNaN(this.value + "" + String.fromCharCode(e.charCode)))
                return false;
        }
        elements[i].onpaste = function (e) {
            e.preventDefault();
        }
    }
    jQuery('.digit-only').on('keyup', function (e) {
        jQuery(this).val(jQuery(this).val().replace(/\s/g, ''));
    });


    jQuery('.char-only').keydown(function (e) {
    if (e.ctrlKey || e.altKey) {
        e.preventDefault();
    } else {
        var key = e.keyCode;
        if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
            e.preventDefault();
        }
    }
});
</script>