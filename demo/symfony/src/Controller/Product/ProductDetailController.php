<?php

declare(strict_types=1);

namespace App\Controller\Product;

use App\Commerce\Checkout;
use App\Commerce\CheckoutProduct;
use App\Controller\AbstractCheckoutController;
use App\Product\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products/{id}', name: 'product_detail')]
class ProductDetailController extends AbstractCheckoutController
{
    public function __invoke(
        string $id,
        Request $request,
        ProductRepository $productRepository,
        Checkout $checkout,
    ): Response {
        $product = $productRepository->load($id);

        if ($request->isMethod(Request::METHOD_POST) && $request->request->has('add_to_cart')) {
            $checkoutProduct = (new CheckoutProduct())
                ->setIdentifier($product->id)
                ->setName($product->name)
                ->setQuantity($request->request->getInt('quantity', 1))
                ->setVatType($product->vatType)
            ;

            $checkout
                ->addProduct($checkoutProduct)
                ->save()
            ;
            $this->addFlash('success', 'Product(s) added to cart');
        }

        return $this->render('pages/products/detail.html.twig', [
            'product' => $product,
        ]);
    }
}
