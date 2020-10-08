<?php

namespace App\Controller;

use App\Controller\Utils\Utils;
use App\Entity\Picture;
use App\Entity\Vehicle;
use App\Form\VehicleType;
use App\Repository\PictureRepository;
use App\Repository\VehicleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/vehicule")
 */
class VehicleController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Route("/?type={type}&page={currentPage}", name="app_vehicle", methods={"GET"}, requirements={"currentPage"="\d+"})
     *
     * @param VehicleRepository $vehicleRepository
     * @param Request $request
     * @return Response
     */
    public function index(Request $request ,VehicleRepository $vehicleRepository, string $type = Utils::TYPE_ALL ,int $currentPage = 1): Response
    {      
        $limit = Utils::LIMIT;
        $type = $request->attributes->get(Utils::TYPE_ANONCES);
        switch($type) {
            case Utils::TYPE_ALL:
                $vehicles = $vehicleRepository->findAllVehicle($currentPage, $limit);
                $allVehicles = $vehicleRepository->findAll();
                $pagesNb = ceil(count($allVehicles) / $limit);
            break;

            case Utils::TYPE_SALE:
                    $pagesNb = ceil(count($vehicleRepository->findBy(['sale' => 'vente'])) / $limit);
                $vehicles = $vehicleRepository->findBy(
                    ['sale' => 'vente'],
                    ['createdAt' => 'DESC'],
                    $limit,
                    ($currentPage - 1) * $limit
                );
            break;

            case Utils::TYPE_RENT:
                    $pagesNb = ceil(count($vehicleRepository->findBy(['sale' => 'location'])) / $limit);
            
                $vehicles = $vehicleRepository->findBy(
                    ['sale' => 'location'],
                    ['createdAt' => 'DESC'],
                    $limit,
                    ($currentPage - 1) * $limit
                );
            break;

            case Utils::MY_ANNONCES:
                $user = $this->getUser();
                $pagesNb = ceil(count($vehicleRepository->findBy(['user' => $user->getId()])) / $limit);
            
                $vehicles = $vehicleRepository->findBy(
                    ['user' => $user->getId()],
                    ['createdAt' => 'DESC'],
                    $limit,
                    ($currentPage - 1) * $limit
                );
            break;
        }

        return $this->render('vehicle/index.html.twig', [
            'vehicles' => $vehicles, 
            'pagesNb' => $pagesNb,
            'currentPage' => $currentPage
        ]);
    }

    /**
     * @Route("/show/{id}", name="app_vehicle_show", requirements={"id"="\d+"})
     *
     * @param Vehicle $vehicle
     * @return Response
     */
    public function show(Vehicle $vehicle): Response
    {
        return $this->render('vehicle/show.html.twig', compact('vehicle'));
    }

    /**
     * @Route("/create", name="app_vehicle_create", methods={"GET", "POST"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function create(Request $request): Response
    {
        $vehicle = new Vehicle;
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            //Récupère l'utilisateur
            $user = $this->getUser();
            //Récupère les images
            $pictures = $form->get('pictures')->getData();
            //On boucle sur les images
            foreach ($pictures as $picture) {
                //On créer un nom unique
                $safeName = md5(uniqid()) . '.' . $picture->guessExtension();
                //Déplace le fichier dans le dossier indiqué avec getParameter
                $picture->move(
                    $this->getParameter('pictures_directory'),
                    $safeName
                );
                $picture = new Picture;
                $picture->setName($safeName);
                $vehicle->addPicture($picture);
            }
            
            $vehicle = $form->getData();
            $vehicle->setCreatedAt(new \DateTime())
                    ->setUpdatedAt(new \DateTime())
                    ->setUser($user);
            $this->em->persist($vehicle);
            $this->em->flush();

            $this->addFlash('success', 'L\'annonce a bien était créée !');

            return $this->redirectToRoute('app_vehicle');
        }

        return $this->render('vehicle/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="app_vehicle_edit", methods={"GET", "POST"})
     *
     * @param Vehicle $vehicle
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function edit(Vehicle $vehicle, Request $request): Response
    {
        
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Récupère les images
            $pictures = $form->get('pictures')->getData();
            
            //On boucle sur les images
            foreach ($pictures as $picture) {
                //On créer un nom unique
                $safeName = md5(uniqid()) . '.' . $picture->guessExtension();
                //Déplace le fichier dans le dossier indiqué avec getParameter
                $picture->move(
                    $this->getParameter('pictures_directory'),
                    $safeName
                );
                $picture = new Picture;
                $picture->setName($safeName);
                $vehicle->addPicture($picture);
            }
            $vehicle->setUpdatedAt(new \DateTime());
            $this->em->flush();

            $this->addFlash('success', 'L\'annonce a bien était modifiée !');

            return $this->redirectToRoute('app_vehicle');
        }

        
        return $this->render('vehicle/edit.html.twig', [
            'vehicle' => $vehicle,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/picture/{id}", name="app_delete_picture", methods={"DELETE"})
     */
    public function deleteImage(Request $request, PictureRepository $pictureRepository, $id): JsonResponse
    {
        $picture = $pictureRepository->findOneBy(['id' => $id]);
        $name = $picture->getName();
        unlink($this->getParameter('pictures_directory') . '/' . $name);

        $this->em->remove($picture);
        $this->em->flush();

        return new JsonResponse(['success' => 1]);
    }

    /**
     * @Route("/delete/{id}", name="app_vehicle_delete", methods={"GET", "DELETE"})
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Vehicle $vehicle
     * @return Response
     */
    public function delete(Request $request, Vehicle $vehicle): Response
    {
        if ($this->isCsrfTokenValid('delete'.$vehicle->getId(), $request->request->get('_token'))) {
            $this->em->remove($vehicle);
            $this->em->flush();
        }
           
        return $this->redirectToRoute('app_vehicle');
    }
}
