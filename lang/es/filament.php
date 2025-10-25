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
        'columns' => [
            'text' => [
                'more_list_items' => 'y :count más',
            ],
        ],
        'fields' => [
            'bulk_select_page' => [
                'label' => 'Seleccionar/deseleccionar todos los elementos para acciones masivas.',
            ],
            'bulk_select_record' => [
                'label' => 'Seleccionar el elemento :key para acciones masivas.',
            ],
            'search' => [
                'label' => 'Buscar',
                'placeholder' => 'Buscar',
                'indicator' => 'Buscar',
            ],
        ],
        'pagination' => [
            'label' => 'Navegación de paginación',
            'overview' => '{1} Mostrando 1 resultado|[2,*] Mostrando :first a :last de :total resultados',
            'previous' => 'Anterior',
            'next' => 'Siguiente',
            'page' => 'Página :page',
        ],
        'selection_indicator' => [
            'selected_count' => '{1} 1 registro seleccionado|[2,*] :count registros seleccionados',
            'buttons' => [
                'select_all' => [
                    'label' => 'Seleccionar todo :count',
                ],
                'deselect_all' => [
                    'label' => 'Deseleccionar todo',
                ],
            ],
        ],
        'empty' => [
            'heading' => 'No hay registros',
            'description' => 'Crea un nuevo registro para comenzar.',
        ],
        'reorder_indicator' => 'Arrastra y suelta los registros en orden.',
        'filters' => [
            'actions' => [
                'remove' => [
                    'label' => 'Quitar filtro',
                ],
                'remove_all' => [
                    'label' => 'Quitar todos los filtros',
                    'tooltip' => 'Quitar todos los filtros',
                ],
            ],
            'indicator' => 'Filtros activos',
        ],
        'heading' => 'Tabla',
        'search' => [
            'placeholder' => 'Buscar',
        ],
        'toggleable' => [
            'label' => 'Columnas',
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
    'forms' => [
        'components' => [
            'select' => [
                'actions' => [
                    'create_option' => [
                        'label' => 'Crear',
                        'modal' => [
                            'heading' => 'Crear',
                            'actions' => [
                                'create' => [
                                    'label' => 'Crear',
                                ],
                                'create_another' => [
                                    'label' => 'Crear y crear otro',
                                ],
                            ],
                        ],
                    ],
                ],
                'no_search_results_message' => 'No se encontraron resultados.',
                'placeholder' => 'Selecciona una opción',
                'search_prompt' => 'Empieza a escribir para buscar...',
            ],
            'file_upload' => [
                'editor' => [
                    'actions' => [
                        'cancel' => [
                            'label' => 'Cancelar',
                        ],
                        'drag_crop' => [
                            'label' => 'Modo arrastrar "recortar"',
                        ],
                        'drag_move' => [
                            'label' => 'Modo arrastrar "mover"',
                        ],
                        'flip_horizontal' => [
                            'label' => 'Voltear imagen horizontalmente',
                        ],
                        'flip_vertical' => [
                            'label' => 'Voltear imagen verticalmente',
                        ],
                        'move_down' => [
                            'label' => 'Mover imagen hacia abajo',
                        ],
                        'move_left' => [
                            'label' => 'Mover imagen hacia la izquierda',
                        ],
                        'move_right' => [
                            'label' => 'Mover imagen hacia la derecha',
                        ],
                        'move_up' => [
                            'label' => 'Mover imagen hacia arriba',
                        ],
                        'reset' => [
                            'label' => 'Restablecer',
                        ],
                        'rotate_left' => [
                            'label' => 'Rotar imagen hacia la izquierda',
                        ],
                        'rotate_right' => [
                            'label' => 'Rotar imagen hacia la derecha',
                        ],
                        'save' => [
                            'label' => 'Guardar',
                        ],
                        'zoom_100' => [
                            'label' => 'Ampliar imagen al 100%',
                        ],
                        'zoom_in' => [
                            'label' => 'Acercar',
                        ],
                        'zoom_out' => [
                            'label' => 'Alejar',
                        ],
                    ],
                ],
            ],
            'key_value' => [
                'actions' => [
                    'add' => [
                        'label' => 'Agregar fila',
                    ],
                    'delete' => [
                        'label' => 'Eliminar fila',
                    ],
                ],
                'fields' => [
                    'key' => [
                        'label' => 'Clave',
                    ],
                    'value' => [
                        'label' => 'Valor',
                    ],
                ],
            ],
            'repeater' => [
                'actions' => [
                    'add' => [
                        'label' => 'Agregar a :label',
                    ],
                    'delete' => [
                        'label' => 'Eliminar',
                    ],
                    'clone' => [
                        'label' => 'Clonar',
                    ],
                    'reorder' => [
                        'label' => 'Mover',
                    ],
                    'move_down' => [
                        'label' => 'Mover hacia abajo',
                    ],
                    'move_up' => [
                        'label' => 'Mover hacia arriba',
                    ],
                    'collapse' => [
                        'label' => 'Contraer',
                    ],
                    'expand' => [
                        'label' => 'Expandir',
                    ],
                    'collapse_all' => [
                        'label' => 'Contraer todo',
                    ],
                    'expand_all' => [
                        'label' => 'Expandir todo',
                    ],
                ],
            ],
            'rich_editor' => [
                'dialogs' => [
                    'link' => [
                        'actions' => [
                            'link' => 'Enlazar',
                            'unlink' => 'Desenlazar',
                        ],
                        'label' => 'URL',
                        'placeholder' => 'Ingresar una URL',
                    ],
                ],
                'toolbar_buttons' => [
                    'attach_files' => 'Adjuntar archivos',
                    'blockquote' => 'Cita',
                    'bold' => 'Negrita',
                    'bullet_list' => 'Lista con viñetas',
                    'code_block' => 'Bloque de código',
                    'h1' => 'Título',
                    'h2' => 'Encabezado',
                    'h3' => 'Subencabezado',
                    'italic' => 'Cursiva',
                    'link' => 'Enlace',
                    'ordered_list' => 'Lista numerada',
                    'redo' => 'Rehacer',
                    'strike' => 'Tachado',
                    'undo' => 'Deshacer',
                ],
            ],
        ],
    ],
];
