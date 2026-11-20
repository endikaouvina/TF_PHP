<?php

// Se desactiva la conversión automática de tipos de variables
declare(strict_types=1);

// Se define la entidad 'User'
class User {

    // Se definen las propiedades que describirán un usuario
    private ?int $id;
    private string $name;
    private string $surname;
    private string $email;
    private string $tel;
    private string $birth;
    private ?string $address;
    private string $sex;
    private string $userName;
    private string $passHash;
    private string $rol;

    // Se define el método constructor
    public function __construct(
        ?int $id,
        string $name,
        string $surname,
        string $email,
        string $tel,
        string $birth,
        ?string $address,
        string $sex,
        string $userName,
        string $passHash,
        string $rol = 'user'
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
        $this->passHash = $passHash;
        $this->rol = $rol;
    }

    // GETTERS: Métodos para consultar el valor de las propiedades
    public function getId(): ?int {
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

    public function getPassHash(): string {
        return $this->passHash;
    }

    public function getRol(): string {
        return $this->rol;
    }

    // SETTERS: Métodos para modificar el valor de las propiedades
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function setSurname(string $surname): void {
        $this->surname = $surname;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setTel(string $tel): void {
        $this->tel = $tel;
    }

    public function setBirth(string $birth): void {
        $this->birth = $birth;
    }

    public function setAddress(string $address): void {
        $this->address = $address;
    }

    public function setSex(string $sex): void {
        $this->sex = $sex;
    }

    public function setUserName(string $userName): void {
        $this->userName = $userName;
    }

    public function setPassHash(string $passHash): void {
        $this->passHash = $passHash;
    }

    public function setRol(string $rol): void {
        $this->rol = $rol;
    }

}
