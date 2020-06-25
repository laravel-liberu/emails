<?php

use LaravelEnso\Migrator\Database\Migration;

class CreateStructureForEmails extends Migration
{
    protected array $permissions = [
        ['name' => 'emails.index', 'description' => 'Show index for email', 'is_default' => false],
        ['name' => 'emails.create', 'description' => 'Compose page for email', 'is_default' => false],
        ['name' => 'emails.store', 'description' => 'Save email', 'is_default' => false],
        ['name' => 'emails.update', 'description' => 'Update email', 'is_default' => false],
        ['name' => 'emails.send', 'description' => 'Send a new email', 'is_default' => false],
        ['name' => 'emails.edit', 'description' => 'Edit email', 'is_default' => false],
        ['name' => 'emails.destroy', 'description' => 'Delete email', 'is_default' => false],
        ['name' => 'emails.initTable', 'description' => 'Init table for email', 'is_default' => false],
        ['name' => 'emails.tableData', 'description' => 'Get table data for email', 'is_default' => false],
    ];

    protected array $menu = [
        'name' => 'Emails', 'icon' => 'paper-plane', 'route' => 'emails.index', 'order_index' => 250, 'has_children' => false,
    ];

    protected string $parentMenu = '';
}
