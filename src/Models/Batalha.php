<?php
    class Batalha{

        private array $time;
        private array $timeOpp;
        private int $round;

        function __construct($time){

            $this->time = $time;
            

        }

        static function montaTime($time){
            if($time==1){
                for(int $i=0;$i<6;$i++){
                    $time[$i] = random_int(1,1025);
                }
            }
            for(int $i=0;$i<6;$i++){
                $time[$i] = random_int(1,1025);
            }
        }



    }
?>