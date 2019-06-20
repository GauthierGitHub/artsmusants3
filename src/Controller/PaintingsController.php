<?php

namespace App\Controller;

use App\Entity\Paintings;
use App\Form\PaintingsType;
use App\Repository\PaintingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException; //for file upload
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("admin/paintings")
 */
class PaintingsController extends AbstractController
{
    /**
     * @Route("/", name="paintings_index", methods={"GET"})
     */
    public function index(PaintingsRepository $paintingsRepository): Response
    {
        return $this->render('paintings/index.html.twig', [
            'paintings' => $paintingsRepository->findAll(),
            'current_menu' => 'paintings',
        ]);
    }

    /**
     * @Route("/new", name="paintings_new", methods={"GET","POST"})
     */
    public function new(Request $request, Filesystem $filesystem): Response
    {
        $painting = new Paintings();
        $form = $this->createForm(PaintingsType::class, $painting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //https://symfony.com/doc/current/components/filesystem.html
            try {
                $filesystem->chmod($this->getParameter('pictures_directory'), 0777);
            } catch (IOExceptionInterface $exception) {
                echo "".$exception->getPath();
                exit();
            }

            // $file stores the uploaded PDF file bad doc in https://symfony.com/doc/current/controller/upload_file.html
            // Correction to official doc : wrong adress
            // vendor/symfony/http-foundation/File/UploadedFile.php
            /** @var Symfony\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('picture')->getData();

            //corrected : https://stackoverflow.com/questions/49604601/call-to-a-member-function-guessextension-on-string
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where pictures are stored
            try {
                $file->move(
                    $this->getParameter('pictures_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'picture' property to store the PDF file name
            // instead of its contents
            $painting->setpicture($fileName);

            // original build ... persist the $painting variable or any other work 
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($painting);
            $entityManager->flush();

            return $this->redirectToRoute('paintings_index');
        }

        return $this->render('paintings/new.html.twig', [
            'painting' => $painting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paintings_show", methods={"GET"})
     */
    public function show(Paintings $painting): Response
    {
        return $this->render('paintings/show.html.twig', [
            'painting' => $painting,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="paintings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Paintings $painting): Response
    {
        $form = $this->createForm(PaintingsType::class, $painting);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // $file stores the uploaded PDF file bad doc in https://symfony.com/doc/current/controller/upload_file.html
            // Correction to official doc : wrong adress
            // vendor/symfony/http-foundation/File/UploadedFile.php
            /** @var Symfony\HttpFoundation\File\UploadedFile $file */
            $file = $form->get('picture')->getData();;

            //corrected : https://stackoverflow.com/questions/49604601/call-to-a-member-function-guessextension-on-string
            $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();

            // Move the file to the directory where pictures are stored
            try {
                $file->move(
                    $this->getParameter('pictures_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'picture' property to store the PDF file name
            // instead of its contents
            $painting->setpicture($fileName);

            // original build ... persist the $painting variable or any other work 

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('paintings_index', [
                'id' => $painting->getId(),
            ]);
        }

        return $this->render('paintings/edit.html.twig', [
            'painting' => $painting,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="paintings_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Paintings $painting): Response
    {
        if ($this->isCsrfTokenValid('delete'.$painting->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($painting);
            $entityManager->flush();
        }

        return $this->redirectToRoute('paintings_index');
    }
    
    /**
     * @return string //needed for fileupload
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }
}
