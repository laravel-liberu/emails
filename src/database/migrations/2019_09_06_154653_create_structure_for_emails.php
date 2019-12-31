<?php

use LaravelEnso\Migrator\App\Database\Migration;
use LaravelEnso\Permissions\App\Enums\Types;

class CreateStructureForEmails extends Migration
{
    protected $permissions = [
        ['name' => 'emails.index', 'description' => 'Show index for email', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'emails.create', 'description' => 'Compose page for email', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'emails.store', 'description' => 'Save email', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'emails.update', 'description' => 'Update email', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'emails.send', 'description' => 'Send a new email', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'emails.edit', 'description' => 'Edit email', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'emails.destroy', 'description' => 'Delete email', 'type' => Types::Write, 'is_default' => false],
        ['name' => 'emails.initTable', 'description' => 'Init table for email', 'type' => Types::Read, 'is_default' => false],
        ['name' => 'emails.tableData', 'description' => 'Get table data for email', 'type' => Types::Read, 'is_default' => false],
    ];

    protected $menu = [
        'name' => 'Emails', 'icon' => 'paper-plane', 'route' => 'emails.index', 'order_index' => 250, 'has_children' => false,
    ];

    protected $parentMenu = '';
}
