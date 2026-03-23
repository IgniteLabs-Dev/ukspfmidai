<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("DROP VIEW IF EXISTS view_cuti_tahunan");
        DB::statement("
        CREATE VIEW view_cuti_tahunan AS
                    WITH `max_tahun_per_user` AS (
        SELECT
            `v2`.`user_id` AS `user_id`,
            max(`v2`.`tahun`) AS `max_tahun`
        FROM
            `view_cuti_kuota` `v2`
        WHERE
            (`v2`.`is_count` = 1)
        GROUP BY
            `v2`.`user_id`
        ) SELECT
        `v`.`user_id` AS `user_id`,
        min(`v`.`cuti_type_id`) AS `cuti_type_id`,
        min(`v`.`cuti_type`) AS `cuti_type`,
        sum(
            (
            CASE
                WHEN (`v`.`tahun` = `mtu`.`max_tahun`) THEN
                greatest(0, `v`.`sisa_kuota`)
                ELSE
                greatest(0, `v`.`sisa_cuti_tersimpan`)
            END
            )
        ) AS `sisa_kuota`,
        trim(
            TRAILING ','
            FROM
            group_concat(
                REPEAT
                (
                concat(`v`.`tahun`, ','),
                greatest(
                    0,
                    floor(
                    (
                        CASE
                        WHEN (`v`.`tahun` = `mtu`.`max_tahun`) THEN
                            COALESCE(`v`.`sisa_kuota`, 0)
                        ELSE
                            COALESCE(`v`.`sisa_cuti_tersimpan`, 0)
                        END
                    )
                    )
                )
                )
                ORDER BY
                `v`.`tahun` ASC SEPARATOR ''
            )
        ) AS `uraian_tahun`
        FROM
        (`view_cuti_kuota` `v` LEFT JOIN `max_tahun_per_user` `mtu` ON ((`mtu`.`user_id` = `v`.`user_id`)))
        WHERE
        (`v`.`is_count` = 1)
        GROUP BY
        `v`.`user_id`
            ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
