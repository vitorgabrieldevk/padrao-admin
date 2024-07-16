<?php

// Função para renderizar os campos de um modelo
function SetViewModule($model) {
    $columns = $model->getAllColumns();

    foreach ($columns as $columnName => $label) {
        echo "<label for='$columnName'>$label:</label>";
        echo "<input type='text' id='$columnName' name='$columnName'><br>";
    };
};
