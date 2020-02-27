<?php

namespace App\Http\Controllers;
use TCG\Voyager\FormFields\AbstractHandler;
use Illuminate\Http\Request;

class CoordinatesFormField extends AbstractHandler
{
    protected $codename = 'coordinates';

    public function createContent($row, $dataType, $dataTypeContent, $options)
    {
        return view('formfields.coordinates', [
            'row' => $row,
            'options' => $options,
            'dataType' => $dataType,
            'dataTypeContent' => $dataTypeContent
        ]);
    }
}
