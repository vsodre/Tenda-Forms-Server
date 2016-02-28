<?php

namespace App\Http\Controllers;

use App\Resposta;
use Excel;

class Respostas extends Controller {
	public function getHtmlShow() {
		return view ( 'admin', [ 
				'page' => 'dados' 
		] );
	}
	public function getAllDates() {
		$respostas = Resposta::raw ();
		$reduce = 'function(o, total){ total.qty++; }';
		$key = 'function(doc){
            var d = new Date(doc.created_at);
            d.setHours(0, 0, 0);
            return {date: d.toISOString().slice(0, 10)}; }';
		return response ()->json ( $respostas->group ( new \MongoCode ( $key ), [ 
				'qty' => 0 
		], $reduce ) ['retval'] );
	}
	public function getExcel($dates) {
		Excel::create ( 'Respostas', function ($excel) use($dates) {
			foreach ( explode ( ',', $dates ) as $date ) {
				$excel->sheet ( $date, function ($sheet) use($date) {
					$respostas = Resposta::raw ();
					$day = new \DateTime ( $date );
					$query ['created_at'] ['$gte'] = new \MongoDate ( $day->getTimestamp () );
					$day->add ( new \DateInterval ( 'P1D' ) );
					$query ['created_at'] ['$lt'] = new \MongoDate ( $day->getTimestamp () );
					$cursor = $respostas->find ( $query, [ 
							'_id' => 0,
							'created_at' => 0,
							'updated_at' => 0 
					] );
					$header = [ ];
					foreach ( $cursor as $resposta ) {
						$fields = array_keys ( $resposta );
						$line = [];
						if ($fields !== $header) {
							$sheet->appendRow ( $fields );
							$header = $fields;
						}
						foreach ( $fields as $f ) {
							if (is_array ( $resposta [$f] )) {
								$line[] = implode ( ', ', $resposta [$f] );
							} else {
								$line [] = $resposta [$f];
							}
						}
						$sheet->appendRow($line);
					}
					$cursor->reset ();
				} );
			}
		} )->export ( 'xlsx' );
	}
}
