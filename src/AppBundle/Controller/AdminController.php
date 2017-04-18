<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin/index.html.twig', [

        ]);
    }

    /**
     * @Route("/admin/product", name="product")
     */
    public function productAction(Request $request)
    {

        if ($request->get('addProduct') != "") {
            if (trim($request->get('product_name')) == "") {
                $this->addFlash(
                    'fail',
                    'Název produktu je povinný'
                );
            } else {
                $this->get('app.product.service')->productSave($request);
                $this->addFlash(
                    'success',
                    'Produkt byl úspěšně vytvořen'
                );
            }

        }

        $categories = $this->get('app.category.service')->getAll();
        $producers = $this->get('app.producer.service')->getAll();

        return $this->render('admin/product.html.twig', [
            'categories' => $categories,
            'producers' => $producers
        ]);
    }

    /**
     * @Route("/admin/category", name="category")
     */
    public function categoryAction(Request $request)
    {

        if ($request->get('addCategory') != "") {
            if ($request->get('category_name') != "") {
                $this->get('app.category.service')->saveCategory($request);

                $this->addFlash(
                    'success',
                    'Kategorie byla úspěšně vytvořena'
                );
            } else {
                $this->addFlash(
                    'fail',
                    'Název kategorie je povinný'
                );
            }
        }

        $categories = $this->get('app.category.service')->getAll();

        return $this->render('admin/category.html.twig', [
            'categories' => $categories,
        ]);
    }
}
