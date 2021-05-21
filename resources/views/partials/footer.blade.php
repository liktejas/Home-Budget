<!-- Main Footer -->
<footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline"></div>
    <!-- Default to the left -->
    <strong>Copyright &copy; <span id="full_year"></span> <a href="javascript:void(0)">Home Budget</a>.</strong> All rights reserved.
</footer>
<script>
    const d = new Date(); const year = d.getFullYear();
    document.getElementById('full_year').innerHTML = year;
</script>