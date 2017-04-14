<?php

/**
 * .
 * Date: 15/1/9
 * Time: 10:47
 */
class SiteController extends Controller
{
    public $user = array(
        // username => password
        'playername'=>'eugene',
        'gender'=>'male',
    );

    public $prefix = "IM";

    public function actionIndex($msg=NULL)
    { echo "dsdfsdf";
        return $this->render('index',array('msg'=>$msg));
    }

    public function actionLogin()
    {
        if(Yii::app()->user->isGuest)
        {
            $model = new LoginForm;

            if(isset($_POST['LoginForm']))
            {
                $model->attributes=$_POST['LoginForm'];
                // validate user input and redirect to the previous page if valid
                if($model->validate() && $model->login())
                    return $this->redirect(Yii::app()->homeUrl);
                else
                    return $this->render('login',array('model'=>$model));
                    // $this->redirect($this->createUrl("sports/im"));
            }
            else
            {
                // display the login form
                return $this->render('login',array('model'=>$model));
            }
        }
        else
        {
            echo "already login!";
            return $this->redirect(Yii::app()->homeUrl);
        }
    }

    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

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
                // var_dump($result);exit;
                
                if ($result->succ) {
                    // $url = 'http://web.lokwen.net/?timestamp=' . $tm . '&token=' . $token . '&LanguageCode=chs';
                    $url = 'http://sbimsports.qiji7878.com/?timestamp=' . $tm . '&token=' . $token . '&LanguageCode=chs';
                    $this->redirect($url);
                } else {
                    // $this->redirect('http://sbdemo.inplaymatrix.com');
                    // $this->redirect('http://imsports.kzonlinegame.com');
                    $this->redirect('http://sbimsports.qiji7878.com');
                }
            } else {
                // $this->redirect('http://web.lokwen.net');
                $this->redirect('http://sbimsports.qiji7878.com');
            }
        }
    }

    public function actionImlogout()
    {
        // $is_login = $this->is_login();
        $is_login = true;
        $msg = "";
        if (IMSportsbook::getStatus($is_login) == 2) {
            $msg = "You are not login!";
        } else {
            $gpid = '5398046578160';
            if ($is_login) {
                $token = $this->getVCToken();//<--可以理解为用户Login后，系统会提供一个token，这里是获取token
                $name = $this->user['playername'];
                // $token = $token.NET::getServerAddr();//<--NET::getServerAddr()是获取服务器所属机房，暂不需考虑
                $im = new IMSportsbook($this->prefix, $name, $token);
                $result = $im->logout($tm);
                // var_dump($result);exit;
                
                if ($result->succ) {
                    $msg = "Logout succesfully!";
                } else {
                    $msg = "Logout failed!";
                }
            } else {
                $msg = "You are not login!";
            }
        }
        return $this->redirect(array('site/index', 'msg'=>$msg));
    }

    /**
     * Populate token
     */
    public function getVCToken()
    {
        return "1a2b3c-4d5e";
    }

    public function actionValidateToken()
    {
        $token = $this->getVCToken();

        if(isset($_GET['token']) AND $token==$_GET['token'])
        {
            $data = array("membercode"=>"test","currency"=>"RMB","ipAddress"=>"10.18.11.208","statusCode"=>"100","statusDesc"=>"Success");
            $data = json_encode($data);

            header('Content-type: application/json');
            header("Access-Control-Allow-Origin: *");
            echo ($data);
        }
    }

}