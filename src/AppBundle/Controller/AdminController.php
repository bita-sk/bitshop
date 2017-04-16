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

        if($request->get('addProduct') != ""){
            if(!$this->get('app.product.service')->productSave($request)){
                $this->addFlash(
                    'success',
                    'Produkt byl úspěšně vytvořen'
                );
            }else{
                $this->addFlash(
                    'fail',
                    'Vytvoření produktu selhalo'
                );
            }
        }

        return $this->render('admin/product.html.twig', [

        ]);
    }
}
