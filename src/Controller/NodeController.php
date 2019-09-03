<?php

namespace App\Controller;

use App\Service\NodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * Class NodeController.php
 * @package App\Controller
 * @Route("/nodes")
 */
class NodeController extends AbstractController
{
    /**
     * @Route("/", name="node_get", methods={"GET"})
     * @Route("/{ids}", name="nodes_get", methods={"GET"})
     * @param string $ids
     * @param NodeService $nodeService
     * @return Response
     */
    public function fetch(string $ids = '', NodeService $nodeService): Response
    {
        try {
            if (empty($ids)) {
                $nodes = $nodeService->getAll();
                return $this->json(
                    array(
                        'status' => true,
                        'message' => '',
                        'data' => $nodes
                    ),
                    Response::HTTP_OK
                );
            }
            $nodes = $nodeService->get($ids);
            return $this->json(
                array(
                    'status' => true,
                    'message' => '',
                    'data' => $nodes
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
     * @Route("/", name="node_add_post", methods={"POST"})
     * @param Request $request
     * @param NodeService $nodeService
     * @return Response
     */
    public function add(Request $request, NodeService $nodeService): Response
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
            $responseData = $nodeService->add($params);

            return $this->json(
                array(
                    'status' => True,
                    'message' => 'Node is added successfully.',
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
     * @Route("/", name="node_edit_post", methods={"PUT"})
     * @param Request $request
     * @param NodeService $nodeService
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function edit(Request $request, NodeService $nodeService, EntityManagerInterface $entityManager): Response
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

            $responseData = $nodeService->edit($params);
            return $this->json(
                array(
                    'status' => True,
                    'message' => 'Node is updated successfully.',
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
     * @Route("/", name="remove_node", methods={"DELETE"})
     * @param NodeService $nodeService
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request, NodeService $nodeService): Response
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

            $responseData = $nodeService->delete($params);
            if (!$responseData['status']) {
                return $this->json($responseData, Response::HTTP_OK);
            }


            return $this->json(
                array(
                    'status' => true,
                    'message' => $responseData['data'] . ' node(s) did remove successfully.',
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