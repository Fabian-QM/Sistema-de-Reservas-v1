<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidRut implements Rule
{
    public function passes($attribute, $value)
    {
        // Limpiar el RUT
        $rut = preg_replace('/[^0-9kK]/', '', $value);
        
        if (strlen($rut) < 8) {
            return false;
        }
        
        $dv = substr($rut, -1);
        $numero = substr($rut, 0, -1);
        
        $suma = 0;
        $multiplo = 2;
        
        for ($i = strlen($numero) - 1; $i >= 0; $i--) {
            $suma += $numero[$i] * $multiplo;
            $multiplo = $multiplo < 7 ? $multiplo + 1 : 2;
        }
        
        $dvCalculado = 11 - ($suma % 11);
        if ($dvCalculado == 11) $dvCalculado = '0';
        if ($dvCalculado == 10) $dvCalculado = 'K';
        
        return strtoupper($dv) == strtoupper($dvCalculado);
    }

    public function message()
    {
        return 'El RUT ingresado no es válido. Formato: 12.345.678-9';
    }
}