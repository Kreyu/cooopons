<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\BrandCategory;
use App\Entity\Coupon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $brandCategories = $entityManager->getRepository(BrandCategory::class)->findAll();

        return $this->render('homepage.html.twig', [
            'brand_categories' => $brandCategories,
        ]);
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $page = $request->query->get('page', 1);
        $query = $request->query->get('query');
        $category = $request->query->get('category');

        $brandCategories = $entityManager->getRepository(BrandCategory::class)->findAll();
        $paginator = $entityManager->getRepository(Coupon::class)
            ->createSearchPaginator($page, $query, $category);

        return $this->render('search.html.twig', [
            'brand_categories' => $brandCategories,
            'paginator' => $paginator,
        ]);
    }

    /**
     * @Route("/autocomplete", name="search_autocomplete")
     */
    public function autocomplete(Request $request)
    {
        $items = [];
        $term = trim(strip_tags($request->get('term')));

        $entityManager = $this->getDoctrine()->getManager();

        $brands = $entityManager->getRepository(Brand::class)->findByNameLike($term);
        $brandCategories = $entityManager->getRepository(BrandCategory::class)->findByNameLike($term);

        /**
         * @var Brand|BrandCategory $entity
         */
        foreach (array_merge($brands, $brandCategories) as $entity) {
            $items[] = $entity->getName();
        }

        return new JsonResponse($items);
    }

    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/redeem/{id}", name="redeem", methods={"POST"})
     */
    public function redeem(Coupon $coupon)
    {
        $coupon->incrementRedeemCount();

        $this->getDoctrine()->getManager()->flush();

        return new JsonResponse($coupon->toArray());
    }
}
