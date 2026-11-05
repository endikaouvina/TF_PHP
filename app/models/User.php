<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la entidad 'User'
class User {

    // Se definen las propiedades que describirán un usuario
    private int $id;
    private string $name;
    private string $surname;
    private string $email;
    private string $tel;
    private string $birth;
    private ?string $address;
    private string $sex;
    private string $userName;
    private string $passwordHash;
    private string $rol;

    // Se define el método constructor
    public function __construct(
        int $id,
        string $name,
        string $surname,
        string $email,
        string $tel,
        string $birth,
        ?string $address,
        string $sex,
        string $userName,
        string $passwordHash,
        string $rol
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->tel = $tel;
        $this->birth = $birth;
        $this->address = $address;
        $this->sex = $sex;
        $this->userName = $userName;
        $this->passwordHash = $passwordHash;
        $this->rol = $rol;
    }

    // GETTERS: Métodos para consultar el valor las propiedades
    public function getId(): int {
        return $this->id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSurname(): string {
        return $this->surname;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getTel(): string {
        return $this->tel;
    }

    public function getBirth(): string {
        return $this->birth;
    }

    public function getAddress(): ?string {
        return $this->address;
    }

    public function getSex(): string {
        return $this->sex;
    }

    public function getUserName(): string {
        return $this->userName;
    }

    public function getPasswordHash(): string {
        return $this->passwordHash;
    }

    public function getRol(): string {
        return $this->rol;
    }

}
