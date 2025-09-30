<?php

return [
    'actions' => [
        'create' => [
            'label' => 'Nuevo :label',
        ],
        'edit' => [
            'label' => 'Editar',
        ],
        'delete' => [
            'label' => 'Eliminar',
            'modal' => [
                'heading' => 'Eliminar :label',
                'description' => '¿Estás seguro de que quieres eliminar este registro?',
                'actions' => [
                    'delete' => [
                        'label' => 'Eliminar',
                    ],
                    'cancel' => [
                        'label' => 'Cancelar',
                    ],
                ],
            ],
        ],
        'view' => [
            'label' => 'Ver',
        ],
        'save' => [
            'label' => 'Guardar cambios',
        ],
        'cancel' => [
            'label' => 'Cancelar',
        ],
    ],
    'resources' => [
        'pages' => [
            'create_record' => [
                'title' => 'Crear :label',
                'actions' => [
                    'create' => [
                        'label' => 'Crear',
                    ],
                    'create_another' => [
                        'label' => 'Crear y crear otro',
                    ],
                ],
            ],
            'edit_record' => [
                'title' => 'Editar :label',
                'actions' => [
                    'save' => [
                        'label' => 'Guardar cambios',
                    ],
                ],
            ],
            'list_records' => [
                'title' => ':label',
            ],
        ],
    ],
    'filters' => [
        'buttons' => [
            'remove_all' => [
                'label' => 'Quitar todos',
            ],
            'reset' => [
                'label' => 'Reiniciar',
            ],
        ],
        'indicator' => 'Filtros activos',
        'multi_select' => [
            'placeholder' => 'Todo',
        ],
        'select' => [
            'placeholder' => 'Todo',
        ],
        'trashed' => [
            'label' => 'Registros eliminados',
            'only_trashed' => 'Solo eliminados',
            'with_trashed' => 'Con eliminados',
            'without_trashed' => 'Sin eliminados',
        ],
    ],
    'tables' => [
        'actions' => [
            'edit' => [
                'label' => 'Editar',
            ],
            'delete' => [
                'label' => 'Eliminar',
            ],
        ],
        'bulk_actions' => [
            'delete' => [
                'label' => 'Eliminar seleccionados',
            ],
        ],
        'pagination' => [
            'label' => 'Navegación de paginación',
            'overview' => '{1} Mostrando 1 resultado|[2,*] Mostrando :first a :last de :total resultados',
            'previous' => 'Anterior',
            'next' => 'Siguiente',
        ],
        'empty' => [
            'heading' => 'No hay registros',
            'description' => 'Crea un nuevo registro para comenzar.',
        ],
    ],
    'notifications' => [
        'created' => [
            'title' => 'Creado correctamente',
        ],
        'saved' => [
            'title' => 'Guardado correctamente',
        ],
        'deleted' => [
            'title' => 'Eliminado correctamente',
        ],
    ],
];
