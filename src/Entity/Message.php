<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 * @Vich\Uploadable
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Message;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $Image;
    /**
     * @Vich\UploadableField(mapping="annonce_images", fileNameProperty="image")
     * @var File
     * * @Assert\Image{
     *       mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/pdf"}
     *       mimeTypesMessage = "Wrong file type (jpg,gif,png,mp4,mov,avi)"
     */
    private $imageFile;



    public function setImageFile(File $image = null)
    {
    $this->imageFile = $image;


    // VERY IMPORTANT:
    // It is required that at least one field changes if you are using Doctrine,
    // otherwise the event listeners won't be called and the file is lost
    if ($image) {
        // if 'updatedAt' is not defined in your entity, use another property
        $this->updatedAt = new \DateTime('now');
    }
    }

    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(?string $Image): self
    {
        $this->Image = $Image;

        return $this;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(string $Message): self
    {
        $this->Message = $Message;

        return $this;
    }

}
