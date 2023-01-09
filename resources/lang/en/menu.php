<?php
return [
  'sidebar' => [
      'employee' => [
          'title' => "Ghora",
          'icon' => 'flaticon-settings',
          'route' => false,
          'children' => [
              'list.view' => [
                  'title' => 'List',
                  'icon' => false,
                  'route' => 'employee.list.view'
              ],
              'pist' => [
                  'title' => 'List',
                  'icon' => false,
                  'route' => 'employee.list.view'
              ],
          ]
      ]
  ]
];
