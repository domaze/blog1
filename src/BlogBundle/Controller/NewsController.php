<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use OC\PlatformBundle\Services\MessageGenerator;

use BlogBundle\Entity\News;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ImageType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NewsController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(Request $request)
    {
      $titre ='mon blog';
      return $this->render('@Blog/Default/index.html.twig', array('titre'=>$titre));
    }

    public function viewAction($id)
    {
      $titre ='mon blog';
      $em = $this->getDoctrine()->getManager();
      // Pour récupérer une seule annonce, on utilise la méthode find($id)
      $news = $em->getRepository('BlogBundle:News')->find($id);


      return $this->render('@Blog/Default/view.html.twig', array('titre'=>$titre,
      'id'=>$id,
      'content'=>$news->getContent(),
      'title'=>$news->getTitle(),
      'alt'=>$news->getAlt(),
    )
    );
    }



    public function deleteAction(Request $request, $id) {
      $em = $this->getDoctrine()->getManager();
      $news = $em->getRepository('BlogBundle:News')->find($id);
      if (null === $news) {
        throw new NotFoundHttpException("L'info N° ".$id." n'existe pas");
      }
            $deleted_title = $news->getTitle();
    $em->remove($news);
    $em->flush();
      return $this->render('@Blog/Default/deleted.html.twig', array('titre'=>'monblog', 'iddeleted'=>$id)
    );
    }


/**
 * @Route("/add")
 */
public function addAction(Request $request)
  {
    $news = new News();
    $formBuilder=$this->get('form.factory')->createBuilder(FormType::class, $news);
    $formBuilder
    ->add('date', DateType::class)
    ->add('title', TextType::class)
    ->add('content', TextAreaType::class)
    ->add('image', FileType::class, ['label' => 'Image (facultative)'])
    //->add('published', CheckboxType::class)
    ->add('upload', SubmitType::class)
    ;

    $form = $formBuilder->getForm();

    if ($request->isMethod('POST'))
        {
          $form->handleRequest($request);
              if ($form->isValid()) {
                      if( (!isset($news->alt)) || (empty($news->alt)) ){$news->setAlt('à renseigner'); }
                      $news->setImage('à renseigner');
                  //    if( (!isset($news->published)) || (empty($news->published)) ){ $news->setPublished(1); }
                $em = $this->getDoctrine()->getManager();
                $em->persist($news);
                $em->flush();
                return $this->redirectToRoute('blog_view',
                ['id' => $news->getId()]);
              }
          }
    $titre ='mon blog';
    return $this->render('@Blog/Default/index.html.twig', array('titre'=>$titre, 'form'=>$form->createView(),));
    }

}
