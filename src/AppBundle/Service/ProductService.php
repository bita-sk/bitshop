<?php

namespace AppBundle\Service;

use AppBundle\Entity\Product;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\ServiceHelper;
use AppBundle\Helper\ImageHelper;

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

    private $container;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager, ContainerInterface $container)
    {
        $this->em = $entityManager;
        $this->container = $container;
    }


    /**
     * @param Request $request
     * @return bool
     */
    public function productSave(Request $request)
    {

        if (!$request instanceof Request) {
            return null;
        }

        $product = new Product();

        if ($request->get('product_category') != "") {
            $category = $this->em->getRepository("AppBundle:Category")->find($request->get('product_category'));
            $product->setCategory($category);
        }

        if ($request->get('product_producer') != "") {
            $producer = $this->em->getRepository("AppBundle:Producer")->find($request->get('product_producer'));
            $product->setProducer($producer);
        }


        $product->setName($request->get('product_name'));
        $product->setPrice($request->get('product_price'));
        $product->setSlug($this->createSlug($product->getName()));
        $product->setEan($request->get('product_ean'));
        $product->setStock($request->get('product_stock'));
        $product->setCreatedAt(new \DateTime('now'));
        $product->setUpdateAt(new \DateTime('now'));
        $product->setDescription(htmlspecialchars($request->get('product_description')));

        $this->em->persist($product);
        $this->em->flush();

        $imageHelper = new ImageHelper();
        $path = $this->container->get('kernel')->getRootDir();
        $path = str_replace("app", "web", $path);
        $imageHelper->saveImageFromInput($path, $product->getId());


    }

}