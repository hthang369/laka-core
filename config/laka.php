<?php

return [
    'pagination' => [
        'onEachPage' => 1, // Số trang hiển thị 2 bên trang hiện tại
        'numberFirstPage' => 1, // Số trang đầu tiên cân hiển thị,
        'numberLastPage' => 1, // Số trang cuối cân hiển thị
        'perPage' => 15,
    ],
    'pager' => [
        'allowedPageSizes' => [10, 15, 20, 30, 50, 100],
        'showPageSizeSelector' => false,
        'showInfo' => true,
        'infoText' => 'table.show_result'
    ],
    'table' => [
        'sticky_header' => false
    ]
];
