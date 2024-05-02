<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;


class MailerService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail(string $sendTo, int $code): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('zagidullin_zin@mail.ru', 'Kinopoisk'))
            ->to(new Address($sendTo))
            ->subject('Подтверждение регистрации')
            ->htmlTemplate('mailer/confirmation.html.twig')
            ->context([
                'username' => $sendTo,
                'code' => $code
            ])
            ->getHeaders()->addTextHeader('X-Auto-Response-Suppress', 'OOF, DR, RN, NRN, AutoReply');
        $this->mailer->send($email);
    }
}