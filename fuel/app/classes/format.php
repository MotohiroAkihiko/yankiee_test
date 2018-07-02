<?php
class Format extends Fuel\Core\Format {

    public function to_csv($data = null, $delimiter = null, $enclose_numbers = false, array $headings = array()){
       $csv = parent::to_csv($data);
       $csv = mb_convert_encoding($csv, 'SJIS-win', 'UTF-8');
       return $csv;
  }

}