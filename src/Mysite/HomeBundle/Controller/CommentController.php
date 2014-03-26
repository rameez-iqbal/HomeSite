<?php
// src/Mysite/HomeBundle/Controller/CommentController.php

namespace Mysite\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Mysite\HomeBundle\Entity\Comment;
use Mysite\HomeBundle\Form\CommentType;

/**
 * Comment controller.
 */
class CommentController extends Controller
{
    public function newAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment = new Comment();
        $comment->setBlog($blog);
        $form   = $this->createForm(new CommentType(), $comment);

        return $this->render('MysiteHomeBundle:Comment:form.html.twig', array(
            'comment' => $comment,
            'form'   => $form->createView()
        ));
    }

    public function createAction($blog_id)
    {
        $blog = $this->getBlog($blog_id);

        $comment  = new Comment();
        $comment->setBlog($blog);
        $request = $this->getRequest();
        $form    = $this->createForm(new CommentType(), $comment);
        $form->bind($this->getRequest());

        if ($form->isValid()) {
			$em = $this->getDoctrine()
                       ->getManager();
            $em->persist($comment);
            $em->flush();

            return $this->redirect($this->generateUrl('MysiteHomeBundle_blog_show', array(
                'id'    => $comment->getBlog()->getId(),
				'slug'  => $comment->getBlog()->getSlug())) .
                '#comment-' . $comment->getId()
            );
        }

        return $this->render('MysiteHomeBundle:Comment:create.html.twig', array(
            'comment' => $comment,
            'form'    => $form->createView()
        ));
    }

    protected function getBlog($blog_id)
    {
        $em = $this->getDoctrine()
                    ->getManager();

        $blog = $em->getRepository('MysiteHomeBundle:Blog')->find($blog_id);

        if (!$blog) {
            throw $this->createNotFoundException('Unable to find Blog post.');
        }

        return $blog;
    }

}
