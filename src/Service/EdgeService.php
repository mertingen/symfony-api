<?php

namespace App\Service;

use App\Entity\Edge;
use App\Entity\Node;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class EdgeService
 * @package App\Service
 *
 * This service is working to control regarding data.
 */
class EdgeService
{

    private $entityManager;

    /**
     * EdgeService constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param string $ids
     * @return mixed
     */
    public function get(string $ids = '')
    {
        return $nodes = $this->entityManager->getRepository('App:Node')->findByMultipleIds(explode(',', $ids));
    }

    /**
     * @return array|object[]
     */
    public function getAll()
    {
        return $this->entityManager->getRepository('App:Node')->findAll();
    }

    /**
     * @param array $data
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(array $data = array()): array
    {
        try {
            $invalidData = array();
            $validData = array();
            foreach ($data as $param) {
                $isValid = $this->checkData($param);
                if (!$isValid['status']) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => $isValid['message'],
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                }
                $node = $this->entityManager->getRepository('App:Node')->findOneBy(array('id' => $param['node_id']));
                $directedNode = $this->entityManager->getRepository('App:Node')->findOneBy(array('id' => $param['directed_node_id']));
                if (empty($node) || empty($directedNode)) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => "Node is not found!",
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                }
                $isExistRelation = $this->isExistRelation($node, $directedNode);
                if ($isExistRelation) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => "The edge is already exist!",
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                }
                $edge = new Edge();
                $edge->setName($param['name']);
                $edge->setNode($node);
                $edge->setDirectedNode($directedNode);
                $edge->setCreatedAt(new DateTime());
                $this->entityManager->persist($edge);
                $validData[] = $edge;
            }
            $this->entityManager->flush();
            return array(
                'data' => $validData,
                'invalidData' => $invalidData
            );
        } catch (Exception $e) {
            return array(
                'status' => False,
                'message' => $e->getMessage(),
                'data' => array()
            );
        }

    }

    /**
     * @param array $data
     * @return array
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function edit(array $data = array()): array
    {
        try {
            $invalidData = array();
            $validData = array();
            foreach ($data as $param) {
                $isValid = $this->checkData($param);
                if (!$isValid['status']) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => $isValid['message'],
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                };
                if (!isset($param['id'])) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => 'Id field is must be sent!',
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                }

                $node = $this->entityManager->getRepository('App:Node')->findOneBy(array('id' => $param['node_id']));
                $directedNode = $this->entityManager->getRepository('App:Node')->findOneBy(array('id' => $param['directed_node_id']));
                if (empty($node) || empty($directedNode)) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => "Node is not found!",
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                }
                $edge = $this->entityManager->getRepository('App:Edge')->findOneBy(array('id' => $param['id']));
                if ($edge->getNode()->getId() != $param['node_id'] || $edge->getDirectedNode()->getId() != $param['directed_node_id']) {
                    $isExistRelation = $this->isExistRelation($node, $directedNode);
                    if ($isExistRelation) {
                        $invalidParam = array(
                            'status' => False,
                            'message' => "The edge is already exist!",
                            'data' => $param
                        );
                        $invalidData[] = $invalidParam;
                        continue;
                    }
                }

                $edge->setName($param['name']);
                $edge->setNode($node);
                $edge->setDirectedNode($directedNode);
                $edge->setCreatedAt(new DateTime());
                $this->entityManager->persist($edge);
                $validData[] = $edge;
            }
            $this->entityManager->flush();
            return array(
                'data' => $validData,
                'invalidData' => $invalidData
            );
        } catch (Exception $e) {
            return array(
                'status' => False,
                'message' => $e->getMessage(),
                'data' => array()
            );
        }
    }

    /**
     * @param array $data
     * @return array
     */
    public function delete(array $data = array()): array
    {
        try {
            $count = $this->entityManager->getRepository('App:Edge')->deleteByMultipleIds($data);
            return array(
                'status' => True,
                'message' => '',
                'data' => $count
            );
        } catch (Exception $e) {
            return array(
                'status' => False,
                'message' => $e->getMessage(),
                'data' => array()
            );
        }
    }


    /**
     * @param array $data
     * @return array
     */
    public function checkData(array $data = array()): array
    {
        if (empty($data['name']) || empty($data['node_id'] || empty($data['directed_node_id']))) {
            return array(
                'status' => false,
                'message' => 'Values are must be sent.'
            );
        }

        return array(
            'status' => true,
            'message' => 'Values are proper.'
        );
    }

    public function isExistRelation(Node $node, Node $directedNode)
    {
        $isDirectedEdge = $this->entityManager->getRepository('App:Edge')->findOneBy(array('node' => $node, 'directedNode' => $directedNode));
        if ($isDirectedEdge) {
            return TRUE;
        }
        $isInversionDirectedEdge = $this->entityManager->getRepository('App:Edge')->findOneBy(array('node' => $directedNode, 'directedNode' => $node));
        if ($isInversionDirectedEdge) {
            return TRUE;
        }
        return FALSE;

    }
}
