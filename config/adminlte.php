<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
     */

    'title' => 'TEAM',

    'title_prefix' => ' WETRUSTGPS ',

    'title_postfix' => ' BY WEGLOBAL.CO.LTD ',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
     */

    'logo' => '<b>WetrustGPS </b>Team',

    'logo_mini' => '<b>W</b>T',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
     */

    'skin' => 'blue',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
     */

    'layout' => 'fixed',

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
     */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
     */

    'dashboard_url' => 'home',

    'logout_url' => 'logout',

    'logout_method' => 'POST',

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
     */

    'menu' => [
        'Customers',
        [
            'text' => 'ข้อมูลลูกค้า (DLT)',
            'icon' => 'users',
            'submenu' => [
                [
                    'text' => 'ลูกค้าทั้งหมด',
                    'url' => '/sale/dashboard',
                    'icon' => 'users',
                ],
                [
                    'text' => 'เพิ่มลูกค้า',
                    'url' => '/sale/create',
                    'icon' => 'plus',
                ],

            ],
        ],
        'Devices',
        [
            'text' => 'ข้อมูลรถ (DLT)',
            'icon' => 'car',
            'submenu' => [
                [
                    'text' => 'Master File DTL',
                    'url' => '/list-all-mf',
                    'icon' => 'car',
                ],
                [
                    'text' => 'รถที่ไม่ online (DLT)',
                    'url' => '/list-all-mf-offline',
                    'icon' => 'car',
                    'icon_color' => 'red',
                ],
                [
                    'text' => 'รถที่ไม่ online (รถบ้าน)',
                    'url' => '/device-offline',
                    'icon' => 'exclamation',

                ],
                [
                    'text' => 'รถทั้งหมด เปิด/ปิด ส่งข้อมูล',
                    'url' => '/list-all-car',
                    'icon' => 'car',
                ],

                [
                    'text' => 'สถานะรถ',
                    'url' => 'device-status',
                    'icon' => 'location-arrow',
                ],
            ],
        ],

        'CRM & Support',
        [
            'text' => 'Call center',
            'url' => '/crm/call-center',
            'icon' => 'phone',
        ],
        [
            'text' => 'ค้นหาเจ้าของรถ',
            'url' => '/crm/car-owner',
            'icon' => 'tags',
        ],
        [
            'text' => 'Ticket ทั้งหมด',
            'url' => '/crm/list-all-ticket',
            'icon' => 'ticket',
        ],
        [
            'text' => 'ข้อมูลดิบ',
            'url' => '/raw-file',
            'icon' => 'history',
        ],

        'Stock GPS',
        [
            'text' => 'Stock GPS',
            'icon' => 'bars',
            'submenu' => [
                [
                    'text' => 'อุปกรณ์ทั้งหมด',
                    'url' => '/device-stock',
                    'icon' => 'bars',
                ],
                [
                    'text' => 'อุปกรณ์ที่ใช้งานแล้ว',
                    'url' => '/device-stock-used',
                    'icon' => 'bars',
                ],
                [
                    'text' => 'อุปกรณ์ที่ยังไม่ได้ใช้งาน',
                    'url' => '/device-stock-unused',
                    'icon' => 'bars',
                ],
                [
                    'text' => 'ปล่อยอุปกรณ์ให้ว่าง',
                    'url' => '/release-imei',
                    'icon' => 'paper-plane',
                ],
                [
                    'text' => 'โยนให้ Agent',
                    'url' => '/device-stock-to-agent',
                    'icon' => 'link',
                ],
            ],
        ],
        'ตัวแทน',
        [
            'text' => 'ตัวแทนทั้งหมด',
            'url' => '/agents',
            'icon' => 'cogs',
        ],
        'ฺBilling',
        [
            'text' => 'การชำระเงิน',
            'icon' => 'money',
            'submenu' => [
                [
                    'text' => 'ออก Invoive ตามชื่อลูกค้า',
                    'url' => '/payment-list',
                    'icon' => 'bars',
                ],
                [
                    'text' => 'รายงานการ ออก Invoive',
                    'url' => '/payment-history',
                    'icon' => 'link',
                    'icon-color' => 'red',
                ],
                [
                    'text' => 'สรุปการจ่ายเงิน',
                    'url' => '/payment-list-all',
                    'icon' => 'link',
                ],
            ],

        ],
        [
            'text' => 'การชำระเงินแบบเก่า',
            'icon' => 'money',
            'submenu' => [
                [
                    'text' => 'รายการที่ต้องเก็บเงิน (แบบเดิม)',
                    'url' => '/payment-list-old',
                    'icon' => 'bars',
                ],

            ],

        ],
        'ฺIMEI ที่ยกเลิก',
        [
            'text' => 'IMEI ที่ยกเลิก',
            'icon' => 'ban',
            'submenu' => [
                [
                    'text' => 'รายการที่ยกเลิกทั้งหมด',
                    'url' => '/device-canceled',
                    'icon' => 'users',
                ],

            ],

        ],

        'ฺHot Fix',
        [
            'text' => 'รายการแก้ไขเร่งด่วน',
            'icon' => 'fire',
            'submenu' => [
                [
                    'text' => 'ยืนยันข้อมูลลูกค้า',
                    'url' => '/confirm-customer',
                    'icon' => 'users',
                ],
                [
                    'text' => 'ยังไม่มีเจ้าของ',
                    'url' => '/unknow-owner',
                    'icon' => 'bars',
                ],
                [
                    'text' => 'IMEI ที่ยังไม่ได้ผูก (มีบน V3)',
                    'url' => '/device-stock-unused-run-on-v3',
                    'icon' => 'bars',
                ],

            ],

        ],

        'Tools',
        [
            'text' => 'Line token',
            'url' => '/add-line-token',
            'icon' => 'cogs',
        ],
        [
            'text' => 'Forward to Lite',
            'url' => '/forward-2-lite',
            'icon' => 'share',
        ],
        [
            'text' => 'แก้ไขทะเบียนหน้าแสดงผล',
            'url' => '/edit-plate',
            'icon' => 'location-arrow',
        ],
        [
            'text' => 'Limit speed',
            'url' => '/update-speed-limit',
            'icon' => 'sort-numeric-asc',
        ],
        [
            'text' => 'ส่งข้อมูลเข้า DLT',
            'url' => '/manual-sent-dlt',
            'icon' => 'share-square-o',
        ],
        'Servers',
        [
            'text' => 'IMEI แยก servers',
            'url' => '/list-car-on-server',
            'icon' => 'server',
        ],
        [
            'text' => 'Restart servers',
            'url' => '/reboot-server',
            'icon' => 'refresh',
        ],
        [
            'text' => 'List Images',
            'url' => '/list-images',
            'icon' => 'image',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
     */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
     */

    'plugins' => [
        'datatables' => true,
        'select2' => true,
        'chartjs' => true,
    ],
];
