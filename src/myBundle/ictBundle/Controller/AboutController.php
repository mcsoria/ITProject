<?php
namespace myBundle\ictBundle\Controller;

use myBundle\ictBundle\Entity\career;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AboutController extends Controller
{
	public function aboutAction()
	{

		return $this->render('myBundleictBundle:Default:about.html.twig');
	}

}