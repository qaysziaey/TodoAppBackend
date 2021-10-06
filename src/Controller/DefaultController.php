<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Repository\TodoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends AbstractController
{
    /**
     * @param Request $request
     * @return Response
     * @Route("/", name="app_index")
     */
    public function index(Request $request)
    {
        return $this->render('base.html.twig');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/list", name="app_list")
     */
    public function list(Request $request, TodoRepository $repo)
    {
        return new JsonResponse([
            'result' => $this->normalize($repo->findAll())
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/get/{id}", name="app_get")
     */
    public function getOneById(TodoRepository $repo, $id)
    {
        try {
            return new JsonResponse([
                'result' => $this->normalize($repo->findOneById($id))
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/create", name="app_create", methods={"GET"})
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        try {
            $todo = new Todo();
            $todo
                ->setTitle($request->get('title'))
                ->setDescription($request->get('description'));
            $em->persist($todo);
            $em->flush();

            return new JsonResponse([
                'message' => 'created',
                'id'  =>  $todo->getId()
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @Route("/api/remove/{id}", name="app_remove", methods={"GET"})
     */
    public function remove($id, TodoRepository $repo, EntityManagerInterface $em)
    {
        try {
            $todo = $repo->findOneById($id);

            if ($todo) {
                $em->remove($todo);
                $em->flush();
            }
            return new JsonResponse([
                'message' => 'removed',
                'id'  =>  $id
            ]);
        } catch (\Exception $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * @param $object
     * @return array|\ArrayObject|bool|\Countable|float|int|mixed|string|null
     * @throws \Symfony\Component\Serializer\Exception\ExceptionInterface
     */
    public function normalize($object)
    {
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        return $serializer->normalize($object);
    }
}