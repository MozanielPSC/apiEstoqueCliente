<?php
    namespace App\Helpers;
    class Dimensao{
        const TIPO_ENVELOPE      = '001';
        const TIPO_PACOTE_CAIXA  = '002';
        const TIPO_ROLO_CILINDRO = '003';
        /**
         * Deve ser uma das constantes Tipo*.
         */
        protected int $tipo;
        /**
         *  centímetros.
         */
        protected float $altura;
        /**
         *  centímetros.
         */
        protected float $largura;
        /**
         *  centímetros.
         */
        protected float $comprimento;

        //  centímetros.
        protected float $diametro;
    
        // centímetros
        public function setAltura(float $altura)
        {
            $this->altura = (float)$altura;
        }
    
        // Centímetros  
        public function getAltura()
        {
            return $this->altura;
        }
    
        /**
         * @param float $comprimento
         *       centímetros
         */
        public function setComprimento($comprimento)
        {
            $this->comprimento = (float)$comprimento;
        }
    
        /**
         * @return float
         *       centímetros
         */
        public function getComprimento()
        {
            return $this->comprimento;
        }
    
        /**
         * @param float $diametro
         *       centímetros
         */
        public function setDiametro($diametro)
        {
            $this->diametro = (float)$diametro;
        }
    
        /**
         * @return float
         *       centímetros
         */
        public function getDiametro()
        {
            return $this->diametro;
        }
    
        /**
         * @param float $largura
         *       centímetros
         */
        public function setLargura($largura)
        {
            $this->largura = (float)$largura;
        }
    
        /**
         * @return float
         *       centímetros
         */
        public function getLargura()
        {
            return $this->largura;
        }
    
        /**
         * @param int $tipo
         */
        public function setTipo($tipo)
        {
            $this->tipo = $tipo;
        }
    
        /**
         * @return int
         */
        public function getTipo()
        {
            return $this->tipo;
        }
    }