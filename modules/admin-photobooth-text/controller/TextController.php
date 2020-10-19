<?php
/**
 * TextController
 * @package admin-photobooth-text
 * @version 0.0.1
 */

namespace AdminPhotoboothText\Controller;

use LibForm\Library\Form;
use LibSms\Library\Sms;
use Photobooth\Model\Photobooth as Photobooth;
use LibFormatter\Library\Formatter;

class TextController extends \Admin\Controller
{
    public function sendAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_photobooth)
            return $this->show404();

        $id = $this->req->param->id;
        $pbooth = Photobooth::getOne(['id'=>$id]);
        if(!$pbooth)
            return $this->show404();

        $reff = $this->req->get('reff');
        if(!$reff)
            $reff = $this->router->to('adminPhotobooth');
        $rsign = strstr($reff, '?') ? '&' : '?';

        $form = new Form('admin.photobooth.sms');
        if(!$form->csrfTest('noob'))
            return $this->res->redirect($reff);

        $text = $this->req->get('content');

        $error = null;
        if(!Sms::send($pbooth->phone, $text))
            $error = Sms::lastError();

        if($error)
            $reff.= $rsign . 'sms-error=' . $error;
        else
            Photobooth::inc(['texted'=>1], ['id'=>$id]);

        $this->res->redirect($reff);
    }

    public function textAction(){
        if(!$this->user->isLogin())
            return $this->loginFirst(1);
        if(!$this->can_i->manage_photobooth)
            return $this->show404();

        $id     = $this->req->param->id;
        $pbooth = Photobooth::getOne(['id'=>$id]);
        $text   = $this->config->adminPhotoBoothText->text;
        $params = [
            'fullname' => $pbooth->fullname,
            'phone'    => $pbooth->phone,
            'url'      => ''
        ];

        $pbooth = Formatter::format('photobooth', $pbooth);
        $params['url'] = $pbooth->page;

        if(module_exists('lib-shorturl')){
            $short_url = Shortener::shorten($params['url']);
            if($short_url)
                $params['url'] = $short_url;
        }

        foreach($params as $key => $val)
            $text = str_replace('(:' . $key .')', $val, $text);

        $this->ajax(0, $text);
    }
}