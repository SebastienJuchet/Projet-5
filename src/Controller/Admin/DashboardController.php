<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Vehicle;
use App\Repository\UserRepository;
use App\Repository\VehicleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    private $vehicleRepository;

    private $userRepository;

    public function __construct(VehicleRepository $vehicleRepository, UserRepository $userRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        if ($this->denyAccessUnlessGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        $vehicleTt = count($this->vehicleRepository->findAll());
        $userTt = count($this->userRepository->findAll());

        return $this->render('/bundles/EasyAdminBundle/welcome.html.twig', compact('vehicleTt', 'userTt'));
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Projet 5');
    }

    public function configureMenuItems(): iterable
    {
        return [
            yield MenuItem::linktoRoute('Retour site', 'fa fa-globe', 'app_home'),

            yield MenuItem::linkToDashboard('Accueil', 'fa fa-home'),

            yield MenuItem::section('Annonces'),
            yield MenuItem::linkToCrud('Vehicle', 'fas fa-car-side', Vehicle::class),

            yield MenuItem::section('Utilisateurs'),
            yield MenuItem::linkToCrud('User', 'fas fa-car-side', User::class)

        ];
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
        ->setName($user->getUsername())
        ->setGravatarEmail($user->getUsername())
        ->displayUserAvatar(true);
    }
}
