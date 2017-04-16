<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\ServiceHelper;

/**
 * Class ProductService
 * @package AppBundle\Service
 */
class ProductService extends ServiceHelper
{

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function productSave(Request $request)
    {

        if (!$request instanceof Request) {
            return false;
        }

        $product = new Product();
        $product->setName($request->get('product_name'));
        $product->setCategory($request->get('product_category'));
        $product->setProducer($request->get('product_producer'));
        $product->setPrice($request->get('product_price'));
        $product->setSlug($this->createSlug($product->getName()));
        $product->setEan($request->get('product_ean'));
        $product->setStock($request->get('product_stock'));
        $product->setCreatedAt(new \DateTime('now'));
        $product->setUpdateAt(new \DateTime('now'));
        $product->setDescription(htmlspecialchars($request->get('product_description')));

        $this->em->persist($product);
        $this->em->flush();

    }

}