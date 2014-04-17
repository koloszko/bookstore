<?php

namespace Bookstore\DemoBundle\Listener;

class NumberFormatChanger {

    protected $twig;

    public function __construct($twig) {
        $this->twig = $twig;
    }

    public function onKernelRequest() {       
        $this->twig->getExtension('core')->setNumberFormat(2, ',', '');
    }

}
