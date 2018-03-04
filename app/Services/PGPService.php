<?php

namespace App\Services;

use App\Exceptions\CommandNotFoundException;
use App\Mail\ProvisionalAuthNotification;
use App\Models\PGPModel;
use Illuminate\Http\Request;
use Mail;
use Validator;

class PGPService
{

    protected $pgp_model;


    /**
     * PGPService constructor.
     */
    public function __construct()
    {
        $this->pgp_model = new PGPModel();
    }


    /**
     * provisional register to mail with token
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function provisionalAuth(Request $request)
    {

        $ascii_armored  = $request->get('ascii-armored');
        $email_address  = $this->getEmailAddressFromAsciiArmored($ascii_armored);
        $email_token    = str_random(60);
        $is_success     = false;


        if (empty($email_address)) {
            return redirect()->route('home')
                ->withErrors(['ascii-armored' => 'Error decoding keyblock'])
                ->withInput();
        }

        // create random token
        $ascii_armored = __CLASS__ . __LINE__ . str_random(60);

        // provisional register
        $is_success = $this->pgp_model->insertProvisionalAuth($ascii_armored, $email_token);


        if (!$is_success) {
            session()->flash('message', '<h3>新規登録できませんでした。</h3>');
            return redirect()->route('home');
        }

        // send email with token
        Mail::to($email_address)->send(new ProvisionalAuthNotification($email_token));

        session()->flash('message', '<h3>新規登録しました。</h3>');
        return redirect()->route('home');
    }


    /**
     * get Email Address from Ascii Armored
     * @param $asciiArmored
     * @return array
     */
    private function getEmailAddressFromAsciiArmored($asciiArmored)
    {

        $temp = tmpfile();
        fwrite($temp, $asciiArmored);
        fseek($temp, 0);

        // ユーザIDを抽出
        $temp_result = shell_exec('pgpdump ' . stream_get_meta_data($temp)["uri"] ." | Egrep '^[[:space:]]*User ID' " . ' 2>&1');

        fclose($temp);

        // メールアドレスを抽出
        preg_match('/<(.+)>/', $temp_result, $mail_address);

        // メールアドレスが取れなければ，[]
        if (!isset($mail_address[1])) return [];

        return $mail_address[1];

    }


    /**
     * register of block chain
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify($token)
    {

        $is_verify = false;

        $is_verify = $this->pgp_model->updateVerified($token);

        if (!$is_verify) {
            session()->flash('message', '<h3>このトークンは有効ではありません</h3>');
            return redirect()->route('home');
        }


        // TODO::regist blockchain
        dd('verify Service');

    }
}