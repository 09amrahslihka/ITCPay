<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commands extends Model
{
    const COMMAND_ACCOUNT_PAGE = 'Account page';
    const COMMAND_ARCHIVED_ACCOUNTS_PAGE = 'Archived accounts page';
    const COMMAND_ARCHIVED_CARDS_PAGE = 'Archived cards page';
    const COMMAND_ARCHIVED_ACCOUNT_PAGE = 'Archived account page';
    const COMMAND_ARCHIVED_CARD_PAGE = 'Archived card page';
    const COMMAND_CARD_PAGE = 'Card page';

    protected $table = "commands";

    public $timestamps = true;
}