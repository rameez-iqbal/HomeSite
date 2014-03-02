<?php
// src/Mysite/HomeBundle/Controller/PageController.php

namespace Mysite\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// Import new namespaces
use Mysite\HomeBundle\Entity\Enquiry;
use Mysite\HomeBundle\Form\EnquiryType;

class PageController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()
                   ->getManager();

        $blogs = $em->getRepository('MysiteHomeBundle:Blog')
                    ->getLatestBlogs();

        return $this->render('MysiteHomeBundle:Page:index.html.twig', array(
            'blogs' => $blogs
        ));
    }

    
    public function aboutAction()
    {
        return $this->render('MysiteHomeBundle:Page:about.html.twig');
    }
    
    public function contactAction()
	{
		$enquiry = new Enquiry();
		$form = $this->createForm(new EnquiryType(), $enquiry);

		$request = $this->getRequest();
		if ($request->getMethod() == 'POST') {
			$form->bind($this->getRequest());

			if ($form->isValid()) {
				       
				$message = \Swift_Message::newInstance()
					->setSubject('Contact enquiry from symblog')
					->setFrom('rameez.iqbal@outlook.com')
					->setTo('ramiziqbal@hotmail.com')
					->setBody($this->renderView('MysiteHomeBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
				$this->get('mailer')->send($message);

				$this->get('session')->getFlashBag()->add('mysite-notice', 'Your contact enquiry was successfully sent. Thank you!');

				// Redirect - This is important to prevent users re-posting
				// the form if they refresh the page
				return $this->redirect($this->generateUrl('MysiteHomeBundle_contact'));
			}
		}

		return $this->render('MysiteHomeBundle:Page:contact.html.twig', array(
			'form' => $form->createView()
		));
	}
	
	public function sidebarAction()
	{
		$em = $this->getDoctrine()
				   ->getManager();

		$tags = $em->getRepository('MysiteHomeBundle:Blog')
				   ->getTags();

		$tagWeights = $em->getRepository('MysiteHomeBundle:Blog')
						 ->getTagWeights($tags);

		$commentLimit   = $this->container
                             ->getParameter('mysite_blog.comments.latest_comment_limit');
		$latestComments = $em->getRepository('MysiteHomeBundle:Comment')
							 ->getLatestComments($commentLimit);

		return $this->render('MysiteHomeBundle:Page:sidebar.html.twig', array(
			'latestComments'    => $latestComments,
			'tags'              => $tagWeights
		));
	}
}
