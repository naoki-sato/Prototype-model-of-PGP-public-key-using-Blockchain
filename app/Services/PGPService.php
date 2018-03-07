<?php

namespace App\Services;

use App\Mail\ProvisionalAuthNotification;
use App\Models\PGPModel;
use App\Services\Contracts\PGPServiceInterface;
use Illuminate\Http\Request;
use Mail;

class PGPService implements PGPServiceInterface
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
        $email_token    = str_random(60); // create random token
        $is_success     = false;


        if (empty($email_address)) {
            return redirect()->route('home')
                ->withErrors(['ascii-armored' => 'Error decoding keyblock'])
                ->withInput();
        }

        // provisional register
        $is_success = $this->pgp_model->insertProvisionalAuth($ascii_armored, $email_token);


        if (!$is_success) {
            session()->flash('message', '<h3>ERROR: 503. Try again later.</h3>');
            return redirect()->route('home');
        }

        // send email with token
        Mail::to($email_address)->send(new ProvisionalAuthNotification($email_token));

        session()->flash('message', '<h3>Sent a message to your email address. ('. $email_address .') Please take a look at it.</h3>');
        return redirect()->route('home');
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
            session()->flash('message', '<h3>TokenMismatchException in VerifyEmailToken</h3>');
            return redirect()->route('home');
        }

        // register blockchain
        $ascii_armored = $this->pgp_model->getAsciiArmored($token);
        $user_id = $this->getUserIDFromAsciiArmored($ascii_armored);


        $cmd = "python3 ". __DIR__ . "/PGPTransactionService.py " . "'" . $user_id. "'". " '" . $ascii_armored ."'" .' 2>&1';
        shell_exec($cmd);

        session()->flash('message', '<h3>Register your PGP Public Key.</h3>');
        return redirect()->route('home');

    }


    /**
     * get UserID from Ascii Armored
     * @param $asciiArmored
     * @return array
     */
    private function getUserIDFromAsciiArmored($asciiArmored)
    {

        $temp = tmpfile();
        fwrite($temp, $asciiArmored);
        fseek($temp, 0);

        // ユーザIDを抽出
        $temp_result = shell_exec('pgpdump ' . stream_get_meta_data($temp)["uri"] ." | Egrep '^[[:space:]]*User ID' " . ' 2>&1');
        fclose($temp);

        // ユーザIDを抽出
        preg_match('/User ID - (.+)/', $temp_result, $user_id);

        // ユーザIDが取れなければ，[]
        if (!isset($user_id[1])) return [];

        return $user_id[1];
    }


    /**
     * get Email Address from Ascii Armored
     * @param $asciiArmored
     * @return array
     */
    private function getEmailAddressFromAsciiArmored($asciiArmored)
    {

        $user_id = $this->getUserIDFromAsciiArmored($asciiArmored);

        if (empty($user_id)) return [];

        // メールアドレスを抽出
        preg_match('/<(.+)>/', $user_id, $mail_address);

        // メールアドレスが取れなければ，[]
        if (!isset($mail_address[1])) return [];

        return $mail_address[1];
    }
}