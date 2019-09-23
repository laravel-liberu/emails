<?php

use LaravelEnso\Migrator\app\Database\Migration;

class CreateStructureForEmails extends Migration
{
    protected $permissions = [
        ['name' => 'emails.index', 'description' => 'Show index for email', 'type' => 0, 'is_default' => false],
        ['name' => 'emails.send', 'description' => 'Send a new email', 'type' => 1, 'is_default' => false],
        ['name' => 'emails.show', 'description' => 'Show email', 'type' => 1, 'is_default' => false],
        ['name' => 'emails.draft', 'description' => 'Save email as draft', 'type' => 1, 'is_default' => false],
        ['name' => 'emails.destroy', 'description' => 'Delete email', 'type' => 1, 'is_default' => false],
        ['name' => 'emails.initTable', 'description' => 'Init table for email', 'type' => 0, 'is_default' => false],
        ['name' => 'emails.tableData', 'description' => 'Get table data for email', 'type' => 0, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Emails', 'icon' => 'paper-plane', 'route' => 'emails.index', 'order_index' => 30, 'has_children' => false
    ];

    protected $parentMenu = '';
}
