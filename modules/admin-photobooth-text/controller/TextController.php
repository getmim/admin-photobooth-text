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
}