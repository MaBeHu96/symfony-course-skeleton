<?php

declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HealtCheckController
{
 
    public function __construct(private LoggerInterface $logger)
    {
    }

    #[Route('/', name: 'health_check', methods: ['GET'])]
    public function _invoke(): Response
    {
        $this->logger->info('This is the HealtCheckController error');

        return new JsonResponse(['status' => 'Okey']);
    }
}
