<script>
    function showNewPackage() {
        document.getElementById('newPackage').style.display = 'block';
        document.getElementById('getPackagePdf').style.display = 'none';
    }
    function showGetPackagePdf() {
        document.getElementById('newPackage').style.display = 'none';
        document.getElementById('getPackagePdf').style.display = 'block';
    }
</script>

<!DOCTYPE html>
<html>
<body>
<div style="text-align: center">
    <button onclick="showNewPackage()">New package</button>
    <button onclick="showGetPackagePdf()">Get package pdf label</button>
</div>
<div id="newPackage" style="display: none">
    <form action="spring.php" method="get">
        <input name="www_request" id="www_request" value="true" style="display: none"><br>
        <input name="api" id="api" value="new_package" style="display: none"><br>
        <h1>Shipment</h1>
<?php
    $_REQUEST['api'] = 'get_default_values';
    require_once "spring.php";
    echo '<table>';
    foreach (NewPackage::getAllShipmentOptions() as $key => $option) {
        echo '<tr><td><label for="' . $key . '">' . ($option['required'] ? '*' : '') . $option['apiName'] . ': </label></td> <td><input type="text" name="' . $key . '" id="' . $key . '" value="' . $defaultValues['params'][$key] . '"> </td></tr>';
    }
    echo '</table>';
    echo '<h1>Consignor address</h1>';
    echo '<table>';
    foreach (NewPackage::getAllSenderOptions() as $key => $option) {
        echo '<tr><td><label for="' . $key . '">' . ($option['required'] ? '*' : '') . $option['apiName'] . ': </label></td> <td><input type="text" name="' . $key . '" id="' . $key . '" value="' . $defaultValues['order'][$key] . '"> </td></tr>';
    }
    echo '</table>';
    echo '<h1>Consignor address</h1>';
    echo '<table>';
    foreach (NewPackage::getAllDeliveryOptions() as $key => $option) {
        echo '<tr><td><label for="' . $key . '">' . ($option['required'] ? '*' : '') . $option['apiName'] . ': </label></td> <td><input type="text" name="' . $key . '" id="' . $key . '" value="' . $defaultValues['order'][$key] . '"> </td></tr>';
    }
echo '</table>';
?>
        <br><input type="submit" value="Create new package">
    </form>
</div>
<div id="getPackagePdf" style="display: none">
    <form action="spring.php" method="get">
        <input name="www_request" id="www_request" value="true" style="display: none"><br>
        <input name="api" id="api" value="get_label" style="display: none"><br>
        <label for="tracking_number">Enter tracking number: </label> <input type="text" name="tracking_number" id="tracking_number"> <br>
        <br><input type="submit" value="Get package label">
    </form>
</div>
</body>
</html>

