<?php

namespace AppBundle\Service;

use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Helper\ServiceHelper;

/**
 * Class CategoryService
 * @package AppBundle\Service
 */
class CategoryService extends ServiceHelper
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

    public function getAll()
    {
        return $this->em->getRepository("AppBundle:Category")->findAll();
    }

    public function saveCategory(Request $request)
    {
        if (!$request instanceof Request) {
            return null;
        }

        $parent = $this->em->getRepository("AppBundle:Category")->find($request->get('category_parent'));

        $category = new Category();
        $category->setName($request->get('category_name'));
        $category->setSlug($this->createSlug($category->getName()));
        $category->setCreatedAt(new \DateTime('now'));
        $category->setUpdateAt(new \DateTime('now'));

        if ($parent instanceof Category) {
            $category->setParent($parent);
        }

        $this->em->persist($category);
        $this->em->flush();
    }

}