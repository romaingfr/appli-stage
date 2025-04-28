<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetFirstSiteAsPrincipal extends Migration
{
    public function up()
    {
        // Version compatible SQLite
        $firstSites = DB::table('sites')
            ->select('client_id')
            ->selectRaw('MIN(id) as first_site_id')
            ->groupBy('client_id')
            ->get();

        foreach ($firstSites as $site) {
            DB::table('sites')
                ->where('id', $site->first_site_id)
                ->update(['principal' => true]);
        }
    }

    public function down()
    {
        DB::table('sites')->update(['principal' => false]);
    }
}
