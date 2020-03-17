<?php

namespace App\Entity;

class Product
{

    private $id;
    private $name;
    private $price;
    private $quantity;
    private $description;
    private $imageUrl;
    private $createAt;

    /**
     * Product constructor.
     * @param $id
     * @param $name
     * @param $price
     * @param $quantity
     * @param $description
     * @param $imageUrl
     * @param $createAt
     */
    public function __construct($id, $name, $price, $quantity, $description, $imageUrl, $createAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->description = $description;
        $this->imageUrl = $imageUrl;
        $this->createAt = $createAt;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }
    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }
    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }
    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }
    /**
     * @param mixed $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }
    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createAt;
    }
    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createAt)
    {
        $this->$createAt = $createAt;
    }

}