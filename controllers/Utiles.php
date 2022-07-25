<?php
namespace controllers;

class Utiles{


    public static function codigoActa(string $lastCode) //2022-520
    {
        date_default_timezone_set('America/Guayaquil');
        $codSeparete = preg_split('/(-)/i',$lastCode);
        $codeNumber = intval($codSeparete[1],10);
        $date = new \DateTime();
        $year = $date->format('Y'); //2023
        
        if($year != $codSeparete[0]){
            $newNumber = 0;
            $newCode = '';
            if($newNumber > 99){
                $newCode = $year . '-' . $newNumber;
            }else if($newNumber > 9){
                $newCode = $year . '-' . '0' . $newNumber;
            }else{
                $newCode = $year . '-' . '00' . $newNumber;
            }

            return $newCode;
        }
        //Aumenta el valor del ultimo codigo que tiene la base de datos si es un solo digito
        // se aumentan dos ceros por defecto si dos digitos un cero y si son tres solo se le suma
        //una unidad
        $newNumber = $codeNumber+1;
        $newCode = '';
        if($newNumber > 99){
            $newCode = $year . '-' . $newNumber;
        }else if($newNumber > 9){
            $newCode = $year . '-' . '0' . $newNumber;
        }else{
            $newCode = $year . '-' . '00' . $newNumber;
        }

        return $newCode;

    }
}

