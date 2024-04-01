<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    
    <title>SCAN</title>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            setInterval(function(){
                $("#cekkartu").load('bacakartu.php')
            }, 1000);
        });
    </script>

</head>
<body>
    <?php include "menu.php"; ?>
    
    <div class="container-fluid">
<div id="cekkartu"></div>
    </div>


    <?php  include "footer.php"   ?>
    
</body>
</html>