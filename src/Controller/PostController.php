<?php

namespace App\Controller;

use App\Form\PostType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Post;

class PostController extends AbstractController
{
    /**
     * @Route("/post/new_post", name="new_post")
     */
    public function newPost(Request $request)
    {
        $user= $this->getUser();
        //crear nuevo objeto Post
        $post= new Post();
        $post->setUser($user);
        $post->setAuthor($user->getUsername());
        $createat=$post->getCreateAt();
        //crear formulario
        $form=$this->createForm(PostType::class,$post);


        //handle the request
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){//si el formulario es enviado y valiado...
            //data capture
            $post=$form->getData();
            //flush to DB
        }

        //render the form
        return $this->render('post/post.html.twig', [
            'user'=>$user,'createat'=>$createat->format('Y-m-d H:i:s'),'form' => $form->createView()]);
    }
    /**
     * @Route("/post/ver_posts", name="ver_posts")
     */
    public function seePost(Request $request)
    {
        $user= $this->getUser();
        $posts = $this->getDoctrine()->getRepository(Post::class)->findAll();
        $max=sizeof($posts);
        $max=round($max/3);
        return $this->render('post/ver_posts.html.twig', [
            'posts' => $posts,'user'=>$user,'length'=>$max]);
    }
}
