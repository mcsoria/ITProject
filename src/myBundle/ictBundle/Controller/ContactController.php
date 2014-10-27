<?php
namespace myBundle\ictBundle\Controller;

use myBundle\ictBundle\Entity\career;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
	public function contactAction()
	{

		return $this->render('myBundleictBundle:Default:contact.html.twig');
	}

}