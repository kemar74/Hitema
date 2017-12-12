<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MemberController extends Controller
{

    private $list = [
        [ 'name' => 'nom1', 'fname' => 'prénom1', 'img' => 'membre1.jpg' ],
        [ 'name' => 'nom2', 'fname' => 'prénom2', 'img' => 'membre2.jpg' ],
        [ 'name' => 'nom3', 'fname' => 'prénom3', 'img' => 'membre3.jpg' ],
    ];

    /**
     * @Route("/members", name="members")
     */
    public function listAction(){
        return $this->render('member/list.html.twig', [
            'list' => $this->list
        ]);
    }

    /**
     * @Route("/member/{id}", name="member")
     */
    public function detailAction($id){
        return $this->render('member/detail.html.twig', [
            'detail' => $this->list[$id]
        ]);
    }


}