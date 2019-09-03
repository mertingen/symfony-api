<?php

namespace App\Service;

use App\Entity\Node;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class NodeService
 * @package App\Service
 *
 * This service is working to control regarding data.
 */
class NodeService
{

    private $entityManager;

    /**
     * NodeService constructor.
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
                $node = new Node();
                $node->setName($param['name']);
                $node->setCreatedAt(new DateTime());
                $this->entityManager->persist($node);
                $validData[] = $node;
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
                }
                if (!isset($param['id'])) {
                    $invalidParam = array(
                        'status' => False,
                        'message' => 'Id field is must be sent!',
                        'data' => $param
                    );
                    $invalidData[] = $invalidParam;
                    continue;
                }
                $node = $this->entityManager->getRepository('App:Node')->findOneBy(array('id' => $param['id']));
                $node->setName($param['name']);
                $node->setCreatedAt(new DateTime());
                $this->entityManager->persist($node);
                $validData[] = $node;
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
            $count = $this->entityManager->getRepository('App:Node')->deleteByMultipleIds($data);
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
        if (empty($data['name'])) {
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
}
