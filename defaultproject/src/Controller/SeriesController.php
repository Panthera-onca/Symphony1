<?php


namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistance\ObjectManager;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


class SeriesController extends \Symfony\Bundle\FrameworkBundle\Controller\AbstractController
{
    /**
     * @Route("/serie", name="serie_list")
     */

    public function list(){
        $serieRepo = $this->getDoctrine()->getRepository(Serie::class);
        $series = $serieRepo->findGoodSeries();
        dump($series);

        return $this->render('serie/list.html.twig', ["series"=>$series]);
    }

    /**
     * @Route("/serie/{id}", name="serie_detail", requirements={"id": "\d+"}, methods={"GET"})
     */
    public function detail($id, Request $request){
        $serieRepo = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $serieRepo->find($id);
        if(empty($serie)){
            throw $this->createNotFoundException("This serie does not exist");
        }
        return $this->render('serie/detail.html.twig', ["serie"=>$serie]);
    }

    /**
     * @Route("/serie/add", name="serie_add")
     */
    public function add(EntityManagerInterface $em, Request $request){
        $this->denyAccessUnlessGranted("ROLE_USER");

        
        $serie = new Serie();
        $serieForm = $this->createForm(SerieType::class, $serie);
        $serieForm->handleRequest($request);
        if ($serieForm->isSubmitted()){
            $em->persist($serie);
            $em->flush();

            $this->addFlash("success", "The series has been saved!");
            return $this->redirectToRoute('serie_detail', ['id' => $serie->getId()]);

        }

        return $this->render('serie/add.html.twig', ["serieForm"=>$serieForm->createView()]);


    }

    /**
     * @Route("/serie/delete/{id}", name="serie_delete", requirements={"id": "\d+"})
     */
    public function delete($id, EntityManagerInterface $em){
        $serieRepo = $this->getDoctrine()->getRepository(Serie::class);
        $serie = $serieRepo->find($id);

        $em->remove($serie);
        $em->flush();

        $this->addFlash('success', 'The serie has been deleted!');

        return $this->redirectToRoute('home');

    }

}