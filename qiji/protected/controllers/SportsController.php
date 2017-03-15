<?php

/**
 * .
 * Date: 15/1/9
 * Time: 10:47
 */
class SportsController extends Controller
{
    public $user = array(
        // username => password
        'playername'=>'eugene',
        'gender'=>'male',
    );

    public $prefix = "IM";

    /**
     * IM体育
     */
    public function actionIm()
    {
        // $is_login = $this->is_login();
        $is_login = true;
        if (IMSportsbook::getStatus($is_login) == 2) {
            $this->render('index', array('url' => '/home/wh', 'type' => 'ld', 'gpid' => ''));
        } else {
            $gpid = '5398046578160';
            if ($is_login) {
                $token = $this->getVCToken();//<--可以理解为用户Login后，系统会提供一个token，这里是获取token
                $name = $this->user['playername'];
                // $token = $token.NET::getServerAddr();//<--NET::getServerAddr()是获取服务器所属机房，暂不需考虑
                $im = new IMSportsbook($this->prefix, $name, $token);
                $result = $im->login($tm);
                // echo"<pre>";var_dump($result);exit;
                if ($result->succ) {
                    $url = 'http://imsports.kzonlinegame.com/?timestamp=' . $tm . '&token=' . $token . '&LanguageCode=chs';
                    $this->redirect($url);
                } else {
                    $this->redirect('http://imsports.kzonlinegame.com');
                }
            } else {
                $this->redirect('http://imsports.kzonlinegame.com');
            }
        }
    }

    /**
     * Populate token
     */
    public function getVCToken()
    {
        return "token1";
    }

}