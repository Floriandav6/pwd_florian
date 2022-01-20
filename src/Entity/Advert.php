<?php

namespace App\Entity;

use App\Repository\AdvertRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=AdvertRepository::class)
 * @Vich\Uploadable
 */
class Advert
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
    private $Title;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $Price;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Brand;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $Size;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="adverts")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=AdvertLike::class, mappedBy="advert")
     */
    private $likes;

    /**
     * @ORM\ManyToOne(targetEntity=PhotoGallery::class, inversedBy="adverts")
     */
    private $gallery;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $image;

    /**
     * @Vich\UploadableField(mapping="annonce_images", fileNameProperty="image")
     * @var File
     * @Assert\Image{
     *       mimeTypes = {"image/jpeg", "image/gif", "image/png", "video/mp4", "video/quicktime", "video/avi"}
     *       mimeTypesMessage = "Wrong file type (jpg,gif,png,mp4,mov,avi)"
     *
     */
    private $imageFile;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="adverts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;




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
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->Price;
    }

    public function setPrice(string $Price): self
    {
        $this->Price = $Price;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->Brand;
    }

    public function setBrand(string $Brand): self
    {
        $this->Brand = $Brand;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->Size;
    }

    public function setSize(string $Size): self
    {
        $this->Size = $Size;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|AdvertLike[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(AdvertLike $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setAdvert($this);
        }

        return $this;
    }

    public function removeLike(AdvertLike $like): self
    {
        if ($this->likes->removeElement($like)) {
            // set the owning side to null (unless already changed)
            if ($like->getAdvert() === $this) {
                $like->setAdvert(null);
            }
        }

        return $this;
    }

    public function getGallery(): ?PhotoGallery
    {
        return $this->gallery;
    }

    public function setGallery(?PhotoGallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function isLikedByUser( User $user) : bool {
        foreach ($this->likes as $like){
            if ($like->getUser() === $user){
                return true;
            }
        }
        return false;
    }


}
