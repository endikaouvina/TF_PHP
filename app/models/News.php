<?php

// Se define la entidad 'News'
class News {

    // Se definen las propiedades que describirán una noticia
    private string $title;
    private string $image;
    private string $text;
    private string $date;
    private string $userName;

    // Se define el método constructor
    public function __construct(
        string $title,
        string $image,
        string $text,
        string $date,
        string $userName
    ) {
        $this->title = $title;
        $this->image = $image;
        $this->text = $text;
        $this->date = $date;
        $this->userName = $userName;
    }

    // GETTERS: Métodos para consultar el valor las propiedades
    public function getTitle(): string {
        return $this->title;
    }

    public function getImage(): string {
        return $this->image;
    }

    public function getText(): string {
        return $this->text;
    }

    public function getDateTime(): string {
        $date = new DateTime($this->date);

        return $date->format('d/m/Y · H:i');
    }

    public function getUserName(): string {
        return $this->userName;
    }

}
