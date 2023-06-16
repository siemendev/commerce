<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Product\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'product_overview')]
class ProductOverviewController extends AbstractController
{
    public function __invoke(ProductRepository $productRepository): Response
    {
        return $this->render('pages/products/overview.html.twig', [
            'products' => $productRepository->loadAll(),
        ]);
    }
}
