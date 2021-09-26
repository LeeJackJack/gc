<?php

    namespace App\Repository\Interfaces;

    interface ArticleModelInterface
    {
        public function getCity( );

        public function getDistrict( );

        public function getEdu( );

        public function getType( );

        public function isValid( $id );

        public function selectById( $id );

        public function getAllValid();

        public function getAllNotSp();

        public function getAllSp();

    }