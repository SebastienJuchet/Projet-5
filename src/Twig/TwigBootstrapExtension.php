<?php

namespace App\Twig;

use Twig\TwigFilter;
use App\Repository\VehicleRepository;
use Twig\Extension\AbstractExtension;

class TwigBootstrapExtension extends AbstractExtension
{
    private $vehicleRepository;

    public function __construct(VehicleRepository $vehicleRepository)
    {
        $this->vehicleRepository = $vehicleRepository;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('hashGravatar', [$this, 'emailHashGravatar']),
            new TwigFilter('userVehicleNb', [$this, 'totalVehicleNumber'])
        ];
    }

    public function emailHashGravatar($email)
    {
        return 'https://www.gravatar.com/avatar/' . md5($email) . '?s=40';
    }

    public function totalVehicleNumber($user)
    {
        $allVehicles = count($this->vehicleRepository->findAll());

        return $allVehicles;
    }
}