<?php

    namespace App\Repository\Repositories;

    use App\Repository\Interfaces\ArticleModelInterface;

    class ArticleModelRepository implements ArticleModelInterface
    {
        public function getLabelName( $code )
        {
            return Test::find( $code )->toArray();
        }

        public function isValid( $id )
        {

        }

        public function selectById( $id ){

        }

        public function getAllValid(){

        }

        public function getAllNotSp(){

        }

        public function getAllSp(){

        }
    }