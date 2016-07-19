<?php

$productController = new productController();

$productController->importCenikuAction();
?>

<h1>Natažení ceníku produktů</h1>
<?php
print $g->get_result_message2();
?>
<form class="standard_form add_form" enctype="multipart/form-data" method="post" action="" name="registerform">

<input type="file" name="Filedata" id="">
<input type="submit" name="import_products" value="Importovat">
</form>