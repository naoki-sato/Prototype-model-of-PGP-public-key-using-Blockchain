<?php

namespace App\Services\Contracts;

use Illuminate\Http\Request;

interface PGPServiceInterface
{

    /**
     * provisional register to mail with token
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function provisionalAuth(Request $request);


    /**
     * register of block chain
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($token);

}