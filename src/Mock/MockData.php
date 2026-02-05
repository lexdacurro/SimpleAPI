<?php 
    namespace SimpleApi\Mock;
    class MockData{
        public $mockData = ["Greetings" => "Hello"];
        public function generateMock($input){
            return $this->mockData;
        }
    }
?>