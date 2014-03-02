<?php
// src/Mysite/HomeBundle/Controller/BlogController.php

namespace Mysite\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Blog controller.
 */
class BlogController extends Controller
{
    /**
     * Show a blog entry
     */
    public function showAction($id, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $blog = $em->getRepository('MysiteHomeBundle:Blog')->find($id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        $comments = $em->getRepository('MysiteHomeBundle:Comment')
                   ->getCommentsForBlog($blog->getId());

		return $this->render('MysiteHomeBundle:Blog:show.html.twig', array(
			'blog'      => $blog,
			'comments'  => $comments
		));
    }
}
