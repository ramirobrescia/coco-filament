<?php

return [
    'state' => [
        'OPEN' => [
            'label' => 'ABIERTA',
            'description' => 'Se pueden realizar o modificar pedidos.'
        ],
        'CLOSED' => [
            'label' => 'CERRADA',
            'description' => 'Ya no se pueden realizar o modificar pedidos.'
        ],
        'ORDERED' => [
            'label' => 'PEDIDA',
            'description' => 'La compra fue realizada al proveedor.'
        ],
        'PREPARING' => [
            'label' => 'PREPARANDO',
            'description' => 'El proveedor está preparando la compra.'
        ],
        'DELIVERED' => [
            'label' => 'ENVIADA',
            'description' => 'El proveedor realizó el envío de la compra.'
        ],
        'RECIVED' => [
            'label' => 'RECIBIDA',
            'description' => 'El compra fue recibida por el nodo.'
        ],
    ],
    'report' => [
        'action' => [
            'label' => 'Pedido al proveedor',
            'description' => 'Resumen de la compra para enviar al proveedor.'
        ],
        'failure' => [
            'selection' => [
                'title' => 'Pedido al proveedor',
                'body' => 'Debe seleccionar solo una compra.'
            ]    
        ],
        'orders' => [
            'action' => [
                'label' => 'Pedidos de consumidores',
                'description' => 'El pedido proveedor y el de cada consumidor'
            ]
        ],
    ]
];
