<?php

namespace App\Http\Controllers;

use App\Services\PGPService;
use Illuminate\Http\Request;

class PGPController extends Controller
{

    protected $pgp_service;


    /**
     * PGPController constructor.
     */
    public function __construct()
    {
        $this->middleware('exists.command');
        $this->pgp_service = new PGPService();
    }


    /**
     * view home index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('index');
    }


    /**
     * provisional register to mail with token
     *
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function provisionalAuth(Request $request)
    {
        return $this->pgp_service->provisionalAuth($request);
    }


    /**
     * register of block chain
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($token)
    {
        return $this->pgp_service->verify($token);
    }

}
