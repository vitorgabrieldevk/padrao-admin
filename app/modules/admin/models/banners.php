<?php

namespace Admin\Models;

class BannersModel {
    protected $table = 'banners'; // Nome da tabela

    protected $columns = []; // Array para armazenar colunas e seus labels

    public function __construct() {

        $this->setColumn('titulo', 'Título');
        $this->setColumn('frase', 'Frase');
        $this->setColumn('botao_txt', 'Título botão');
        $this->setColumn('link', 'Link');
        $this->setColumn('imagem_desktop', 'Imagem desktop');
        $this->setColumn('imagem_mobile', 'Imagem mobile');
        $this->setColumn('ordenacao', 'Ordenação');
        $this->setColumn('ativo', 'Ativo');
    }

    // Método para adicionar coluna e seu label
    protected function setColumn($columnName, $label) {
        $this->columns[$columnName] = $label;
    }

    // Método para obter todas as colunas como array associativo (columnName => label)
    public function getAllColumns() {
        return $this->columns;
    }

    // Método para obter o nome da tabela
    public function getTableName() {
        return $this->table;
    }
}
