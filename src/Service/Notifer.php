<?php
/**
 * Created by PhpStorm.
 * User: halex
 * Date: 03.02.19
 * Time: 16:26
 */

namespace App\Service;

use Swift_Mailer;

class Notifer
{
    private $mailer;

    private $adminEmail;

    public function __construct(Swift_Mailer $mailer, $adminEmail)
    {
        $this->mailer = $mailer;
        $this->adminEmail = $adminEmail;
    }

    public function notifyAdmin()
    {
        $message = (new \Swift_Message('New article'))
            ->setFrom('admin@ghblog.loc')
            ->setTo($this->adminEmail)
            ->addPart('New article has been added to GHblog')
            ;
        return $this->mailer->send($message)>0;
    }

    public function notifyAuthor(string $authorEmail)
    {
        $message = (new \Swift_Message('New comment'))
            ->setFrom('admin@ghblog.loc')
            ->setTo($authorEmail)
            ->addPart('New comment has been added to your article')
        ;
        return $this->mailer->send($message)>0;
    }
}
