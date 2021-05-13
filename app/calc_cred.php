<?php
// KONTROLER strony kalkulatora
require_once dirname(__FILE__).'/../config.php';

// W kontrolerze niczego nie wysyła się do klienta.
// Wysłaniem odpowiedzi zajmie się odpowiedni widok.
// Parametry do widoku przekazujemy przez zmienne.

// 1. pobranie parametrów

$value = $_REQUEST ['value'];
$years = $_REQUEST ['years'];
$percent = $_REQUEST ['percent'];

// 2. walidacja parametrów z przygotowaniem zmiennych dla widoku

// sprawdzenie, czy parametry zostały przekazane
if ( ! (isset($value) && isset($years) && isset($percent))) {
	//sytuacja wystąpi kiedy np. kontroler zostanie wywołany bezpośrednio - nie z formularza
	$messages [] = 'Błędne wywołanie aplikacji. Brak jednego z parametrów.';
}

// sprawdzenie, czy potrzebne wartości zostały przekazane
if ( $value == "") {
	$messages [] = 'Nie podano kwoty';
}
if ( $years == "") {
	$messages [] = 'Nie podano okresu spłaty';
}
if ( $percent == "") {
	$messages [] = 'Nie podano oprocentowania';
}


//nie ma sensu walidować dalej gdy brak parametrów
if (empty( $messages )) {
	
	// sprawdzenie, czy $x i $y są liczbami całkowitymi
	if (! is_numeric( $value )) {
		$messages [] = 'Pierwsza wartość nie jest liczbą całkowitą';
	}
	
	if (! is_numeric( $years )) {
		$messages [] = 'Druga wartość nie jest liczbą całkowitą';
	}	
	
	if (! ((is_numeric( $percent )) &($percent>=0))) {
		$messages [] = 'Trzecia wartość nie jest liczbą';
	}

}

// 3. wykonaj zadanie jeśli wszystko w porządku

if (empty ( $messages )) { // gdy brak błędów
	
	//konwersja parametrów na int
	$value = intval($value);
	$years = intval($years);
	$percent = floatval($percent);
	
	//wykonanie operacji
	$result=(1+$percent/100)*($value/($years*12));
}

// 4. Wywołanie widoku z przekazaniem zmiennych
// - zainicjowane zmienne ($messages,$x,$y,$operation,$result)
//   będą dostępne w dołączonym skrypcie
include 'calc_cred_view.php';