<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Regex(
        pattern: '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/',
        match: true,
        message: 'Le mot de passe doit contenir au moins une minuscule, une majuscule, un chiffre, un caractère spécial parmis : "@$!%*?&" et 12 caractères.',
    )]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z\-^¨]*$/",
        message:"Seulement les lettres et ces caractères spéciaux '- ^ ¨' sont acceptés."
    )]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z\-^¨]*$/",
        message:"Seulement les lettres et ces caractères spéciaux '- ^ ¨' sont acceptés."
    )]
    private ?string $prenom = null;

    #[ORM\Column(length: 254, unique: true)]
    #[Assert\Regex(
        pattern:"/^[a-zA-Z0-9]*$/",
        message:"Veuillez saisir uniquement des chiffres et des lettres."
    )]
    #[Assert\Length(
        min:30,
        max:30,
        exactMessage:"La longueur doit être exactement de {{ limit }} caractères."
    )]
    private ?string $permis = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dof = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $sexe = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern:"/^[0-9]*$/",
        message:"Veuillez saisir uniquement des chiffres."
    )]
    private ?float $tel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(
        pattern:"/^[0-9]*$/",
        message:"Veuillez saisir uniquement des chiffres."
    )]
    #[Assert\Length(
        min:5,
        max:5,
        exactMessage:"La longueur doit être exactement de {{ limit }} caractères."
    )]
    private ?float $cp = null;

    #[ORM\Column(length: 255, nullable: true)]
    private array $pays = [];

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Reservation::class)]
    private Collection $reservations;

    #[ORM\OneToMany(mappedBy: 'auteur', targetEntity: Avis::class, orphanRemoval: true)]
    private Collection $avis;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPermis(): ?string
    {
        return $this->permis;
    }

    public function setPermis(string $permis): static
    {
       // Vérifier si le numéro de permis est null ou a une longueur différente de 30 caractères
       if ($permis !== null && strlen($permis) !== 30) {
            throw new \InvalidArgumentException('Le numéro de permis doit avoir exactement 30 caractères.');
        }
        $this->permis = $permis;

        return $this;
    }

    public function getDof(): ?\DateTimeInterface
    {
        return $this->dof;
    }

    public function setDof(?\DateTimeInterface $dof): static
    {
        $this->dof = $dof;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(?string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getTel(): ?float
    {
        return $this->tel;
    }

    public function setTel(?float $tel): static
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCp(): ?float
    {
        return $this->cp;
    }

    public function setCp(?float $cp): static
    {
        $this->cp = $cp;

        return $this;
    }

    public function getPays(): array
    {
        return $this->pays;
    }

    public function setPays(array $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setClient($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getClient() === $this) {
                $reservation->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): static
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setAuteur($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): static
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getAuteur() === $this) {
                $avi->setAuteur(null);
            }
        }

        return $this;
    }
}
