<?php

return [
    "content" => [
        "group" => "Contenido",
        "posts" => [
            "title" => "Posts",
            "single" => "Post",
            "sections" => [
                "type" => [
                    "title" => "Tipo",
                    "description" => "Ajustes del tipo",
                    "columns" => [
                        "type" => "Tipo",
                    ]
                ],
                "post" => [
                    "title" => "Datos del Post",
                    "description" => "Crear un nuevo post",
                    "columns" => [
                        "title" => "Título",
                        "slug" => "Slug",
                        "body" => "Cuerpo",
                    ]
                ],
                "seo" => [
                    "title" => "SEO",
                    "description" => "Ajustes de SEO",
                    "columns" => [
                        "short_description" => "Descriptción corta",
                        "keywords" => "Palabras clave",
                    ]
                ],
                "meta" => [
                    "title" => "Meta",
                    "description" => "Ajustes de meta",
                    "columns" => [
                        "meta_url" => "Meta URL",
                        "meta" => "Meta",
                        "meta_redirect" => "Meta Redirect",
                        "github_starts" => "Github Stars",
                        "github_watchers" => "Github Watchers",
                        "github_forks" => "Github Forks",
                        "downloads_total" => "Downloads Total",
                        "downloads_monthly" => "Downloads Monthly",
                        "downloads_daily" => "Downloads Daily",
                    ]
                ],
                "images" => [
                    "title" => "Imágenes",
                    "description" => "Ajuste de imágenes",
                    "columns" => [
                        "images" => "Galería",
                        "feature_image" => "Destacada",
                        "cover_image" => "Portada",
                    ]
                ],
                "author" => [
                    "title" => "Autor",
                    "description" => "Ajustes del autor",
                    "columns" => [
                        "author_type" => "Tipo",
                        "author" => "Autor",
                    ]
                ],
                "status" => [
                    "title" => "Estado",
                    "description" => "Ajustes de estado",
                    "columns" => [
                        "type" => "Tipo",
                        "is_published" => "Publicado",
                        "is_trend" => "Tendencia",
                        "published_at" => "Publicado el",
                        "likes" => "Likes",
                        "views" => "Vistas",
                        "categories" => "Categorías",
                        "tags" => "Etiquetas",
                    ]
                ]
            ],
            "import" => [
                "button" => "Importar desde URL",
                "youtube_type" => "Importar desde TouTube",
                "behance_type" => "Importar desde Behance",
                "github_type" => "Importar desde Github",
                "url" => "URL",
                "redirect_url" => "URL de redirección",
                "notifications" => [
                    "title" => "Importado correctamente",
                    "description" => "El post ha sido importado correctamente",
                ],
                "youtube" => [
                    "notifications" => [
                        "title" => "Video de Youtube importado",
                        "description" => "El video ha sido importado correctamente",
                        "view" => "Ver Post",
                        "failed_title" => "Falló la importación del video de YouTube.",
                        "failed_description" => "La importación del video ha fallado",
                    ]
                ],
                "behance" => [
                    "notifications" => [
                        "title" => "Proyecto Behance importado",
                        "description" => "El proyecto ha sido importado correctamente",
                        "failed_title" => "Falló la importación del proyecto Behance",
                        "failed_description" => "La importación del proyecto ha fallado",
                    ]
                ],
                "github" => [
                    "notifications" => [
                        "title" => "Repositorio Github Importado",
                        "description" => "El repositorio ha sido importado correctamente",
                        "view" => "Ver Post",
                        "failed_title" => "Falló la importación del repositorio Github",
                        "failed_description" => "La importación del repositorio ha fallado",
                    ]
                ]
            ]
        ],
        "category" => [
            "title" => "Categorías",
            "single" => "Categoría",
            "sections" => [
                "details" => [
                    "title" => "Datos de la Categoría",
                    "description" => "Crear una nueva categoría",
                    "columns" => [
                        "name" => "Nombre",
                        "slug" => "Slug",
                        "description" => "Descripción",
                        "icon" => "Ícono",
                        "color" => "Color",
                    ]
                ],
                "status" => [
                    "title" => "Estado",
                    "description" => "Ajustes de estado",
                    "columns" => [
                        "parent_id" => "Padre",
                        "type" => "Tipo",
                        "for" => "Para",
                        "is_active" => "Activa",
                        "show_in_menu" => "Mostrar en menú",
                    ]
                ]
            ]
        ],
        "comments" => [
            "title" => "Comentarios",
            "single" => "Comentario",
            "columns" => [
                "user_type" => "Tipo de usuario",
                "user_id" => "Usuario|",
                "content_id" => "ID de contenido",
                "content_type" => "Tipo de contenido",
                "comment" => "Comentario",
                "rate" => "Valoración",
                "is_active" => "Activo",
                "created_at" => "Creado el",
                "updated_at" => "Actualizado el",
            ]
        ]
    ],
    "types" => [
        'post' => 'Post',
        'video' => 'Video',
        'audio' => 'Audio',
        'gallary' => 'Galería',
        'link' => 'Link',
        'open-source' => 'Open Source',
        'info' => 'Info',
        'event' => 'Evento',
        'quote' => 'Cita',
        'default' => 'Desconocido',
        'category' => 'Categoría',
        'tags' => 'Estiquetas',
        'skill' => 'Habilidad',
        'testimonials' => 'Testomonio',
        'feature' => 'Característica',
        'page' => 'Página',
        'faq' => 'FAQ',
        'builder' => 'Builder',
        'service' => 'Servicio',
        'portfolio' => 'Portfolio',
    ],
    "themes" => [
        "title" => "Themes",
        "single" => "Theme",
        "actions" => [
            "active" => "Habilitar",
            "disable" => "Deshabilitar",
        ],
        "notifications" => [
            "autoload" => [
                "title" => "Autoload Error",
                "body" => "The theme autoload class does not exist",
            ],
            "enabled" => [
                "title" => "Theme Enabled",
                "body" => "The theme has been enabled successfully",
            ],
            "disabled" => [
                "title" => "Theme Disabled",
                "body" => "The theme has been disabled successfully",
            ],
            "deleted" => [
                "title" => "Theme Deleted",
                "body" => "The theme has been deleted successfully",
            ],
        ],
    ],
    "forms" => [
        "section" => [
            "information" => "Form Information"
        ],
        "title" => "Form Builder",
        "single" => "Form",
        "columns" => [
            "type" => "Type",
            "method" => "Method",
            "title" => "Title",
            "key" => "Key",
            "description" => "Description",
            "endpoint" => "Endpoint",
            "is_active" => "Is Active",
        ],
        "fields" => [
            "title" => "Fields",
            "single" => "Field",
            "columns" => [
                "type" => "Type",
                "name" => "Name",
                "group" => "Group",
                "default" => "Default",
                "is_relation" => "Is Relation",
                "relation_name" => "Relation Name",
                "relation_column" => "Relation Column",
                "sub_form" => "Sub Form",
                "is_multi" => "Is Multi",
                "has_options" => "Has Options",
                "options" => "Options",
                "label" => "Label",
                "value"=> "Value",
                "placeholder" => "Placeholder",
                "hint" => "Hint",
                "is_required" => "Is Required",
                "required_message" => "Required Message",
                "has_validation" => "Has Validation",
                "validation" => "Validation",
                "rule" => "Rule",
                "message" => "Message"
            ],
            "tabs" => [
                "general" => "General",
                "options" => "Options",
                "validation" => "Validation",
                "relation" => "Relation",
                "labels" => "Labels",
            ],
            "actions" => [
                "preview" => "Preview",
            ]
        ],
        "requests" => [
            "title" => "Form Requests",
            "single" => "Request",
            "columns" => [
                "status" => "Status",
                "description" => "Description",
                "time" => "Time",
                "date" => "Date",
                "payload" => "Payload",
                "pending" => "Pending",
                "processing" => "Processing",
                "completed" => "Completed",
                "cancelled" => "Cancelled",

            ]
        ]
    ],
    "tickets" => [
        "title" => "Tickets",
        "single" => "Ticket"
    ]
];
