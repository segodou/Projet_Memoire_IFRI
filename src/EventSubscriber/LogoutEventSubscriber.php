<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Event\LogoutEvent;

class LogoutEventSubscriber implements EventSubscriberInterface
{
    
    private $urlGenerator;
    private $flashBag;
    private $security;

    public function __construct(Security $security, FlashBagInterface $flashBag, UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->flashBag = $flashBag;
        $this->security = $security;

    }
    
    public function onLogoutEvent(LogoutEvent $event)
    {
        //$event->getRequest()->getSession()->getFlashBag()->add('success', 'Votre mot de passe a été restauré avec succès. Vous pouvez, vous connectez avec le nouveau mot de passe');
        //return $this->redirectToRoute('app_home');
        $this->flashBag->add(
            'success',
            'Bye Bye ' .$this->security->getUser()->getUtilisateur()
        );

        $event->setResponse(new RedirectResponse($this->urlGenerator->generate('app_home')));
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogoutEvent',
        ];
    }
}
