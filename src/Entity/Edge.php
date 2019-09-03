<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EdgeRepository")
 */
class Edge implements \JsonSerializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", length=255)
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="node", cascade={"remove"})
     * @ORM\JoinColumn(name="node_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $node;

    /**
     * @ORM\ManyToOne(targetEntity="Node", inversedBy="node", cascade={"remove"})
     * @ORM\JoinColumn(name="directed_node_id", referencedColumnName="id",onDelete="CASCADE")
     */
    protected $directedNode;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNode(): ?Node
    {
        return $this->node;
    }

    public function setNode(?Node $node): self
    {
        $this->node = $node;

        return $this;
    }

    public function getDirectedNode(): ?Node
    {
        return $this->directedNode;
    }

    public function setDirectedNode(?Node $directedNode): self
    {
        $this->directedNode = $directedNode;

        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return array(
            'id' => $this->getId(),
            'name' => $this->getName(),
            'created_at' => $this->getCreatedAt(),
            'node' => $this->getNode(),
            'directed_node' => $this->getDirectedNode()
        );
    }
}
