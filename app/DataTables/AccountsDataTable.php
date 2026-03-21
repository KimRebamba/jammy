<?php

namespace App\DataTables;

use Illuminate\Support\Facades\DB;

class AccountsDataTable
{
    public static function get()
    {
        return DB::table('accounts')
            ->select(
                'user_id as ID',
                'username as Username',
                'email as Email',
                'profile_photo_url as Picture',
                'role as Role',
                'is_active as Active',
                'email_verified_at as VerifiedAt'
            )
            ->orderBy('user_id')
            ->get();
    }
}
