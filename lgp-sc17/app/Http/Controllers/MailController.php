<?php

namespace App\Http\Controllers;

//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailController extends Controller
{
    public function sendEmail(MailerInterface $mailer, Request $request)
    {

         $this->validate($request, [
            'name' => ['required', 'string', 'max:255' ], 
            'email' => ['required', 'string', 'email', 'max:255' ],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:255']
      ]);


        $email = (new Email())
            ->from($request['email'])
            ->to('healthybyte.noreply@gmail.com')
            ->subject($request['subject'])
            ->text($request['subject']);

        $mailer->send($email);

    }
}