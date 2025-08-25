<?php

return [
    // CRUD
    'crud' => [
        'user_type'   => [
            'id'            => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID'
            ],
            'type_name'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Name'
            ],
            'created_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created By'
            ],
            'updated_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated By'
            ],
            'created_at'  => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created Date'
            ],
            'action'        => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Action'
            ]
        ],
        'visitor_type'   => [
            'id'            => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID'
            ],
            'type_name'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Name'
            ],
            'created_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created By'
            ],
            'updated_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated By'
            ],
            'created_at'  => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created Date'
            ],
            'action'        => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Action'
            ]
        ],
        'users'   => [
            'id'            => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID'
            ],
            'username'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Username'
            ],
            'user_type'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Role'
            ],
            'created_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created By'
            ],
            'updated_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated By'
            ],
            'created_at'  => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created Date'
            ],
            'action'        => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Action'
            ]
        ],
        'visitor'   => [
            'id'            => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID'
            ],
            'fullname'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Full Name'
            ],
            'number'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Contact Number'
            ],
            'address'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Address'
            ],
            'visitor_type'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Visitor Type'
            ],
            'id_number'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID Number'
            ],
            'image_path'     => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Image Path'
            ],
            'visit_date'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Visit Date'
            ],
            'time_in'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Time In'
            ],
            'time_out'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Time Out'
            ],
            'created_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created By'
            ],
            'updated_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated By'
            ],
            'status'     => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Status'
            ],
            'action'        => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Action'
            ]
        ],
        'reports'   => [
            'id'            => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID'
            ],
            'fullname'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Full Name'
            ],
            'number'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Contact Number'
            ],
            'address'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Address'
            ],
            'visitor_type'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Visitor Type'
            ],
            'id_number'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID Number'
            ],
            'visit_date'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Visit Date'
            ],
            'time_in'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Time In'
            ],
            'time_out'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Time Out'
            ],
            'created_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created By'
            ],
            'updated_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated By'
            ],
            'status'     => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Status'
            ],
            'action'        => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Action'
            ]
            ],
        'registered_id'   => [
            'id'            => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID'
            ],
            'visitor_type'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'Name'
            ],
            'id_number'     => [
                'in_form'   => 1, // 0 = No, 1 = yes
                'title'     => 'ID Number'
            ],
            'created_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created By'
            ],
            'updated_by'    => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated By'
            ],
            'created_at'  => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Created Date'
            ],
            'updated_at'  => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Updated Date'
            ],
            'action'        => [
                'in_form'   => 0, // 0 = No, 1 = yes
                'title'     => 'Action'
            ]
        ],
    ]
];