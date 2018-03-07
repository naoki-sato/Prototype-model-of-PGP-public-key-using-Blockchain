<?php

namespace App\Models;

use DB;
use Log;
use Carbon\Carbon;
use PDOException;

class PGPModel
{

    /**
     *
     * @param $asciiArmored
     * @param $emailToken
     * @return bool
     */
    public function insertProvisionalAuth($asciiArmored, $emailToken)
    {

        $date = Carbon::now();

        try {

            DB::connection('pgp')->table('pgp_registration')->insert(
                [
                    'ascii_armored' => $asciiArmored,
                    'email_token'   => $emailToken,
                    'created_at'    => $date,
                    'updated_at'    => $date
                ]
            );
        } catch (PDOException $exception) {

            return false;
        }

        return true;
    }


    /**
     * @param $token
     * @return bool
     */
    public function updateVerified($token)
    {

        $date = Carbon::now();

        try {

            $result = DB::connection('pgp')->table('pgp_registration')
                ->where('email_token', '=', $token)
                ->where('verified', '=', 0)
                ->where('created_at', '>=', $date->subHour())
                ->update([
                    'verified'      => 1,
                    'updated_at'    => $date
                ]);

        } catch (PDOException $exception) {

            return false;
        }

        // 更新できる対象がない，または，すでに更新済みで更新する必要がない場合
        if (!$result) return false;

        return true;
    }


    /**
     * get AsciiArmored by token
     * @param $token
     * @return array
     */
    public function getAsciiArmored($token)
    {
        try {

            $result = DB::connection('pgp')->selectOne(
                'SELECT ascii_armored
                FROM pgp_registration
                WHERE
                    email_token = :email_token AND
                    verified = 1',
                [
                    'email_token' => $token
                ]
            );

        } catch (PDOException $exception) {

            return [];
        }

        if (!$result) return [];

        return $result->ascii_armored;
    }
}