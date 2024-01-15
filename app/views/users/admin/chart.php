<?php require APPROOT . '/views/includes/head.php';

    $chart_data = '';
    foreach ($data as $object){
        if(is_object($object)){
        $chart_data .= "{year:'".$object->year."', sales:".$object->sales.", expenses:".$object->expenses.", profit:".$object->profit."}, ";
        }
    }
    //$chart_data = substr($chart_data, 0, -2);
?>
<div id="section-landing">
    <div class="navbar">
        <?php require APPROOT . '/views/includes/adminNavigation.php';?>
    </div>
    <br>
    <br>
    <div class="containers" style="width: 100%; background-color:white">
        <h2 align="center">Financial Information</h2>
        <h2 align="center">Income Statement</h2>
        <div id="chart"></div>
    </div>
</div>
<?php require APPROOT . '/views/includes/footer.php';?>

<script>
    Morris.Bar({
        element : 'chart',
        data:[<?php echo $chart_data; ?>],
        xkey: ['year'],
        ykeys: ['profit', 'expenses', 'sales'],
        labels: ['profit', 'expenses', 'sales'],
        hideHover:'auto'
    });
</script>