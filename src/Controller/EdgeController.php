<?php

namespace App\Controller;

use App\Service\EdgeService;
use App\Service\NodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Class EdgeController.php
 * @package App\Controller
 * @Route("/edges")
 */
class EdgeController extends AbstractController
{
    /**
     * @Route("/", name="edge_get", methods={"GET"})
     * @Route("/{ids}", name="edges_get", methods={"GET"})
     * @param string $ids
     * @param EdgeService $edgeService
     * @return Response
     */
    public function fetch(string $ids = '', EdgeService $edgeService): Response
    {
        try {
            if (empty($ids)) {
                $edges = $edgeService->getAll();
                return $this->json(
                    array(
                        'status' => true,
                        'message' => '',
                        'data' => $edges
                    ),
                    Response::HTTP_OK
                );
            }
            $edges = $edgeService->get($ids);
            return $this->json(
                array(
                    'status' => true,
                    'message' => '',
                    'data' => $edges
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->json(
                array(
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => array()
                ),
                Response::HTTP_EXPECTATION_FAILED
            );
        }
    }

    /**
     * @Route("/", name="edge_add_post", methods={"POST"})
     * @param Request $request
     * @param EdgeService $edgeService
     * @return Response
     */
    public function add(Request $request, EdgeService $edgeService): Response
    {
        try {
            $params = json_decode($request->getContent(), true);
            if (empty($params)) {
                return $this->json(
                    array(
                        'status' => False,
                        'message' => 'The params are must be sent!',
                        'data' => array()
                    ),
                    Response::HTTP_OK
                );
            }
            $responseData = $edgeService->add($params);

            return $this->json(
                array(
                    'status' => True,
                    'message' => 'You can check out data and invalid_data params.',
                    'data' => $responseData['data'],
                    'invalid_data' => $responseData['invalidData']
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->json(
                array(
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => array()
                ),
                Response::HTTP_EXPECTATION_FAILED
            );
        }
    }

    /**
     * @Route("/", name="edge_edit_post", methods={"PUT"})
     * @param Request $request
     * @param EdgeService $edgeService
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function edit(Request $request, EdgeService $edgeService, EntityManagerInterface $entityManager): Response
    {
        try {
            $params = json_decode($request->getContent(), true);
            if (empty($params)) {
                return $this->json(
                    array(
                        'status' => False,
                        'message' => 'The params are must be sent!',
                        'data' => array()
                    ),
                    Response::HTTP_OK
                );
            }

            $responseData = $edgeService->edit($params);
            return $this->json(
                array(
                    'status' => True,
                    'message' => 'You can check out data and invalid_data params.',
                    'data' => $responseData['data'],
                    'invalid_data' => $responseData['invalidData']
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->json(
                array(
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => array()
                ),
                Response::HTTP_EXPECTATION_FAILED
            );
        }
    }

    /**
     * @Route("/", name="remove_edge", methods={"DELETE"})
     * @param EdgeService $edgeService
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request, EdgeService $edgeService): Response
    {
        try {
            $params = json_decode($request->getContent(), true);
            if (empty($params)) {
                return $this->json(
                    array(
                        'status' => False,
                        'message' => 'The params are must be sent!',
                        'data' => array()
                    ),
                    Response::HTTP_OK
                );
            }

            $responseData = $edgeService->delete($params);
            if (!$responseData['status']) {
                return $this->json($responseData, Response::HTTP_OK);
            }


            return $this->json(
                array(
                    'status' => true,
                    'message' => $responseData['data'] . ' edge(s) did remove successfully.',
                    'data' => array()
                ),
                Response::HTTP_OK
            );
        } catch (\Exception $e) {
            return $this->json(
                array(
                    'status' => false,
                    'message' => $e->getMessage(),
                    'data' => array()
                ),
                Response::HTTP_EXPECTATION_FAILED
            );
        }
    }
}