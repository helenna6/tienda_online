<?php
    class Order{
        private $order_id;
        private $user_id;
        private $order_date;
        private $total_amount;
        private $status;
        private $orderLines=[];

        public function __construct($order_id, $user_id, $order_date, $total_amount, $status){
            $this->order_id = $order_id;
            $this->user_id = $user_id;
            $this->order_date = $order_date;
            $this->total_amount = $total_amount;
            $this->status = $status;
            $this->orderLines = OrderLineRepository::getOrderLinesByOrderId($order_id);
        }

        public function getOrderId(){
            return $this->order_id;
        }

        public function setOrderId($order_id){
            $this->order_id = $order_id;
        }

        public function getUserId(){
            return $this->user_id;
        }

        public function setUserId($user_id){
            $this->user_id = $user_id;
        }

        public function getOrderDate(){
            return $this->order_date;
        }

        public function setOrderDate($order_date){
            $this->order_date = $order_date;
        }

        public function getTotalAmount(){
            return $this->total_amount;
        }

        public function setTotalAmount($total_amount){
            $this->total_amount = $total_amount;
        }

        public function getStatus(){
            return $this->status;
        }

        public function setStatus($status){
            $this->status = $status;
        }
    }